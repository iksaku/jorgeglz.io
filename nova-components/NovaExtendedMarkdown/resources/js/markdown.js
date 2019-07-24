const md = require('markdown-it')()
const emoji = require('markdown-it-emoji')
const anchor = require('markdown-it-anchor').default

md
    .use(emoji)
    .use(anchor, {
        permalink: true,
        permalinkBefore: true,
        permalinkSymbol: '#',
        slugify: s => encodeURIComponent(
            String(s)
                .trim()
                .toLowerCase()
                .replace(/[^a-z0-9\-]+/g, '-')
        )
    })

md.renderer.rules.emoji = (token, idx) => {
    return `<span class="emoji">${token[idx].content}</span>`
}

export default md