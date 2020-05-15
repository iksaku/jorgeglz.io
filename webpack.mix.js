const mix = require('laravel-mix')

mix
    .js('resources/js/alpine.js', 'public/js')

    .js('resources/js/fontawesome.js', 'public/js')

    .js('resources/js/highlight.js', 'public/js')
    .postCss('resources/styles/highlight.pcss', 'public/css')

    .postCss('resources/styles/app.pcss', 'public/css', [
        require('tailwindcss'),
        require('postcss-nested'),
        require('autoprefixer')
    ])

if (mix.inProduction()) {
    mix.version()
}
