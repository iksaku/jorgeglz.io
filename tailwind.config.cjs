const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./src/**/*.{astro,html,js,jsx,md,mdx,svelte,ts,tsx,vue}'],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter Variable', ...defaultTheme.fontFamily.sans],
        mono: ['JetBrains Mono Variable', ...defaultTheme.fontFamily.mono]
      },

      typography: ({ theme }) => ({
        DEFAULT: {
          css: {
            '--tw-prose-body': theme('colors.white'),
            '--tw-prose-headings': theme('colors.orange[300]'),
            // '--tw-prose-lead': theme('colors.gray[100]'),
            '--tw-prose-links': theme('colors.orange[300]'),
            '--tw-prose-bold': theme('colors.white'),
            '--tw-prose-counters': theme('colors.gray[400]'),
            '--tw-prose-bullets': theme('colors.gray[400]'),
            '--tw-prose-hr': theme('colors.gray[400]'),
            '--tw-prose-quotes': theme('colors.gray[300]'),
            '--tw-prose-quote-borders': theme('colors.orange[300]'),
            '--tw-prose-captions': theme('colors.gray[300]'),
            '--tw-prose-code': theme('colors.white'),
            // '--tw-prose-pre-code': theme('colors.white'),
            // '--tw-prose-pre-bg': theme('colors.white'),
            '--tw-prose-th-borders': theme('colors.orange[100]'),
            '--tw-prose-td-borders': theme('colors.gray[500]'),

            a: {
              fontWeight: theme('fontWeight.normal'),
            },

            code: {
              backgroundColor: theme('colors.zinc[700]'),
              borderRadius: theme('borderRadius.DEFAULT'),
              fontWeight: theme('fontWeight.semibold'),
              padding: theme('padding[1]'),
            },
            "code::before": false,
            "code::after": false,

            img: {
              marginLeft: 'auto',
              marginRight: 'auto',
            },

            strong: {
              fontWeight: theme('fontWeight.bold'),
              letterSpacing: theme('letterSpacing.wide'),
            },

            ':is(h1,h2,h3,h4,h5,h6) > a': {
              color: 'var(--tw-prose-headings)',
              fontWeight: theme('fontWeight.medium'),
              textDecorationLine: 'none',
              '&:hover': {
                textDecorationLine: 'underline',
              }
            },
          },
        },
      }),
    },
  },

  plugins: [require('@tailwindcss/typography'), require('./src/lib/tailwindcss/hocus.cjs')],
}
