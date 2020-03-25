const defaultConfig = require('tailwindcss/defaultConfig')

module.exports = {
    theme: {
        extend: {}
    },
    variants: {
        backgroundColor: [...defaultConfig.variants.backgroundColor, 'hocus'],
        borderColor: [...defaultConfig.variants.borderColor, 'hocus'],
        borderWidth: [...defaultConfig.variants.borderWidth, 'last'],
        cursor: [...defaultConfig.variants.cursor, 'hover', 'focus'],
        fontWeight: [...defaultConfig.variants.fontWeight, 'hocus'],
        textColor: [...defaultConfig.variants.textColor, 'hocus'],
        scale: [...defaultConfig.variants.scale, 'hocus']
    },
    plugins: [
        require('@tailwindcss/custom-forms'),
        function ({ addVariant, e }) {
            addVariant('hocus', ({ modifySelectors, separator}) => {
                modifySelectors(({ className }) => {
                    return `.${e(`hocus${separator}${className}`)}:hover,.${e(`hocus${separator}${className}`)}:focus`
                })
            })
        }
    ]
}
