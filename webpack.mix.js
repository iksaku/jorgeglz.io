const mix = require('laravel-mix')
require('laravel-mix-purgecss')

mix
    .js('resources/js/app.js', 'public/js')
    .postCss('resources/styles/app.pcss', 'public/css', [
        require('tailwindcss'),
        require('postcss-nested')
    ])
    .sourceMaps()
    .babelConfig({
        plugins: [
            '@babel/plugin-syntax-dynamic-import'
        ]
    })
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.md$/i,
                    use: 'raw-loader'
                }
            ]
        },
        output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
        resolve: {
            alias: {
                vue$: 'vue/dist/vue.runtime.esm.js',
                '@': path.resolve('resources/js')
            }
        }
    })

if (mix.inProduction()) {
    mix
        .purgeCss({
            whitelistPatternsChildren: [
                /markdown$/
            ]
        })
        .version()
}
