const { createLoader } = require('simple-functional-loader')
const h = require('hastscript')
const path = require('path')
const withBundleAnalyzer = require('@next/bundle-analyzer')({
  enabled: process.env.ANALYZE === 'true',
})

module.exports = withBundleAnalyzer({
  pageExtensions: ['js', 'jsx', 'mdx'],
  images: {
    domains: ['secure.gravatar.com'],
  },
  redirects: async () => [
    { source: '/posts/:slug', destination: '/blog/:slug', permanent: true },
  ],
  webpack: (config, options) => {
    // Import multimedia from post directory to Next's static path
    config.module.rules.push({
      test: /\.(svg|png|jpe?g|gif|mp4)$/i,
      use: [
        {
          loader: 'file-loader',
          options: {
            publicPath: '/_next',
            name: 'static/media/[name].[hash].[ext]',
          },
        },
      ],
    })

    // MDX Configuration
    const mdx = [
      options.defaultLoaders.babel,
      {
        loader: '@mdx-js/loader',
        options: {
          rehypePlugins: [
            require('@mapbox/rehype-prism'),
            require('rehype-slug'),
            [
              require('rehype-autolink-headings'),
              {
                behaviour: 'append',
                content: () => [h('span', '#')],
              },
            ],
          ],
          remarkPlugins: [
            require('remark-gemoji'),
            require('remark-external-links'),
          ],
        },
      },
    ]

    // For non-blog mdx files, just keep it simple.
    config.module.rules.push({
      test: /\.mdx$/,
      exclude: [path.resolve(__dirname, 'src/pages/blog')],
      use: mdx,
    })

    // Load blog posts with Preview and Metadata
    config.module.rules.push({
      test: /\.mdx$/,
      include: [path.resolve(__dirname, 'src/pages/blog')],
      oneOf: [
        // Render Post Previews
        {
          resourceQuery: /preview/,
          use: [
            ...mdx,
            createLoader(function (src) {
              const [preview] = src.split('<!--more-->')
              return this.callback(null, preview)
            }),
          ],
        },
        // Full Post Rendering
        {
          use: [
            ...mdx,
            createLoader(function (src) {
              const content = [
                'import Post from "@/components/blog/Post"',
                'export default Post',
                src,
              ].join('\n')

              return this.callback(null, content.replace('<!--more-->', ''))
            }),
          ],
        },
      ],
    })

    return config
  },
})
