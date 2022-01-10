const path = require('path')
const { createLoader } = require('simple-functional-loader')

module.exports = (nextConfig = {}) => ({
  ...nextConfig,
  ...{
    webpack: (config, options) => {
      // MDX Configuration
      const mdxExtension = /\.mdx?$/
      const mdxConfig = [
        options.defaultLoaders.babel,
        {
          loader: '@mdx-js/loader',
          options: {
            remarkPlugins: [
              require('remark-gemoji'),
              require('remark-external-links'),
            ],
            rehypePlugins: [
              require('@mapbox/rehype-prism'),
              require('rehype-slug'),
              [
                require('rehype-autolink-headings'),
                {
                  behavior: 'wrap',
                },
              ],
            ],
          },
        },
      ]

      const blogPath = path.resolve(process.cwd(), 'src/pages/blog')

      // For non-blog mdx files, just keep it simple.
      config.module.rules.push({
        test: mdxExtension,
        exclude: [blogPath],
        use: mdxConfig,
      })

      // Load blog posts with Preview and Metadata
      config.module.rules.push({
        test: mdxExtension,
        include: [blogPath],
        oneOf: [
          // Render Post Previews
          {
            resourceQuery: /preview/,
            use: [
              ...mdxConfig,
              createLoader(function (src) {
                const [preview] = src.split('<!--more-->')
                return this.callback(null, preview)
              }),
            ],
          },
          // Full Post Rendering
          {
            use: [
              ...mdxConfig,
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
  },
})
