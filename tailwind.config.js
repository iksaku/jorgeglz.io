module.exports = {
  purge: [],
  darkMode: 'media',
  theme: {
    extend: {},
  },
  variants: {
    extend: {
      borderColor: ['hocus'],
      textColor: ['hocus'],
    },
  },
  plugins: [
    require('@iksaku/tailwindcss-plugins/src/hocus'),
    require('@iksaku/tailwindcss-plugins/src/smoothScroll'),
    require('@tailwindcss/typography'),
  ],
}
