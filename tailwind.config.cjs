/** @type {import('tailwindcss').Config} */
module.exports = {
	content: ['./src/**/*.{astro,html,js,jsx,md,mdx,svelte,ts,tsx,vue}'],

	theme: {
		extend: {
			typography: ({ theme }) => ({
				DEFAULT: {
					css: {
						a: {
							textDecorationColor: theme('colors.blue[500]'),
							textDecorationThickness: theme('textDecorationThickness.2'),
						},
						img: {
							marginLeft: 'auto',
							marginRight: 'auto',
						},

						'--tw-prose-body': theme('colors.gray[900]'),
						'--tw-prose-invert-body': theme('colors.gray[100]'),
						'--tw-prose-quotes': theme('colors.gray[600]'),
						'--tw-prose-invert-quotes': theme('colors.gray[300]'),
						'--tw-prose-quote-borders': theme('colors.teal[600]'),
						'--tw-prose-invert-quote-borders': theme('colors.green[500]'),

						':is(h1,h2,h3,h4,h5,h6) > a': {
							textDecorationColor: theme('colors.gray[400]'),
						},
					},
				},
			}),
		},
	},

	plugins: [
		require('@tailwindcss/typography'),
		require('./src/lib/tailwindcss/hocus.cjs')
	],
}
