import { resolve } from 'path'

/**
 * Example:
    {
        id: 'httpspec',
        scopeName: 'source.httpspec',
        path: resolve('./src/lib/shiki/languages/httpspec.tmLanguage.json'),
        aliases: ['http']
    }
 */

/** @type {import('shiki').ILanguageRegistration[]} */
export default [
    {
        id: 'httpspec',
        scopeName: 'source.httpspec',
        path: resolve('./src/lib/shiki/languages/httpspec.tmLanguage.json'),
        aliases: ['http']
    }
]