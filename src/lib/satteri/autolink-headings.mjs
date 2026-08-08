import { defineHastPlugin } from 'satteri'

/**
 * Replaces rehype-autolink-headings with `behavior: 'wrap'` — the whole
 * heading becomes a self-link. Requires heading ids to exist, so
 * `satteriHeadingIdsPlugin()` must be registered (as a factory) before this
 * plugin: Astro's built-in id pass runs *after* user hastPlugins.
 */
export function satteriAutolinkHeadings() {
  return defineHastPlugin({
    name: 'satteri-autolink-headings',
    element: {
      filter: ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
      visit(node, ctx) {
        const id = node.properties?.id
        if (typeof id !== 'string' || id.length === 0) return

        ctx.setProperty(node, 'children', [
          {
            type: 'element',
            tagName: 'a',
            properties: { href: `#${id}` },
            children: node.children,
          },
        ])
      },
    },
  })
}
