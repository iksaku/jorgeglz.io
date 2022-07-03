import shikiHighlighter from './src/lib/shiki/highlighter.js'
import remarkExcerpt from './src/lib/remark-excerpt.js'
import rehypeSlug from 'rehype-slug'
import rehypeAutolinkHeadings from 'rehype-autolink-headings'
import rehypeExternalLinks from 'rehype-external-links'

/** @type {import('mdsvex').MdsvexOptions} */
const config = {
  layout: './src/components/blog/Post.svelte',
  highlight: {
    highlighter: shikiHighlighter
  },
  remarkPlugins: [remarkExcerpt],
  rehypePlugins: [
    rehypeSlug,
    [
      rehypeAutolinkHeadings,
      {
        behaviour: 'wrap'
      }
    ],
    [
      rehypeExternalLinks,
      {
        target: '_blank',
        rel: ['noopener', 'noreferrer']
      }
    ]
  ]
}

export default config
