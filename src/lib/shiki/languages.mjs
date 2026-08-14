import caddyLang from './languages/caddyfile.tmLanguage.json' with { type: 'json' }

/** @type {import('shiki').LanguageRegistration[]} */
export default [
  {
    id: 'caddyfile',
    scopeName: 'source.Caddyfile',
    aliases: ['caddy'],
    ...caddyLang,
  },
]
