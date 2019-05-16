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

mix.options({
    extractVueStyles: true,
    globalVueStyles: 'resources/sass/_variables.scss',
});

mix.browserSync('http://localhost:8000');
mix.disableSuccessNotifications();

mix.js('resources/js/app.js', 'public/js')
    .styles([
    'public/css/normalize.css',
    'public/css/vue-styles.css'
    ], 'public/css/app.css');

if(mix.inProduction()) {
    mix.version();
}
