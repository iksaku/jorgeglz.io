import { excerpt } from './src/lib/remark-excerpt.js'

/** @type {import('mdsvex').MdsvexOptions} */
const config = {
  layout: './src/components/blog/Post.svelte',
  remarkPlugins: [excerpt]
}

export default config
