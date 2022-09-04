import type { Alpine } from 'alpinejs'

const prefetch = (ev: Event) => {
    const el = ev.target as HTMLAnchorElement
    const href = el.href

    if (!!document.head.querySelector(`link[rel='prefetch'][href='${href}']`)) return

    const link = document.createElement('link')
    link.rel = 'prefetch'
    link.href = href

    document.head.append(link)
}

export default (Alpine: Alpine) => {
    Alpine.directive('prefetch', (el: Node) => {
        if (el.nodeName !== 'A') return

        ['mouseover', 'touchstart'].forEach(event => {
            el.addEventListener(event, prefetch, {
                once: true,
            })
        });
    })
}