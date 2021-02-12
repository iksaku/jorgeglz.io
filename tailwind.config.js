const colors = require('tailwindcss/colors')

module.exports = {
  purge: {
    content: [
      './src/pages/**/*.{js,ts,jsx,tsx,md,mdx}',
      './src/components/**/*.{js,ts,jsx,tsx,md,mdx}',
    ],
    options: {
      safelist: {
        deep: [/prose/],
      },
    },
  },

  presets: [require('@iksaku/tailwindcss-plugins/presets/typography')],

  darkMode: 'media', // or 'media' or 'class'

  theme: {
    colors: {
      transparent: 'transparent',
      white: colors.white,
      black: colors.black,
      gray: colors.coolGray,
      blue: colors.blue,
    },
  },

  variants: {
    extend: {
      textColor: ['hocus'],
    },
  },

  plugins: [
    require('@iksaku/tailwindcss-plugins/plugins/borderXY'),
    require('@iksaku/tailwindcss-plugins/plugins/hocus'),
    require('@iksaku/tailwindcss-plugins/plugins/interFontFamily'),
    require('@iksaku/tailwindcss-plugins/plugins/smoothScroll'),
  ],
}
