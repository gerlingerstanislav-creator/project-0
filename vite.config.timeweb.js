import { fileURLToPath } from 'node:url';
import path from 'node:path';
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

const root = path.dirname(fileURLToPath(import.meta.url));

export default defineConfig({
  root: path.join(root, 'timeweb'),
  base: '/',
  publicDir: path.join(root, 'timeweb/public'),
  plugins: [tailwindcss(), vue()],
  build: {
    outDir: path.join(root, 'dist-timeweb'),
    emptyOutDir: true,
  },
});
