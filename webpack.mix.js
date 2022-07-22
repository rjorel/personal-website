const mix = require('laravel-mix');

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
  .sass('assets/sass/app.scss', 'www/css/')
  .js('assets/js/app.js', 'www/js/')
  .js('assets/js/repository.js', 'www/js/')
  .copyDirectory('assets/images', 'www/images');

if (mix.inProduction()) {
  mix.version()
    .options({
      postCss: [
        require('@fullhuman/postcss-purgecss')(require('./purgecss.config'))
      ]
    });
} else {
  mix.sourceMaps();
}
