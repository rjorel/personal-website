const mix = require('laravel-mix');

const CompressionPlugin = require('compression-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const ImageminWebpWebpackPlugin = require('imagemin-webp-webpack-plugin');

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

mix.webpackConfig({
    plugins: [
        new CompressionPlugin(),

        new CopyWebpackPlugin([
            {
                from: 'assets/img',
                to: 'images'
            }
        ]),

        new ImageminWebpWebpackPlugin({
            overrideExtension: false
        })
    ]
});

mix
    .setPublicPath('www')
    .sass('assets/sass/app.scss', 'www/css')
    .js('assets/js/app.js', 'www/js');

if (mix.inProduction()) {
    mix.version();
} else {
    mix.sourceMaps();
}
