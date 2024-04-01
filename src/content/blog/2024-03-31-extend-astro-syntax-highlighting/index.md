---
title: Extend Astro Syntax Highlighting
slug: extend-astro-syntax-highlighting
description: |
  Astro + Shiki is a heavenly combo. The out-of-the-box integration saves us a ton of time setting up the highlighter
  and it is pretty easy to override the list of languages to highlight, but what if we want to extend this list instead?
date: 2024-03-31
---

[Shiki](https://shiki.style/) is by far my favorite tool for syntax highlighting. It is (now) ESM-compatible,
framework-agnostic, even runtime-agnostic, and has native support for TextMate grammars, which are used by MANY code editors
and IDEs. This allows you to quickly integrate Shiki wherever you need it, supporting whichever languages you want,
and having the best [theme](https://shiki.style/languages) out there for your needs.

[Astro](https://astro.build/) with its content-focused integrations, provides support for syntax highlighting
in code blocks out of the box with Shiki if you are making use of
[Markdown (or MDX)](https://docs.astro.build/en/guides/markdown-content/#syntax-highlighting) or their
[`<Code>`](https://docs.astro.build/en/reference/api-reference/#code-) component. Such integration saves a lot
of time and makes it
[pretty easy to customize](https://docs.astro.build/en/guides/markdown-content/#shiki-configuration).

Recently, I updated this very blog from Astro v3 to Astro v4
(btw, their [upgrade guide](https://docs.astro.build/en/upgrade-astro/) is awesome!) and noticed that while
there were very minimal breaking changes between the two versions, one thing was never mentioned:
In Astro v3, the configuration property
[`markdown.shikiConfig.langs`](https://docs.astro.build/en/guides/markdown-content/#shiki-configuration)
_extended_ the list of languages for which Shiki enabled syntax highlighting; while in Astro v4, this same
property now _overrides_ the list of languages.

This one was pretty easy to catch as there is only one language (at the moment) that I use in this blog that
is not part of the official list of languages included in Shiki: [Caddyfile](https://caddyserver.com/docs/caddyfile).

> [Checkout my post about HTTPS behind VPNs using Caddy!](./https-behind-vpn)

After a quick dive into Shiki's source code, I noticed that the 1.0 release made some big changes in the way languages
are loaded, being this probably the reason behind the change from _extending_ to _overriding_ the language list
via the configuration property.

In my case, I don't want to manually "opt-in" all the languages that I may (or may not) be using in this blog, I just
want to _extend_ the available languages with the grammar files for those not-officially packed with Shiki...
And it is actually pretty easy to do!

```js
// astro.config.mjs

// 1. Pull in the languages that are bundled with Shiki
import { bundledLanguages } from 'shiki'
// 2. Import the grammar file for the language(s) you want to add
import caddyLang from 'path/to/caddyfile.tmLanguage.json' assert { type: 'json' }

export default defineConfig({
    // ...
    markdown: {
        shikiConfig: {
            // ...
            langs: [
                // 3. As bundled language are already registered,
                //    we just pull their names.
                ...Object.keys(bundledLanguages),
                // 4. Then we add our custom language(s) to the list
                {
                    id: 'caddyfile',
                    scopeName: 'source.Caddyfile',
                    aliases: ['caddy'],
                    ...caddyLang,
                },
            ]
        }
    }
})
```

That's all! Now, the `caddyfile` language is back in this blog without needing to manually opt in to all the other
languages.

Happy Easter!