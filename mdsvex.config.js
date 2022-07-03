import { getHighlighter } from 'shiki'
import remarkExcerpt from './src/lib/remark-excerpt.js'
import rehypeSlug from 'rehype-slug'
import rehypeAutolinkHeadings from 'rehype-autolink-headings'
import rehypeExternalLinks from 'rehype-external-links'

/** @type {import('mdsvex').MdsvexOptions} */
const config = {
  layout: './src/components/blog/Post.svelte',
  highlight: {
    highlighter: async (code, lang) => {
      const html = (await getHighlighter({ theme: 'dracula' })).codeToHtml(code, { lang })

      return `{@html \`${html}\`}`
    }
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
