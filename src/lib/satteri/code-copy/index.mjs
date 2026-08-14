import { defineHastPlugin, defineMdastPlugin } from 'satteri'

import copyIcon from './copy-icon.svg?raw'

// TODO: Allow copying Mermaid graph code

// Used to dynamically inject code-block scripts, like code copy button.
export const satteriDetectCodeBlocks = defineMdastPlugin({
  name: 'detect-code-blocks',
  code(node, ctx) {
    if (node.lang === 'mermaid') return

    if (!!ctx.data.astro) {
      ctx.data.astro.frontmatter._codeBlockDetected = true
    }
  },
})

// Factory form keeps `scriptInjected` per document — register bare.
export const satteriCodeBlockCopyButton = defineHastPlugin({
  name: 'code-block-copy-button',
  element: {
    filter: ['pre'],
    visit(node, ctx) {
      const properties = node.properties ?? {}
      const className = properties.class ?? properties.className
      const classes = Array.isArray(className) ? className : typeof className === 'string' ? className.split(/\s+/) : []
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
    },
  },
})
