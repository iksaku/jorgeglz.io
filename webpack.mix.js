const mix = require('laravel-mix')

const purgecss = require('@fullhuman/postcss-purgecss')({
    content: [
        'resources/views/**/*.php'
    ],
    defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || [],
    whitelistPatternsChildren: [
        /markdown$/
    ]
})

mix
    .js('resources/js/alpine.js', 'public/js')

    .js('resources/js/fontawesome.js', 'public/js')

    .js('resources/js/highlight.js', 'public/js')
    .postCss('resources/styles/highlight.pcss', 'public/css')

    .postCss('resources/styles/app.pcss', 'public/css', [
        require('tailwindcss'),
        require('postcss-nested'),
        require('autoprefixer'),
        ...process.env.NODE_ENV === 'production' ? [purgecss] : []
    ])

if (mix.inProduction()) {
    mix.version()
}
