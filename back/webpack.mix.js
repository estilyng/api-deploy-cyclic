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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');


// mix.styles([
//     'resources/views/site/css/bootstrap.css',
//     'resources/views/site/css/fontawesome-all.css',
//     'resources/views/site/css/magnific-popup.css',
//     'resources/views/site/css/swiper.css',
//     'resources/views/site/css/styles.css',
// ], 'public/css/site.css')

// mix.copy([
//     'resources/views/site/js/bootstrap.min.js',
//     'resources/views/site/js/jquery.min.js',
//     'resources/views/site/js/jquery.easing.min.js',
//     'resources/views/site/js/jquery.magnific-popup.js',
//     'resources/views/site/js/popper.min.js',
//     'resources/views/site/js/swiper.min.js',
//     'resources/views/site/js/validator.min.js',
//     'resources/views/site/js/scripts.js',
// ], 'public/js/')

// mix.browserSync({
//     proxy: 'localhost:8000'
// })