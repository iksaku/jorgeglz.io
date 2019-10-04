const mix = require('laravel-mix')
require('laravel-mix-purgecss')

mix
    // .js('resources/js/app.js', 'public/js')
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
