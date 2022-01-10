const withMDX = require('./lib/mdx')

module.exports = withMDX({
  pageExtensions: ['js', 'jsx', 'md', 'mdx'],

  images: {
    domains: ['secure.gravatar.com'],
  },

  redirects: async () => [
    { source: '/posts/:slug', destination: '/blog/:slug', permanent: true },
  ],
})
