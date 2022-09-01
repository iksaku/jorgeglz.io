import { visit } from 'unist-util-visit'

export default () => (tree, file) => {
    visit(tree, 'element', (node) => {
        if (! ('tagName' in node) || node.tagName !== 'pre') {
            return;
        }

        node.properties.className.push('not-prose')
    })
}