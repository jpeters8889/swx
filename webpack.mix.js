let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

mix.js('resources/js/app.js', 'public/assets')
    .extract()
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('tailwind.config.js')],
    })
    .sass('resources/scss/app.scss', 'public/assets')
    .version()
    .webpackConfig({devtool: "inline-source-map"});
