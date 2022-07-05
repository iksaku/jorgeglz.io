import { getHighlighter } from 'shiki'
import * as languages from './languages.js'

/** @type {import('mdsvex').Highlighter} */
export default async function shikiHighlighter(code, lang) {
  const shiki = await getHighlighter({
    theme: 'dracula'
  })

  for (const lang of Object.values(languages)) {
    await shiki.loadLanguage(lang)
  }

  const html = shiki.codeToHtml(code, { lang }).replace('class="shiki"', 'class="shiki not-prose"')

  return `{@html \`${html}\`}`
}
