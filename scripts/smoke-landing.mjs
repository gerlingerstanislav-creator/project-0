import assert from 'node:assert/strict';
import { mkdir } from 'node:fs/promises';
import { chromium } from 'playwright';

const siteUrl = process.env.SITE_URL || 'https://project-0.duckdns.org/put-bez-pregrad';
const screenshotDir = 'output/landing-smoke';
await mkdir(screenshotDir, { recursive: true });

const browser = await chromium.launch({ headless: true });
const sizes = [
  { label: 'desktop', width: 1600, height: 940 },
  { label: 'laptop', width: 1280, height: 800 },
  { label: 'tablet', width: 768, height: 980 },
  { label: 'mobile', width: 390, height: 844 },
  { label: 'small-mobile', width: 320, height: 700 },
];

try {
  for (const viewport of sizes) {
    const page = await browser.newPage({
      viewport: { width: viewport.width, height: viewport.height },
      deviceScaleFactor: viewport.label.includes('mobile') ? 2 : 1,
      reducedMotion: 'reduce',
    });
    const errors = [];
    page.on('pageerror', err => errors.push('JavaScript: ' + err.message));
    page.on('response', resp => {
      if (resp.url().includes('/images/') && !resp.ok()) {
        errors.push('Image HTTP ' + resp.status() + ': ' + resp.url());
      }
    });

    const response = await page.goto(siteUrl, { waitUntil: 'domcontentloaded', timeout: 60000 });
    assert.equal(response?.status(), 200, 'Public landing must load anonymously');
    await page.locator('h1').waitFor({ state: 'visible', timeout: 20000 });

    assert.equal(await page.locator('.fleet-card img').count(), 3, 'Three gallery photos expected');
    assert.equal(await page.locator('.hero__phone').getAttribute('href'), 'tel:+78422717303');
    assert.equal(await page.locator('.header-phones a').nth(1).getAttribute('href'), 'tel:+79677717303');
    assert.ok((await page.locator('.max-link').first().getAttribute('href')).startsWith('https://max.ru/'));
    assert.equal(await page.locator('.request-form button[type="submit"]').isEnabled(), true);

    const gallery = page.locator('.fleet-card img');
    for (let i = 0; i < 3; i++) {
      await gallery.nth(i).scrollIntoViewIfNeeded();
      await page.waitForFunction(index => {
        const img = document.querySelectorAll('.fleet-card img')[index];
        return img?.complete && img.naturalWidth >= 800;
      }, i, { timeout: 20000 });
    }

    const overflow = await page.evaluate(() => Math.max(document.documentElement.scrollWidth, document.body.scrollWidth) - window.innerWidth);
    assert.ok(overflow <= 2, 'No horizontal overflow: ' + overflow + 'px (' + viewport.label + ')');

    if (viewport.width <= 1460) {
      const toggle = page.locator('.menu-toggle');
      assert.equal(await toggle.isVisible(), true, 'Responsive navigation button must be visible');
      await toggle.click();
      const nav = page.locator('#landing-navigation');
      await nav.waitFor({ state: 'visible' });
      await nav.locator('a[href="#destinations"]').click();
      await nav.waitFor({ state: 'hidden' });
      const destination = await page.locator('#destinations').boundingBox();
      const header = await page.locator('.site-header').boundingBox();
      assert.ok(destination && header && destination.y >= header.y + header.height - 10,
        'Sticky header must not hide target section');
    } else {
      assert.equal(await page.locator('.header-nav').isVisible(), true, 'Desktop navigation must be visible');
    }

    await page.evaluate(() => window.scrollTo(0, 1300));
    const sticky = await page.locator('.site-header').boundingBox();
    assert.ok(sticky && Math.abs(sticky.y) < 3, 'Header must remain fixed while scrolling');
    assert.deepEqual(errors, [], 'No runtime JavaScript errors or missing images');

    await page.screenshot({ path: `${screenshotDir}/${viewport.label}.png`, fullPage: true });
    console.log('PASS', viewport.label, viewport.width + 'x' + viewport.height);
    await page.close();
  }
} finally {
  await browser.close();
}
