const plugin = require('tailwindcss/plugin')

module.exports = plugin(({ addComponents, addVariant, e, theme }) => {
    addVariant('hocus', ({ modifySelectors, separator }) => {
        modifySelectors(({ className }) =>
            ['hover', 'focus'].map(variant => `.${e(`hocus${separator}${className}`)}:${variant}`).join(',')
        )
    })
})
