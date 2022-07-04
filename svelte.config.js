import adapter from '@sveltejs/adapter-cloudflare'
import preprocess from 'svelte-preprocess'
import { mdsvex } from 'mdsvex'
import mdsvexConfig from './mdsvex.config.js'

/** @type {import('@sveltejs/kit').Config} */
const config = {
  // Consult https://github.com/sveltejs/svelte-preprocess
  // for more information about preprocessors

  preprocess: [
    preprocess({
      postcss: true
    }),
    mdsvex(mdsvexConfig)
  ],

  extensions: ['.svelte', '.svx'],

  kit: {
    adapter: adapter(),

    alias: {
      $assets: 'src/assets',
      $components: 'src/components'
    },

    prerender: {
      default: true
    }
  }
}

export default config
