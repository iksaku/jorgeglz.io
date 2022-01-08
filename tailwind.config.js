module.exports = {
  content: [
    './src/pages/**/*.{js,ts,jsx,tsx,md,mdx}',
    './src/components/**/*.{js,ts,jsx,tsx,md,mdx}',
  ],

  darkMode: 'media', // or 'media' or 'class'

  theme: {},

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
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
  ],
}
