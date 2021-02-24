let mix = require('laravel-mix');

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

mix.sass('public/scss/mdb-pro.scss', 'public/css/mdb.min.css');
    // .js([
    //     // 'resources/assets/js/app.js',
    //     // 'node_modules/jquery/dist/jquery.min.js',
    //     // 'node_modules/jquery-datetimepicker/build/jquery.datetimepicker.full.min.js',
    //     // 'node_modules/lightgallery.js/dist/js/lightgallery.min.js',
    //     // 'node_modules/magnific-popup/dist/jquery.magnific-popup.min.js',
    //     // 'node_modules/bootstrap/dist/js/bootstrap.js',
    // ], 'public/js')
    // .js('node_modules/jquery/dist/jquery.min.js', 'public/js')
    // .js('node_modules/materialize-css/dist/js/materialize.js', 'public/js')
    // .sass('resources/assets/sass/app.scss', 'public/css').

