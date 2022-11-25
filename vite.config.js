import { defineConfig } from 'vite';
import purgeCss from '@fullhuman/postcss-purgecss';

export default defineConfig({
  base: '/build/',
  publicDir: false,

  build: {
    assetsInlineLimit: 0,
    manifest: true,
    outDir: './www/build',

    rollupOptions: {
      input: [
        './resources/sass/app.scss',

        './resources/js/app.js',
        './resources/js/repository.js'
      ]
    }
  },

  css: {
    postcss: {
      plugins: [
        purgeCss({
          content: [
            './resources/**/*.js',
            './templates/**/*.html.twig'
          ],
          safelist: [
            'collapsing',        // Menu.
            /^img-(start|end)$/  // Repository images.
          ]
        })
      ]
    }
  }
});
