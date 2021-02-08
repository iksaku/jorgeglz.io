const { createLoader } = require('simple-functional-loader')
const withBundleAnalyzer = require('@next/bundle-analyzer')({
  enabled: process.env.ANALYZE === 'true',
})

module.exports = withBundleAnalyzer({
  pageExtensions: ['js', 'jsx', 'mdx'],
  images: {
    domains: ['secure.gravatar.com'],
  },
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
            require('rehype-autolink-headings'),
            require('@mapbox/rehype-prism'),
          ],
          remarkPlugins: [require('remark-gemoji')],
        },
      },
    ]

    // Load posts with Preview and Metadata
    config.module.rules.push({
      test: /\.mdx$/,
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
                'import Post from "@/components/Post"',
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
