<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicTransportLandingTest extends TestCase
{
    public function test_landing_gallery_contains_real_images_instead_of_tiny_placeholders(): void
    {
        foreach (['accessible-van', 'accessible-passenger', 'accessible-boarding'] as $image) {
            $path = public_path("images/{$image}.avif");

            $this->assertFileExists($path);
            $this->assertGreaterThan(20000, filesize($path), "{$image} image should not be a placeholder");
        }
    }

    public function test_public_landing_has_isolated_brand_assets(): void
    {
        foreach (['logo.svg', 'logo-light.svg', 'favicon.svg'] as $filename) {
            $this->assertFileExists(public_path("images/put-bez-pregrad/{$filename}"));
        }

        $this->get('/put-bez-pregrad')->assertOk()->assertSee('PutBezPregrad');
    }
}
