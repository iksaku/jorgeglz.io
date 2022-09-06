import { visit } from 'unist-util-visit'
import { toHast } from 'mdast-util-to-hast'
import { sanitize } from 'hast-util-sanitize'
import { toHtml } from 'hast-util-to-html'

const keywords = ['excerpt', 'more', 'preview'].join('|')

function formatNode(node) {
    const hast = toHast(node, {
        allowDangerousHtml: false
    })

    const cleanHast = sanitize(hast)

    return toHtml(cleanHast, {
        allowDangerousHtml: false
    })
}

export default () => (tree, file) => {
    const isMdx = file.history.pop().endsWith('mdx')

    const nodeType = isMdx ? 'mdxFlowExpression' : 'html'

    const isComment = isMdx
        ? new RegExp(`\\/\\*\\s*(${keywords})\\s*\\*\\/`) // Matches keywords in Mdx comment: /* */
        : new RegExp(`<!--\\s*(${keywords})\\s*-->`) // Matches keywords in HTML comment: <!-- -->

    try {
        visit(tree, null, (node) => {
            if (isComment.test(node.value)) {
                // No way to "early return", so we force our way out
                throw tree.children.indexOf(node)
            }
        })
    } catch (excerptIndex) {
        let excerpt = tree.children
            .slice(0, excerptIndex)
            .filter((node) => node.type === 'paragraph')
            .map(formatNode)
            .join(' ')

        file.data.astro.frontmatter.excerpt = excerpt
    }
}
