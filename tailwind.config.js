module.exports = {
  content: [
    './src/pages/**/*.{js,ts,jsx,tsx,md,mdx}',
    './src/components/**/*.{js,ts,jsx,tsx,md,mdx}',
  ],

  darkMode: 'media', // or 'media' or 'class'

  theme: {
    extend: {
      typography: ({ theme }) => ({
        DEFAULT: {
          css: {
            a: {
              textDecorationColor: theme('colors.blue[500]'),
              textDecorationThickness: theme('textDecorationThickness.2'),
            },

            '--tw-prose-body': theme('colors.gray[900]'),
            '--tw-prose-invert-body': theme('colors.gray[100]'),
            '--tw-prose-quotes': theme('colors.gray[600]'),
            '--tw-prose-invert-quotes': theme('colors.gray[300]'),
            '--tw-prose-quote-borders': theme('colors.teal[600]'),
            '--tw-prose-invert-quote-borders': theme('colors.teal[900]'),

            ':is(h1,h2,h3,h4,h5,h6) > a': {
              textDecorationColor: theme('colors.gray[400]'),
            },
          },
        },
      }),
    },
  },

  variants: {
    extend: {
      textColor: ['hocus'],
    },
  },

  plugins: [
    require('@iksaku/tailwindcss-plugins/plugins/hocus'),
    require('@iksaku/tailwindcss-plugins/plugins/interFontFamily'),
    require('@iksaku/tailwindcss-plugins/plugins/smoothScroll'),
    require('@tailwindcss/typography'),
  ],
}
