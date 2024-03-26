import { defineConfig } from 'astro/config'

import rehypeAutolinkHeadings from 'rehype-autolink-headings'
import rehypeExternalLinks from 'rehype-external-links'
import rehypeSlug from 'rehype-slug'
import rehypeCodeNotProse from './src/lib/rehype/code-not-prose.mjs'

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
          behaviour: 'wrap',
        },
      ],
      [
        rehypeExternalLinks,
        {
          target: '_blank',
          rel: ['noopener', 'noreferrer'],
        },
      ],
      rehypeCodeNotProse,
    ],
    shikiConfig: {
      theme: 'dracula',
      langs: shikiLangs,
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
