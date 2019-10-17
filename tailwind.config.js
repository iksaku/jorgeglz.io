module.exports = {
    theme: {
        extend: {}
    },
    variants: {
        backgroundColor: ['hover', 'focus', 'disabled'],
        borderColor: ['hover', 'focus', 'disabled'],
        cursor: ['hover', 'focus', 'disabled'],
        opacity: ['hover', 'focus', 'disabled'],
        textColor: ['hover', 'focus', 'disabled']
    },
    plugins: [
        require('@tailwindcss/custom-forms')
    ]
}
