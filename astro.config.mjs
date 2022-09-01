import { defineConfig } from 'astro/config'

import shikiLangs from './src/lib/shiki/languages.mjs'

import mdx from "@astrojs/mdx"
import rehypeSlug from 'rehype-slug'
import rehypeAutolinkHeadings from 'rehype-autolink-headings'
import rehypeExternalLinks from 'rehype-external-links'
import rehypeCodeNotProse from './src/lib/rehype/code-not-prose.mjs'
import remarkExcerpt from './src/lib/remark/excerpt.mjs'

import tailwind from "@astrojs/tailwind"

// https://astro.build/config
export default defineConfig({
  markdown: {
    rehypePlugins: [
      rehypeSlug,
      [rehypeAutolinkHeadings, { behaviour: 'wrap' }],
      [rehypeExternalLinks, { target: '_blank', rel: ['noopener', 'noreferrer'] }],
      rehypeCodeNotProse,
    ],
    remarkPlugins: [
      remarkExcerpt
    ],
    shikiConfig: {
      theme: 'dracula',
      langs: shikiLangs,
    },
  },
  integrations: [
    mdx(),
    tailwind()
  ]
})