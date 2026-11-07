import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const repo = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const source = path.join(repo, 'resources/js/pages/PutBezPregrad.vue');
const generatedDir = path.join(repo, 'timeweb/generated');
const publicDir = path.join(repo, 'timeweb/public');
let component = fs.readFileSync(source, 'utf8');

// The standalone landing is the existing Vue page, without Inertia's server shell.
const headImport = /import\s*\{\s*Head\s*\}\s*from\s*['"]@inertiajs\/vue3['"];?/;
const headBlock = /<Head\b[^>]*>[\s\S]*?<\/Head>/;
if (!headImport.test(component) || !headBlock.test(component)) {
  throw new Error('The landing Head markup changed: review the standalone adapter.');
}
component = component.replace(headImport, '');
component = component.replace(headBlock, '');
component = component.replaceAll("'../components/TransportIcon.vue'", "'../../resources/js/components/TransportIcon.vue'");
component = component.replaceAll("'../components/MaxIcon.vue'", "'../../resources/js/components/MaxIcon.vue'");
if (component.includes('@inertiajs') || component.includes('<Head')) {
  throw new Error('Standalone page still depends on Inertia.');
}
fs.mkdirSync(generatedDir, { recursive: true });
fs.writeFileSync(path.join(generatedDir, 'PutBezPregrad.vue'), component);

const imageFiles = [
  'accessible-van.avif',
  'accessible-passenger.avif',
  'accessible-boarding.avif',
  'put-bez-pregrad/favicon.svg',
  'put-bez-pregrad/logo.svg',
  'put-bez-pregrad/logo-light.svg',
  'put-bez-pregrad/mark.svg',
];
for (const file of imageFiles) {
  const src = path.join(repo, 'public/images', file);
  const dst = path.join(publicDir, 'images', file);
  fs.mkdirSync(path.dirname(dst), { recursive: true });
  fs.copyFileSync(src, dst);
}
console.log('Standalone landing prepared with ' + imageFiles.length + ' local image assets.');
