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

mix.react('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
    .styles([
        'resources/css/bootstrap.min.css',
        'resources/css/owl.carousel.min.css',
        'resources/css/magnific-popup.css',
        'resources/css/font-awesome.min.css',
        'resources/css/themify-icons.css',
        'resources/css/nice-select.css',
        'resources/css/flaticon.css',
        'resources/css/gijgo.css',
        'resources/css/animate.css',
        'resources/css/slick.css',
        'resources/css/slicknav.css',
        'resources/css/jquery-ui.css',
        'resources/css/style.css',
    ], 'public/css/all.css');

mix.extract();

mix.disableNotifications();
