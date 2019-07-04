const mix = require('laravel-mix')
const tailwind = require('tailwindcss')
require('laravel-mix-purgecss')

mix.disableSuccessNotifications()

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/styles/app.pcss', 'public/css', [
       tailwind()
   ])
    .purgeCss()

if (mix.inProduction()) {
    mix.version()
}
