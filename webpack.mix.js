const mix = require('laravel-mix')
require('laravel-mix-purgecss')

mix.disableNotifications()

mix.js('resources/js/App/app.js', 'public/js')
    .js('resources/js/Dashboard/dashboard.js', 'public/js')
    .postCss('resources/styles/app.pcss', 'public/css', [
        require('tailwindcss')('tailwind.config.js'),
        require('postcss-nested')
   ])
    .purgeCss()

if (mix.inProduction()) {
    mix.version()
}
