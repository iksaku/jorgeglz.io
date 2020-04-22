const defaultConfig = require('tailwindcss/defaultConfig')

module.exports = {
    theme: {
        extend: {
            borderWidth: {

            },
            fontFamily: {
                sans: ['Inter', ...defaultConfig.theme.fontFamily.sans],
                emoji: ['Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji']
            },
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
