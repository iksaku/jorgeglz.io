const mix = require('laravel-mix')
require('laravel-mix-purgecss')

mix
    .js('resources/js/alpine.js', 'public/js')
    .js('resources/js/fontawesome.js', 'public/js')
    .postCss('resources/styles/app.pcss', 'public/css', [
        require('tailwindcss'),
        require('postcss-nested')
    ])

if (mix.inProduction()) {
    mix
        .purgeCss({
            whitelistPatternsChildren: [
                /markdown$/
            ]
        })
        .version()
}
