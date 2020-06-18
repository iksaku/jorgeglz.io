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
                sans: ['Inter var', ...defaultConfig.theme.fontFamily.sans],
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
        scale: [...defaultConfig.variants.scale, 'hocus']
    },
    plugins: [
        require('@tailwindcss/custom-forms'),
        ...require('@iksaku/tailwindcss-plugins')
    ]
}
