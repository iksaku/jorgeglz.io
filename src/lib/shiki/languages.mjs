import { readFileSync } from 'fs'
import { resolve } from 'path'

/** @type {import('shiki').ILanguageRegistration[]} */
export default [
    {
        id: 'httpspec',
        scopeName: 'source.httpspec',
        grammar: JSON.parse(
            readFileSync(resolve('./src/lib/shiki/languages/httpspec.tmLanguage.json')).toString()
        ),
        aliases: ['http']
    }
]