const mix = require('laravel-mix')
require('laravel-mix-purgecss')

mix.disableSuccessNotifications()

mix.js('resources/js/app.js', 'public/js')
    .extract()
    .postCss('resources/styles/app.pcss', 'public/css', [
        require('tailwindcss')('tailwind.config.js'),
        require('postcss-nested')
   ])
    .purgeCss({
        whitelistPatternsChildren: [
            /md_content$/
        ]
    })

if (mix.inProduction()) {
    mix.version()
}
