import { defineConfig, fontProviders } from 'astro/config'

import { satteri, satteriHeadingIdsPlugin } from '@astrojs/markdown-satteri'
import { transformerNotationDiff, transformerNotationHighlight } from '@shikijs/transformers'
import { satteriAutolinkHeadings } from './src/lib/satteri/autolink-headings.mjs'
import { satteriCodeBlockCopyButton, satteriDetectCodeBlocks } from './src/lib/satteri/code-copy'
import { satteriExternalLinks } from './src/lib/satteri/external-links.mjs'
import shikiLangs from './src/lib/shiki/languages.mjs'

import tailwindcss from '@tailwindcss/vite'

// https://astro.build/config
export default defineConfig({
  site: process.env.APP_URL ?? process.env.CF_PAGES_URL ?? 'https://jorgeglz.io',
  fonts: [
    {
      provider: fontProviders.fontsource(),
      name: 'Inter',
      cssVariable: '--font-inter',
      styles: ['normal', 'italic'],
      weights: ['100, 900'],
      fallbacks: [
        '-apple-system',
        'BlinkMacSystemFont',
        'Segoe UI',
        'Roboto',
        'Helvetica Neue',
        'Noto Sans',
        'Arial',
        'sans-serif',
        'Apple Color Emoji',
        'Segoe UI Emoji',
        'Segoe UI Symbol',
        'Noto Color Emoji',
      ],
    },
    {
      provider: fontProviders.fontsource(),
      name: 'JetBrains Mono',
      cssVariable: '--font-jetbrains-mono',
      styles: ['normal'],
      weights: ['100, 900'],
      fallbacks: [
        'ui-monospace',
        'SFMono-Regular',
        'Menlo',
        'Monaco',
        'Consolas',
        'Liberation Mono',
        'Courier New',
        'monospace',
      ],
    },
  ],
  markdown: {
    processor: satteri({
      mdastPlugins: [satteriDetectCodeBlocks],
      hastPlugins: [
        // Factory so ids exist before our autolink plugin runs — Astro's
        // built-in id pass executes after user hastPlugins.
        () => satteriHeadingIdsPlugin(),
        satteriAutolinkHeadings,
        satteriExternalLinks,
        satteriCodeBlockCopyButton,
      ],
    }),
    shikiConfig: {
      theme: 'dracula',
      langs: shikiLangs,
      transformers: [transformerNotationDiff(), transformerNotationHighlight()],
    },
  },
  vite: {
    plugins: [tailwindcss()],
  },
  server: {
    host: true,
  },
  prefetch: {
    prefetchAll: true,
  },
  redirects: {
    '/': '/blog',
  },
})
