import { resolve } from 'path'

function reference(name) {
  return resolve(`./src/lib/shiki/languages/${name}.tmLanguage.json`)
}

/** @type {import('shiki').ILanguageRegistration[]} */
export default [
  {
    id: 'caddyfile',
    scopeName: 'source.Caddyfile',
    path: reference('caddyfile'),
    aliases: ['caddy'],
  },
]
