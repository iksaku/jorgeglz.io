import { readdir, readFile, writeFile } from 'node:fs/promises'
import { join } from 'node:path'
import { fileURLToPath } from 'node:url'

export default {
    name: 'font-preload-integration',
    hooks: {
        'astro:build:done': async ({ dir }) => {
            dir = fileURLToPath(dir)
            const assets = join(dir, '_astro')

            for (const stylesheet of await readdir(assets)) {
                if (!stylesheet.endsWith('.css')) continue

                const stylesheetDir = join(assets, stylesheet)

                const contents = await readFile(stylesheetDir, { encoding: 'utf-8' })

                await writeFile(
                    stylesheetDir,
                    contents.replaceAll(/font-display:\s*swap/g, 'font-display:block')
                )
            }
        }
    },
}