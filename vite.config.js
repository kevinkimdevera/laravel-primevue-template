import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [
    // Laravel Vite Plugin
    laravel({
      input: [
        'resources/sass/app.scss',
        'resources/js/app.js'
      ],
      refresh: true,
    }),

    // Vue Plugin
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
});
