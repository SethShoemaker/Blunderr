const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
    stats: {
        children: true
    }
});

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')

    // Welcome
    .sass('resources/sass/welcome.scss', 'public/css')

    // Auth
    .sass('resources/sass/auth/auth.scss', 'public/css/auth')

    // Dashboard
    .sass('resources/sass/dashboard/dashboard.scss', 'public/css/dashboard')
    .sass('resources/sass/dashboard/home.scss', 'public/css/dashboard')
    .js('resources/js/dashboard.js', 'public/js')

;