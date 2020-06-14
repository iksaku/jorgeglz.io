import hljs from 'highlight.js'

document.addEventListener('DOMContentLoaded', () => {
    hljs.initHighlightingOnLoad()
})

document.addEventListener('livewire:load', () => {
    window.livewire.hook('afterDomUpdate', () => {
        document.querySelectorAll('pre code').forEach(block => {
            hljs.highlightBlock(block)
        })
    })
})
