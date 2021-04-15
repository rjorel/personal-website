const path = require('path');
const mix = require('laravel-mix');

require('laravel-mix-purgecss');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
  .setPublicPath('www')
  .sass('assets/sass/app.scss', 'www/css/app.css')
  .js('assets/js/app.js', 'www/js/app.js')
  .copyDirectory('assets/img', 'www/images')
  .purgeCss({
    content: [path.join(__dirname, 'templates/**/*.html.twig')],
    safelist: [
      'collapsing',         // Menu.
      /^img-(start|end)$/   // Repository images.
    ]
  });

if (mix.inProduction()) {
  mix.version();
} else {
  mix.sourceMaps();
}
