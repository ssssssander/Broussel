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

mix.webpackConfig({
    resolve: {
        alias: {
            '@': __dirname + '/resources'
        },
    },
});

mix.options({
    globalVueStyles: 'resources/sass/_variables.scss',
});

mix.browserSync('http://localhost:8000');
mix.disableSuccessNotifications();

mix.ts('resources/js/app.ts', 'public/js/app.js')
    .sass('resources/sass/global.scss', 'public/css/global.css')
    .styles(
        [
            'public/css/global.css',
            'node_modules/ant-design-vue/lib/message/style/index.css',
            'node_modules/node_modules/ant-design-vue/lib/notification/style/index.css',
            'node_modules/ant-design-vue/lib/date-picker/style/index.css',
            'node_modules/ant-design-vue/lib/time-picker/style/index.css',
            'node_modules/ant-design-vue/lib/input/style/index.css',
            'node_modules/ant-design-vue/lib/calendar/style/index.css',
            'node_modules/ant-design-vue/lib/select/style/index.css',
            'node_modules/ant-design-vue/lib/radio/style/index.css',
            'node_modules/ant-design-vue/lib/skeleton/style/index.css',
            'node_modules/ant-design-vue/lib/divider/style/index.css',
            'node_modules/ant-design-vue/lib/collapse/style/index.css',
        ], 'public/css/app.css');

if(mix.inProduction()) {
    mix.version();
}
