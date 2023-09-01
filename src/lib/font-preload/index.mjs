import { readdir, readFile, writeFile } from 'node:fs/promises'
import { join } from 'node:path'
import { fileURLToPath } from 'node:url'

export default {
    name: 'font-preload-integration',
    hooks: {
        'astro:build:done': async ({ dir }) => {
            console.log('Starting font scanning...')

            dir = fileURLToPath(dir)
            const assets = join(dir, '_astro')

            const stylesheets = (await readdir(assets))
                .filter((filename) => filename.endsWith('.css'))

            const fonts = new Map()
            for (const stylesheet of stylesheets) {
                const contents = await readFile(join(assets, stylesheet), { encoding: 'utf-8' })

                const fontFiles = contents.match(/\/\S*\.woff2/g)

                if (fontFiles.length < 1) {
                    continue
                }

                if (! fonts.has(stylesheet)) {
                    fonts.set(stylesheet, new Set())
                }

                const store = fonts.get(stylesheet)
                fontFiles.forEach((font) => {
                    store.add(font)
                })
            }

            for (const page of await readdir(dir, { recursive: true })) {
                if (!page.endsWith('.html')) continue;

                const pageDir = join(dir, page)
                const contents = await readFile(pageDir, { encoding: 'utf-8' })

                let head = contents.match(/<head>(.*)<\/head>/s)?.[1]

                if (!head) continue

                const stylesInPage = stylesheets.filter((filename) => head.includes(filename))
                const fontsToPreload = new Set(
                    stylesInPage
                        .flatMap((stylesheet) => [...fonts.get(stylesheet) ?? []])
                )

                const preloadTags = [...fontsToPreload]
                    .map((font) => `<link rel="preload" as="font" type="font/woff2" href="${font}">`)
                    .join('')

                head = preloadTags + head

                await writeFile(
                    pageDir,
                    contents.replace(/<head>.*<\/head>/s, `<head>${head}</head>`)
                )
            }
        }
    },
}