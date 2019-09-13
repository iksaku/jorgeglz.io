const md = require('markdown-it')({
    highlight: function(str, lang) {
        if (lang && hljs.getLanguage(lang)) {
            try {
                return '<pre class="hljs"><code>' +
                    hljs.highlight(lang, str, true).value +
                    '</code></pre>'
            } catch (__) {}
        }

        return '<pre class="hljs"><code>' + md.utils.escapeHtml(str) + '</code></pre>'
    }
})
const emoji = require('markdown-it-emoji')
const anchor = require('markdown-it-anchor').default
const hljs = require('highlight.js')

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
    .renderer.rules.emoji = (token, idx) => {
        return `<span class="emoji">${token[idx].content}</span>`
    }

export default md
