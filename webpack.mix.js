const mix = require('laravel-mix')
const tailwind = require('tailwindcss')
require('laravel-mix-purgecss')

mix.disableNotifications()

mix.js('resources/js/App/app.js', 'public/js')
    .js('resources/js/Dashboard/dashboard.js', 'public/js')
    .postCss('resources/styles/app.pcss', 'public/css', [
       tailwind('tailwind.config.js')
   ])
    .purgeCss()

if (mix.inProduction()) {
    mix.version()
}
