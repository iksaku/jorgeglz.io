import { defineHastPlugin } from 'satteri'

/**
 * Replaces rehype-external-links with `target: '_blank'` and
 * `rel: ['noopener', 'noreferrer']` on absolute http(s) links.
 */
export function satteriExternalLinks() {
  return defineHastPlugin({
    name: 'satteri-external-links',
    element: {
      filter: ['a'],
      visit(node, ctx) {
        const href = node.properties?.href
        if (typeof href !== 'string' || !/^https?:\/\//.test(href)) return

        ctx.setProperty(node, 'target', '_blank')
        ctx.setProperty(node, 'rel', 'noopener noreferrer')
      },
    },
  })
}
