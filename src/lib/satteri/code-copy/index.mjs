import { defineHastPlugin } from 'satteri'

import clientScript from './client.js?raw'
import copyIcon from './copy-icon.svg?raw'

const CLIENT_SCRIPT = `<script>${clientScript}</script>`

// Factory form keeps `scriptInjected` per document — register bare.
export function satteriCodeCopy() {
  let scriptInjected = false

  return defineHastPlugin({
    name: 'satteri-code-copy',
    element: {
      filter: ['pre'],
      visit(node, ctx) {
        const properties = node.properties ?? {}
        const className = properties.class ?? properties.className
        const classes = Array.isArray(className)
          ? className
          : typeof className === 'string'
            ? className.split(/\s+/)
            : []
        if (!classes.includes('astro-code')) return

        const lang = properties.dataLanguage ?? properties['data-language']
        if (lang === 'mermaid') return

        const bar = {
          type: 'element',
          tagName: 'div',
          properties: { class: ['code-frame-bar'] },
          children: [
            {
              type: 'element',
              tagName: 'span',
              properties: { class: ['code-frame-lang'] },
              children: [{ type: 'text', value: typeof lang === 'string' && lang !== '' ? lang : 'code' }],
            },
            {
              type: 'element',
              tagName: 'button',
              properties: { class: ['code-frame-copy'], type: 'button' },
              children: [
                { type: 'raw', value: copyIcon },
                { type: 'element', tagName: 'span', properties: {}, children: [{ type: 'text', value: 'Copy' }] },
              ],
            },
          ],
        }

        ctx.replaceNode(node, {
          type: 'element',
          tagName: 'div',
          properties: { class: ['code-frame'] },
          children: [bar, node],
        })

        if (!scriptInjected) {
          scriptInjected = true
          let root = node
          let parent
          while ((parent = ctx.parent(root)) !== undefined) root = parent
          ctx.appendChild(root, { type: 'raw', value: CLIENT_SCRIPT })
        }
      },
    },
  })
}
