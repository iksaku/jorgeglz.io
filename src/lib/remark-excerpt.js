import { visit } from 'unist-util-visit'
import { toHast } from 'mdast-util-to-hast'
import { sanitize } from 'hast-util-sanitize'
import { toHtml } from 'hast-util-to-html'

const getComment = /<!--\s*(excerpt|more|preview)\s*-->/

function formatNode(node) {
  const hast = toHast(node, {
    allowDangerousHtml: false
  })

  const cleanHast = sanitize(hast)

  return toHtml(cleanHast, {
    allowDangerousHtml: false
  })
}

export const excerpt = () => (tree, file) => {
  let excerptIndex = null

  visit(tree, 'html', (node) => {
    if (excerptIndex || !getComment.test(node.value)) {
      return
    }

    excerptIndex = tree.children.indexOf(node)
  })

  if (!excerptIndex) {
    return
  }

  file.data.fm['excerpt'] = tree.children
    .slice(0, excerptIndex)
    .filter((node) => node.type === 'paragraph')
    .map(formatNode)
    .join(' ')
}
