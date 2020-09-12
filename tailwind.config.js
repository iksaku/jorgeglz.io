const defaultConfig = require('tailwindcss/defaultConfig')

module.exports = {
    purge: {
        content: [
            'resources/views/**/*.php'
        ],
        options: {
            whitelistPatternsChildren: [
                /markdown$/
            ]
        }
    },
    theme: {
        extend: {
            fontFamily: {
                emoji: ['Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji']
            },
            inset: theme => ({
                4: theme('spacing.4')
            }),
            screens: {
                'dark': { raw: '(prefers-color-scheme: dark)' }
            }
        }
    },
    variants: {
        backgroundColor: [...defaultConfig.variants.backgroundColor, 'hocus'],
        borderColor: [...defaultConfig.variants.borderColor, 'hocus'],
        borderWidth: [...defaultConfig.variants.borderWidth, 'last', 'hocus'],
        boxShadow: [...defaultConfig.variants.boxShadow, 'focus-within', 'hocus'],
        cursor: [...defaultConfig.variants.cursor, 'hover', 'focus'],
        fontWeight: [...defaultConfig.variants.fontWeight, 'hocus'],
        margin: [...defaultConfig.variants.margin, 'last'],
        textColor: [...defaultConfig.variants.textColor, 'hocus'],
        scale: [...defaultConfig.variants.scale, 'hocus'],
        zIndex: [...defaultConfig.variants.zIndex, 'hover']
    },
    plugins: [
        require('@tailwindcss/ui'),
        require('@tailwindcss/custom-forms'),
        require('@iksaku/tailwindcss-plugins/src/borderXY'),
        require('@iksaku/tailwindcss-plugins/src/hocus'),
        require('@iksaku/tailwindcss-plugins/src/interFontFamily'),
        require('@iksaku/tailwindcss-plugins/src/markdown'),
        require('@iksaku/tailwindcss-plugins/src/smoothScroll'),
    ]
}
