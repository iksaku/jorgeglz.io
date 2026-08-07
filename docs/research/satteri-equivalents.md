# Sätteri equivalents for slug, autolink, and external-links behaviors

Research for [#50](https://github.com/iksaku/jorgeglz.io/issues/50), part of map [#42](https://github.com/iksaku/jorgeglz.io/issues/42).
Verified against `@astrojs/markdown-satteri@0.3.5` and `satteri@0.9.5` package sources (npm tarballs), not just docs.

## Current behaviors to replace (from `astro.config.mjs`)

| Behavior | Current plugin | Config |
|---|---|---|
| Heading IDs | `rehype-slug` | (no options) |
| Autolinked headings | `rehype-autolink-headings` | `behavior: 'wrap'` — whole heading becomes a self-link |
| External-link attributes | `rehype-external-links` | `target: '_blank'`, `rel: ['noopener', 'noreferrer']` |

## Sätteri plugin mechanics (shared groundwork)

Sätteri does not run remark/rehype plugins. Its plugin model:

- A plugin is a plain object with a `name` plus visitors, wrapped in `defineMdastPlugin` or `defineHastPlugin` (identity helpers for type inference). MDAST visitors are keyed by node type (`heading(node, ctx)`, `link(node, ctx)`, …); HAST `element` visitors take an explicit `filter: string[]` of tag names.
- Both visitor kinds receive `(node, ctx)`. Nodes are read-only, frozen views over the Rust-side tree; all mutation goes through `ctx`: `setProperty(node, key, value)`, `appendChild` / `prependChild` / `insertChildAt` / `removeChildAt`, `replaceNode(node, replacement | replacement[])`, `wrapNode`, `removeNode`, `insertBefore` / `insertAfter`. Inspection: `ctx.textContent(node)`, `ctx.parent(node)`, `ctx.indexOf(node)`. A document-scoped `ctx.data` bag survives the mdast→hast boundary (Astro stores frontmatter/headings there under `ctx.data.astro`).
- Pipeline order: MDAST stage first, then HAST; plugins run in array order, each seeing the previous plugin's output. Entries may be a definition, a factory (called once per document — use factories for per-document state like a slugger), or nested arrays (bundles).
- Registration in `astro.config.mjs` (Astro 7):

```js
import { satteri } from '@astrojs/markdown-satteri'

export default defineConfig({
  markdown: {
    processor: satteri({
      mdastPlugins: [/* … */],
      hastPlugins: [/* … */],
      features: { /* parser flags: gfm, directive, math, … */ },
    }),
  },
})
```

`satteri()` is the **default** processor in Astro 7, so `processor:` is only needed to pass plugins/features. The existing `markdown.shikiConfig` keeps working — Astro builds its Shiki highlighter as a HAST plugin (`satteriHighlightPlugin`) inside the same pipeline.

Sources: <https://satteri.bruits.org/docs/plugins/>, <https://satteri.bruits.org/docs/plugin-api/>, <https://docs.astro.build/en/guides/markdown-content/#using-s%C3%A4tteri-plugins-and-features>, <https://docs.astro.build/en/reference/configuration-reference/#markdownprocessor>

### Astro-side wiring detail that matters below

Verified in `@astrojs/markdown-satteri@0.3.5` (`dist/satteri-processor.js`): the final HAST plugin list is

```
[highlightPlugin?] + userHastPlugins + [imageMarkerPlugin, headingIdsPlugin]
```

i.e. **Astro's built-in heading-IDs plugin always runs after user `hastPlugins`.** Any user plugin that needs to read heading `id`s must register `satteriHeadingIdsPlugin()` itself, earlier in the array — as a **factory** (`() => satteriHeadingIdsPlugin()`), because the slugger is created at construction time and a shared instance would leak slug deduplication across documents. Running it early is officially supported: the plugin was made idempotent in [withastro/astro#17165](https://github.com/withastro/astro/pull/17165) for exactly this pattern; the trailing built-in run then respects existing `id`s.

## Behavior 1: Heading IDs → **native feature** (drop `rehype-slug`)

- Astro injects `id` attributes into all `<h1>`–`<h6>` elements in Markdown and MDX files by default, and exposes them via `getHeadings()` / `render()`. This is processor-level behavior, present under Sätteri. Source: <https://docs.astro.build/en/guides/markdown-content/#heading-ids>
- The slug algorithm is **github-slugger**, confirmed in package source: `@astrojs/markdown-satteri@0.3.5` `dist/satteri-processor.js` imports `Slugger from "github-slugger"` and its `createHeadingIdsPlugin()` (exported publicly as `satteriHeadingIdsPlugin`) does `slugger.slug(ctx.textContent(node))`, preserving any pre-existing `id`. Source: <https://docs.astro.build/en/guides/markdown-content/#heading-ids-and-plugins>, <https://github.com/Flet/github-slugger#usage>
- `rehype-slug` also uses github-slugger, and this site sets no custom IDs — so slugs are byte-identical before/after. **No anchor breakage.**
- Nothing to configure; `satteriHeadingIdsPlugin()` is only needed explicitly when another user plugin must read the IDs first (see mechanics note above).

**Recommendation: native. Delete `rehype-slug`; zero replacement work.**

## Behavior 2: Autolinked headings (`behavior: 'wrap'`) → **custom Sätteri HAST plugin**

- Native: no. Astro/Sätteri generate the IDs but no self-links.
- Ecosystem: none. The Sätteri monorepo ships only `satteri`, `satteri-expressive-code`, `vite-plugin-satteri` (<https://github.com/bruits/satteri#packages>); an npm search for `satteri` plugins (2026-08-07) surfaces only KaTeX, PhotoSwipe, and Expressive Code plugins — nothing for heading links or external links.
- Prior art: Danny Smith's `satteriAutolinkHeadings` — a HAST plugin, `filter: ['h1'..'h6']`, reads `node.properties.id`, appends an `<a href="#id">` via `ctx.appendChild`. That is the *append* variant, not our *wrap* variant. Sources: <https://danny.is/notes/upgrading-astro-7-switching-satteri/>, <https://github.com/dannysmith/dannyis-astro/blob/main/src/lib/satteri-autolink-headings.mjs>
- Shape of our wrap variant (HAST, because the anchor must wrap rendered inline content like `code`):

```js
import { defineHastPlugin } from 'satteri'
import { satteriHeadingIdsPlugin } from '@astrojs/markdown-satteri'

export function satteriAutolinkHeadings() {
  return defineHastPlugin({
    name: 'satteri-autolink-headings',
    element: {
      filter: ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
      visit(node, ctx) {
        const id = node.properties?.id
        if (typeof id !== 'string' || id.length === 0) return
        ctx.setProperty(node, 'children', [
          { type: 'element', tagName: 'a', properties: { href: `#${id}` }, children: node.children },
        ])
      },
    },
  })
}

// astro.config.mjs
processor: satteri({
  hastPlugins: [
    () => satteriHeadingIdsPlugin(), // factory, so IDs exist before our plugin runs
    satteriAutolinkHeadings,
  ],
})
```

Mechanics notes:
- `ctx.setProperty(node, 'children', …)` is legal for HAST (`key` is `string`, `value` is `unknown`); alternatively return `{ ...node, children: [anchor] }` from the visitor to replace the node. Passed-through children keep identity, so other plugins' queued transforms on nested children still apply (<https://satteri.bruits.org/docs/plugin-api/#how-transforms-compose>).
- The early `satteriHeadingIdsPlugin()` run is required because Astro's built-in run happens *after* user plugins (wiring detail above). It must be a factory.
- Wrapping preserves `textContent`, so the built-in TOC/`getHeadings()` text stays clean (Danny's append variant had to dodge this with CSS-generated glyphs; wrap does not have the problem).

**Recommendation: custom HAST plugin. Size: S — ~40 LOC plus the two-line config change and a fixture test; the only subtlety is plugin ordering (documented above).**

## Behavior 3: External-link attributes → **custom Sätteri HAST plugin** (docs give the recipe verbatim)

- Native: no. Ecosystem: none (same npm/monorepo evidence as behavior 2).
- The Sätteri plugin docs' *canonical example* is exactly this behavior: <https://satteri.bruits.org/docs/plugins/#hast-plugins>. Danny's `satteriExternalLinks` is the same shape with a host allowlist: <https://github.com/dannysmith/dannyis-astro/blob/main/src/lib/satteri-external-links.mjs>

```js
import { defineHastPlugin } from 'satteri'

export function satteriExternalLinks() {
  return defineHastPlugin({
    name: 'satteri-external-links',
    element: {
      filter: ['a'],
      visit(node, ctx) {
        const href = node.properties?.href
        if (typeof href !== 'string' || !/^https?:\/\//.test(href)) return
        ctx.setProperty(node, 'target', '_blank')
        ctx.setProperty(node, 'rel', 'noopener noreferrer')
      },
    },
  })
}
```

Parity check vs `rehype-external-links` with our options (`target: '_blank'`, `rel: ['noopener','noreferrer']`, default protocols http/https): the snippet above matches, since this site's external links are absolute `http(s)` URLs. If we ever need `content`/`properties` options or protocol-relative URL handling, that's beyond parity — not our case.

**Recommendation: custom HAST plugin. Size: XS — ~20 LOC; register after the autolink plugin (order between the two is irrelevant, disjoint filters).**

## Summary

| Behavior | Verdict | Work |
|---|---|---|
| Heading IDs | **Native** (github-slugger, identical slugs) | Delete `rehype-slug`; nothing else |
| Autolinked headings (wrap) | **Custom Sätteri HAST plugin** | ~40 LOC + register `satteriHeadingIdsPlugin()` as factory before it |
| External-link target/rel | **Custom Sätteri HAST plugin** | ~20 LOC, recipe straight from Sätteri docs |

Total custom-plugin work: two small HAST plugins, ~60 LOC combined, both following documented, prior-art-proven patterns. Drop nothing. `rehype-slug`, `rehype-autolink-headings`, `rehype-external-links` all leave `package.json`; `markdown.rehypePlugins` is replaced by `markdown.processor: satteri({ hastPlugins: [...] })`.

## Sources

- Astro 7 Markdown guide — heading IDs, plugins, processor choice: <https://docs.astro.build/en/guides/markdown-content/>
- Astro config reference — `markdown.processor`: <https://docs.astro.build/en/reference/configuration-reference/#markdownprocessor>
- Sätteri docs — plugins walkthrough: <https://satteri.bruits.org/docs/plugins/>
- Sätteri docs — plugin API reference: <https://satteri.bruits.org/docs/plugin-api/>
- Sätteri repo / shipped packages: <https://github.com/bruits/satteri>
- `@astrojs/markdown-satteri@0.3.5` npm tarball — `dist/satteri-processor.js` (github-slugger import, `createHeadingIdsPlugin`, pipeline wiring): <https://www.npmjs.com/package/@astrojs/markdown-satteri>
- Heading-ids idempotency PR: <https://github.com/withastro/astro/pull/17165>
- Prior art writeup: <https://danny.is/notes/upgrading-astro-7-switching-satteri/>
- Prior art source: <https://github.com/dannysmith/dannyis-astro/tree/main/src/lib> (`satteri-autolink-headings.mjs`, `satteri-external-links.mjs`)
- github-slugger semantics: <https://github.com/Flet/github-slugger#usage>
