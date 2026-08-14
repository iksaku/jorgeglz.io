import { defineMdastPlugin } from 'satteri'

export const satteriDetectMermaidGraphs = defineMdastPlugin({
  name: 'detect-mermaid-graphs',
  code(node, ctx) {
    if (node.lang !== 'mermaid') return

    if (!!ctx.data.astro) {
      ctx.data.astro.frontmatter._mermaidDetected = true
    }

    ctx.replaceNode(node, {
      rawHtml: `<pre class="mermaid">${node.value}</pre>`,
    })
  },
})
