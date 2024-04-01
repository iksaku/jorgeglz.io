import { bundledLanguages } from 'shiki'

import caddyLang from './languages/caddyfile.tmLanguage.json' assert { type: 'json' }

/** @type {import('shiki').LanguageRegistration[]} */
export default [
  ...Object.keys(bundledLanguages),
  {
    id: 'caddyfile',
    scopeName: 'source.Caddyfile',
    aliases: ['caddy'],
    ...caddyLang,
  },
]
