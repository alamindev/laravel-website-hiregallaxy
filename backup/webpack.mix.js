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

mix.sass('resources/sass/custom/main.scss', 'public/css/main.css').options({
    processCssUrls: false
});
mix.js('resources/js/custom/postjob.js', 'public/js')
mix.js('resources/js/custom/job-application.js', 'public/js')
