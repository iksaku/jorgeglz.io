const colors = require('tailwindcss/colors')

module.exports = {
  darkMode: 'media',

  theme: {
    extend: {
      typography: {
        light: {
          css: [
            {
              color: colors.gray['200'],
              a: {
                color: colors.blue['300'],
                '&:hover,&:focus': {
                  color: colors.blue['500'],
                },
              },
              strong: {
                color: colors.white,
              },
              'ol > li::before': {
                color: colors.gray['300'],
              },
              'ul > li::before': {
                backgroundColor: colors.gray['500'],
              },
              hr: {
                borderColor: colors.gray['100'],
              },
              blockquote: {
                color: colors.gray['100'],
                borderLeftColor: colors.gray['500'],
              },
              h1: {
                color: colors.white,
              },
              h2: {
                color: colors.white,
              },
              h3: {
                color: colors.white,
              },
              h4: {
                color: colors.white,
              },
              'figure figcaption': {
                color: colors.gray['300'],
              },
              code: {
                color: colors.white,
              },
              'a code': {
                color: colors.white,
              },
              pre: {
                color: colors.gray['100'],
                backgroundColor: colors.gray['800'],
              },
              thead: {
                color: colors.white,
                borderBottomColor: colors.gray['300'],
              },
              'tbody tr': {
                borderBottomColor: colors.gray['500'],
              },
            },
          ],
        },
      },
    },
  },

  variants: {
    extend: {
      typography: ['dark'],
    },
  },

  plugins: [require('@tailwindcss/typography')],
}
