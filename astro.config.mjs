import { defineConfig } from 'astro/config'

import rehypeAutolinkHeadings from 'rehype-autolink-headings'
import rehypeExternalLinks from 'rehype-external-links'
import rehypeSlug from 'rehype-slug'

import { transformerNotationDiff, transformerNotationHighlight } from '@shikijs/transformers'
import shikiLangs from './src/lib/shiki/languages.mjs'

import tailwind from '@astrojs/tailwind'
import fontPreload from './src/lib/font-preload'

// https://astro.build/config
export default defineConfig({
  site: process.env.APP_URL ?? process.env.CF_PAGES_URL ?? 'https://jorgeglz.io',
  markdown: {
    rehypePlugins: [
      rehypeSlug,
      [
        rehypeAutolinkHeadings,
        {
          behavior: 'wrap',
        },
      ],
      [
        rehypeExternalLinks,
        {
          target: '_blank',
          rel: ['noopener', 'noreferrer'],
        },
      ],
    ],
    shikiConfig: {
      theme: 'dracula',
      langs: shikiLangs,
      transformers: [transformerNotationDiff(), transformerNotationHighlight()],
    },
  },
  integrations: [
    tailwind({
      applyBaseStyles: false,
    }),
    fontPreload,
  ],
  prefetch: {
    prefetchAll: true,
  },
  redirects: {
    '/': '/blog',
  },
})
