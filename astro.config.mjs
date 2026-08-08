import { defineConfig, fontProviders } from 'astro/config'

import { satteri, satteriHeadingIdsPlugin } from '@astrojs/markdown-satteri'
import { transformerNotationDiff, transformerNotationHighlight } from '@shikijs/transformers'
import { satteriAutolinkHeadings } from './src/lib/satteri/autolink-headings.mjs'
import { satteriExternalLinks } from './src/lib/satteri/external-links.mjs'
import shikiLangs from './src/lib/shiki/languages.mjs'

import tailwindcss from '@tailwindcss/vite'

// https://astro.build/config
export default defineConfig({
  site: process.env.APP_URL ?? process.env.CF_PAGES_URL ?? 'https://jorgeglz.io',
  fonts: [
    {
      provider: fontProviders.local(),
      name: 'Inter Variable',
      cssVariable: '--font-inter',
      fallbacks: [
        'ui-sans-serif',
        'system-ui',
        'sans-serif',
        'Apple Color Emoji',
        'Segoe UI Emoji',
        'Segoe UI Symbol',
        'Noto Color Emoji',
      ],
      options: {
        variants: [
          {
            weight: '100 900',
            style: 'normal',
            src: ['./node_modules/@fontsource-variable/inter/files/inter-latin-wght-normal.woff2'],
          },
          {
            weight: '100 900',
            style: 'normal',
            src: ['./node_modules/@fontsource-variable/inter/files/inter-latin-ext-wght-normal.woff2'],
          },
        ],
      },
    },
    {
      provider: fontProviders.local(),
      name: 'JetBrains Mono Variable',
      cssVariable: '--font-jetbrains-mono',
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
      options: {
        variants: [
          {
            weight: '100 900',
            style: 'normal',
            src: ['./node_modules/@fontsource-variable/jetbrains-mono/files/jetbrains-mono-latin-wght-normal.woff2'],
          },
          {
            weight: '100 900',
            style: 'normal',
            src: [
              './node_modules/@fontsource-variable/jetbrains-mono/files/jetbrains-mono-latin-ext-wght-normal.woff2',
            ],
          },
        ],
      },
    },
  ],
  markdown: {
    processor: satteri({
      hastPlugins: [
        // Factory so ids exist before our autolink plugin runs — Astro's
        // built-in id pass executes after user hastPlugins.
        () => satteriHeadingIdsPlugin(),
        satteriAutolinkHeadings,
        satteriExternalLinks,
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
