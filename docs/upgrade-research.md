# Upgrade Research — jorgeglz.io

## Astro core (astro, @astrojs/tailwind)

Latest versions verified against the npm registry on 2026-08-06. The site crosses **three majors**: 4 → 5 (last 5.x: 5.18.2), 5 → 6 (last 6.x: 6.4.8), 6 → 7 (latest: 7.2.0).

| Package | Current | Latest | Action needed |
| --- | --- | --- | --- |
| astro | ^4.16.15 | **7.2.0** | Sequential majors 4→5→6→7; each has breaking changes touching this site (below). Requires **Node ≥ 22.12.0** (engines field, `https://registry.npmjs.org/astro/latest`) |
| @astrojs/tailwind | ^5.1.2 | 6.0.2 (**deprecated**) | Remove. Peer deps are only `astro ^3 \|\| ^4 \|\| ^5` (`https://registry.npmjs.org/@astrojs/tailwind/latest`) — no Astro 6/7 support, and the README marks it deprecated in favor of Tailwind's Vite plugin |
| (replacement) @tailwindcss/vite | — | 4.3.3 | Add with Tailwind 4 (see Dependencies section for the TW3→4 migration itself) |
| (new, v7) @astrojs/markdown-remark | — | 7.2.2 | Required in Astro 7 to keep remark/rehype plugins working |
| Node.js | — | **≥ 22.12.0** | Minimum for astro ≥ 6 (v6 upgrade guide; `engines.node` in astro 6.4.8/7.2.0). Astro 7 engines: `node >=22.12.0`, `pnpm >=7.1.0` |

Bundled transitive majors (from `https://registry.npmjs.org/astro/<version>`): astro 5.18.2 → shiki ^3.21.0 + zod ^3.25.76 + Vite 6; astro 6.4.8 → **shiki ^4.0.2 + zod ^4.3.6** + Vite 7; astro 7.2.0 → shiki ^4.0.2 + zod ^4.3.6 + **Vite 8** + `@astrojs/markdown-satteri` (new default Markdown pipeline; `@astrojs/markdown-remark` is now a peer dependency).

### Required upgrade steps, in order

1. **Prerequisite: Node ≥ 22.12.0** locally and on the deploy environment (site deploys to Cloudflare Pages — `CF_PAGES_URL` is referenced in `astro.config.mjs:15`). <https://docs.astro.build/en/guides/upgrade-to/v6/#node-22>
2. **4 → 5**: `pnpm dlx @astrojs/upgrade` (or manual). Migrate content collections to the Content Layer API (see per-file changes below). Optionally modernize `tsconfig.json`/`src/env.d.ts`. <https://docs.astro.build/en/guides/upgrade-to/v5/>
3. **5 → 6**: Remove `@astrojs/tailwind` → switch to `@tailwindcss/vite` (requires the Tailwind 4 migration from the Dependencies section). Move `z` import to `astro/zod`; verify schema under Zod 4; verify custom Shiki grammar under bundled Shiki 4. Fix `assert` → `with` in `src/lib/shiki/languages.mjs`. <https://docs.astro.build/en/guides/upgrade-to/v6/>
4. **6 → 7**: Install `@astrojs/markdown-remark` and set `markdown.processor: unified({ rehypePlugins: [...] })` (or keep the deprecated top-level `markdown.rehypePlugins`, which still work once the package is installed). Re-check templates for unclosed tags (new strict Rust compiler) and inspect whitespace-sensitive layouts (`compressHTML: 'jsx'` is the new default). <https://docs.astro.build/en/guides/upgrade-to/v7/>
5. Verify with `astro build` + `astro check`; confirm `/` → `/blog` redirect and `/blog/<post>` URLs are unchanged (see entry-ID note below).

### Breaking changes that touch this site's files

**`src/content/config.ts` → `src/content.config.ts` (rename + loader, required before Astro 6)**

- Astro 5 made the v2.0 collections API "legacy": the old config kept working via built-in back-compat (or the `legacy.collections` flag), but **Astro 6 removes that back-compat entirely — no flag remains** (`legacy.collections` is gone; only a temporary `legacy.collectionsBackwardsCompat` helper exists in 6.x). So the migration is mandatory: move the file to `src/content.config.ts` and add a loader. <https://docs.astro.build/en/guides/upgrade-to/v5/#legacy-v20-content-collections-api> <https://docs.astro.build/en/guides/upgrade-to/v6/#removed-legacy-content-collections>
- New shape for this site: `defineCollection({ loader: glob({ pattern: '**/*.md', base: './src/content/blog' }), schema: ({ image }) => z.object({ ... }) })` with `import { glob } from 'astro/loaders'`. The `schema: ({ image }) => z.object(...)` function form is still supported and still documented in the current (v7) docs, and `image().refine()` remains unsupported (this site doesn't use it). <https://docs.astro.build/en/guides/images/> <https://docs.astro.build/en/guides/content-collections/>
- **Zod**: astro 6 deprecates `z` from `astro:content` — change to `import { z } from 'astro/zod'`. <https://docs.astro.build/en/guides/upgrade-to/v6/#deprecated-astroschema-and-z-from-astrocontent> Astro 6 also bundles **Zod 4** (was Zod 3 in astro 5). This schema (`z.string().min(1)`, `z.date().optional()`, `image().optional()`) uses no deprecated string formats or custom error maps, so it should survive unchanged, but validate with a build. <https://docs.astro.build/en/guides/upgrade-to/v6/#zod-4>

**`src/pages/blog/[slug].astro` and `src/pages/blog/index.astro` (slug → id, render())**

- Content-layer entries have `id`, not `slug`: `params: { slug: post.slug }` → `params: { slug: post.id }` (`[slug].astro:11`), and `/blog/${post.slug}` → `/blog/${post.id}` (`index.astro:16`). <https://docs.astro.build/en/guides/upgrade-to/v5/#updating-existing-collections>
- **URLs are preserved**: the glob loader's default ID generation slugifies the path relative to `base` and strips a trailing `/index`, so `src/content/blog/<post>/index.md` → `id = <post>` — identical to the legacy `slug`. Verified in source: `getContentEntryIdAndSlug()` (`.replace(/\/index$/, '')`) at <https://github.com/withastro/astro/blob/main/packages/astro/src/content/utils.ts>; behavior per <https://docs.astro.build/en/guides/content-collections/>.
- `const { Content } = await post.render()` (`[slug].astro:22`) → `import { render } from 'astro:content'` + `const { Content } = await render(post)`. Entries no longer have a `.render()` method. <https://docs.astro.build/en/guides/upgrade-to/v5/#updating-existing-collections> <https://docs.astro.build/en/guides/upgrade-to/v6/#removed-legacy-content-collections>

**`src/lib/utils.ts` (collection querying)**

- `getCollection('blog', filter)` is unchanged in the content layer. Note `getCollection()` sort order is non-deterministic under the new glob-backed implementation — this site already sorts by date itself, so it's safe. `getEntry()` now types its return as possibly `undefined`. <https://docs.astro.build/en/guides/upgrade-to/v5/#breaking-changes-to-legacy-content-and-data-collections>

**`astro.config.mjs` (Tailwind integration, Markdown processor, Shiki)**

- **Remove `tailwind({ applyBaseStyles: false })`** (`astro.config.mjs:10,40-42`) and uninstall `@astrojs/tailwind`: the package is deprecated (README: "This integration is deprecated … the Vite plugin is the preferred way to use Tailwind 4 in Astro") and its peer range excludes astro ≥ 6. Official path: `pnpm dlx astro add tailwind` (available in astro ≥ 5.2.0) which installs `@tailwindcss/vite`, or add the plugin to `vite.plugins` manually; then import Tailwind in a global CSS file (`@import "tailwindcss";`). With `applyBaseStyles: false` today the site already imports its own CSS, which matches the new model. <https://github.com/withastro/astro/blob/main/packages/integrations/tailwind/README.md> <https://docs.astro.build/en/guides/styling/#tailwind> <https://docs.astro.build/en/guides/styling/#upgrade-from-tailwind-3>
- **Astro 7 default Markdown processor is Sätteri, not unified** — `@astrojs/markdown-remark` is no longer installed by default. The site depends on three rehype plugins (`rehype-slug`, `rehype-autolink-headings`, `rehype-external-links`, `astro.config.mjs:17-32`), so it must `pnpm add @astrojs/markdown-remark` and either set `markdown.processor: unified({ rehypePlugins: [...] })` or keep the deprecated top-level `markdown.rehypePlugins` (still works once the package is installed). <https://docs.astro.build/en/guides/upgrade-to/v7/#new-default-markdown-processor-sätteri> <https://docs.astro.build/en/guides/markdown-content/#switching-to-the-unified-processor> <https://docs.astro.build/en/reference/configuration-reference/#markdownprocessor>
- **Shiki**: `markdown.shikiConfig` still exists in v7 (theme/langs/transformers keys unchanged). Astro 5 changed the internal Shiki rehype plugin to highlight as hast (may affect custom transformers — this site only uses `@shikijs/transformers` notation transformers, which are designed for this). Astro 6 upgrades the bundled Shiki to **v4** — review `src/lib/shiki/languages.mjs` (custom `LanguageRegistration` + `bundledLanguages`) against the Shiki v4 migration notes. <https://docs.astro.build/en/reference/configuration-reference/#markdownshikiconfig> <https://docs.astro.build/en/guides/upgrade-to/v5/#changed-internal-shiki-rehype-plugin-for-highlighting-code-blocks> <https://docs.astro.build/en/guides/upgrade-to/v6/#shiki-40> <https://shiki.style/blog/v4>
- **Heading IDs (Astro 6)**: Astro now generates Markdown heading IDs with `github-slugger` and no longer strips trailing hyphens from headings ending in special characters. The site runs `rehype-slug` over whatever Astro produces; anchors to such headings may change. Check posts for headings ending in punctuation. <https://docs.astro.build/en/guides/upgrade-to/v6/#changed-markdown-heading-id-generation>
- **`redirects: { '/': '/blog' }`**: unaffected, but note Astro 5 made redirects prioritize equally with file-based routes (no competing `/` page here). <https://docs.astro.build/en/guides/upgrade-to/v5/#route-priority-order-for-injected-routes-and-redirects>

**`src/lib/shiki/languages.mjs` (import attributes)**

- `import ... assert { type: 'json' }` (line 3) must become **`with { type: 'json' }`**: import assertions were removed from current Node — verified `SyntaxError: Unexpected identifier 'assert'` on Node v26.5.1 locally; Node ≥ 22.12 (required by astro ≥ 6) supports `with`. This file is loaded by `astro.config.mjs` (i.e., by Node directly), so the Node runtime grammar applies. <https://nodejs.org/api/esm.html#import-attributes>

**`src/env.d.ts` / `tsconfig.json` (Astro 5 TypeScript changes)**

- Astro 5 uses `.astro/types.d.ts` for type inference; `astro sync` no longer creates or updates `src/env.d.ts`, and it's only needed for custom type additions. The recommended setup is `"include": [".astro/types.d.ts", "**/*"]` and `"exclude": ["dist"]` in `tsconfig.json`. The existing `extends: "astro/tsconfigs/strict"` is still shipped. The current `src/env.d.ts` (references to `.astro/types.d.ts` + `astro/client`) is harmless to keep. <https://docs.astro.build/en/guides/upgrade-to/v5/#changed-typescript-configuration>

**Templates (`src/layouts/*.astro`, `src/pages/**`) — Astro 7 Rust compiler**

- Astro 7 replaces the Go compiler with a Rust compiler that **errors on unclosed tags** and no longer silently restructures invalid HTML (e.g. `<div>` inside `<p>`). Run the build and fix any new template errors. <https://docs.astro.build/en/guides/upgrade-to/v7/#rust-compiler>
- New default whitespace handling `compressHTML: 'jsx'` may drop spaces between inline elements — visually inspect pages after upgrade. <https://docs.astro.build/en/guides/upgrade-to/v7/#new-default-whitespace-handling-compresshtml-jsx>

**Checked and NOT affecting this site**: `Astro.glob()` (absent), `<ViewTransitions />` (absent — renamed to `ClientRouter` in v5, removed in v6), `output: 'hybrid'` (site is default static, no adapter), dynamic `prerender` exports (absent), Squoosh config (absent), `@astrojs/mdx` (not used), Actions/sessions (not used), `src/fetch.ts` reserved name in v7 (file absent), CJS Astro config (`astro.config.mjs` is ESM — v6 drops CJS config support), `<script>` hoisting changes (no `<script>` tags under `src/`; v5 made direct rendering the default and v6 renders script/style in definition order). Sources: the three upgrade guides linked above.

## Dependencies

Latest versions verified against the npm registry (`https://registry.npmjs.org/<pkg>/latest`) on 2026-08-06.

| Package | Current | Latest | Breaking? | Action needed |
| --- | --- | --- | --- | --- |
| tailwindcss | ^3.4.15 | 4.3.3 | **Yes (v3→v4)** | Run `npx @tailwindcss/upgrade` codemod; migrate `src/assets/css/app.css`, `tailwind.config.cjs`, `src/lib/tailwindcss/hocus.cjs`; replace `@astrojs/tailwind` with `@tailwindcss/vite` (see astro-core section) |
| @tailwindcss/typography | ^0.5.15 | 0.5.20 | No | Bump; v4 support added in 0.5.16; load via `@plugin` in CSS |
| @shikijs/transformers | ^1.23.1 | 4.4.2 | **Yes (1→4)** | Bump in lockstep with Astro's bundled shiki (astro 7.2.0 depends on `shiki ^4.0.2`); review `matchAlgorithm: "v3"` default |
| @fontsource-variable/inter | ^5.1.0 | 5.3.0 | No | Bump |
| @fontsource-variable/jetbrains-mono | ^5.1.1 | 5.3.0 | No | Bump |
| luxon | ^3.5.0 | 3.7.2 | No | Bump |
| @types/luxon | ^3.4.2 | 3.7.3 | No | Bump; luxon still does **not** ship its own types |
| @types/node | ^22.10.0 | 26.1.2 | Type-level only | Align with active Node LTS: `^24` |
| prettier | ^3.4.1 | 3.9.6 | Formatting-only changes | Bump (pin exact version per Prettier recommendation) and re-format once |
| prettier-plugin-astro | ^0.14.1 | 0.14.1 | No | Already latest |
| prettier-plugin-organize-imports | ^4.1.0 | 4.3.0 | No | Bump |
| rehype-autolink-headings | ^7.1.0 | 7.1.0 | No | Already latest |
| rehype-external-links | ^3.0.0 | 3.0.0 | No | Already latest |
| rehype-slug | ^6.0.0 | 6.0.0 | No | Already latest |

### tailwindcss 3.4.15 → 4.3.3

Sources: <https://tailwindcss.com/docs/upgrade-guide>, `https://registry.npmjs.org/tailwindcss/latest`.

Tailwind v4 is a full rewrite (CSS-first configuration). Breaking changes relevant to this site:

- **CSS entrypoint** — `@tailwind base/components/utilities` are removed; use `@import "tailwindcss";`. Affects `src/assets/css/app.css` (lines 4–6). <https://tailwindcss.com/docs/upgrade-guide#removed-tailwind-directives>
- **Build integration** — v4 is no longer a PostCSS plugin in the core package; the recommended integration is the `@tailwindcss/vite` plugin (Astro builds on Vite). This replaces `@astrojs/tailwind` — see the astro-core section for the integration decision. <https://tailwindcss.com/docs/upgrade-guide#using-vite>
- **Custom `hocus:` variant** — the JS plugin API (`addVariant`) still works in v4 when the plugin is loaded via `@plugin "./src/lib/tailwindcss/hocus.cjs"` in CSS, but the idiomatic v4 replacement is a one-liner in CSS, e.g. `@custom-variant hocus (&:hover, &:focus);`, which would let us delete `src/lib/tailwindcss/hocus.cjs`. The guide itself demonstrates `@custom-variant` for overriding `hover`. Affects `src/lib/tailwindcss/hocus.cjs`, `src/layouts/Blog.astro` (uses `hocus:text-orange-300`, `hocus:underline`). <https://tailwindcss.com/docs/upgrade-guide#hover-styles-on-mobile>
- **JS config no longer auto-detected** — `tailwind.config.cjs` is only loaded if referenced via `@config "../tailwind.config.cjs";`. `corePlugins`, `safelist`, `separator` config options are gone. Our config's `theme.extend.fontFamily` and `theme.extend.typography` customizations either migrate to `@theme` / CSS variables or stay in a JS config loaded via `@config`. Affects `tailwind.config.cjs`. <https://tailwindcss.com/docs/upgrade-guide#using-a-javascript-config-file>
- **Custom utility in `@layer utilities`** — v4 no longer hijacks `@layer`; `.contain-paint` in `src/assets/css/app.css` should become `@utility contain-paint { contain: paint; }` to remain a real utility (variant-compatible). Used in `src/pages/blog/[slug].astro` and `src/pages/blog/index.astro`. <https://tailwindcss.com/docs/upgrade-guide#adding-custom-utilities>
- **Renamed/removed utilities present in this repo**: `flex-grow` (→ `grow`) in `src/layouts/Blog.astro:45`; `space-x-*`/`space-y-*` selectors changed from `> :not([hidden]) ~ :not([hidden])` to `> :not(:last-child)` — visual spacing on the about page (`src/pages/about/_layout.astro` uses `space-y-reverse`) should be eyeballed after upgrade. <https://tailwindcss.com/docs/upgrade-guide#removed-deprecated-utilities>, <https://tailwindcss.com/docs/upgrade-guide#space-between-selector>
- **Variant stacking order** reversed (left-to-right in v4) — only matters for stacked variants; `group-hover:underline` etc. are single-stacked and unaffected. <https://tailwindcss.com/docs/upgrade-guide#variant-stacking-order>
- **Browser baseline** — v4 requires Safari 16.4+, Chrome 111+, Firefox 128+. <https://tailwindcss.com/docs/upgrade-guide#browser-requirements>
- **Official codemod** — `npx @tailwindcss/upgrade` (requires Node 20+) automates dependency updates, config-to-CSS migration, and template changes. Run on a branch and review the diff. <https://tailwindcss.com/docs/upgrade-guide#using-the-upgrade-tool>

### @tailwindcss/typography 0.5.15 → 0.5.20

Sources: <https://github.com/tailwindlabs/tailwindcss-typography/releases>, <https://github.com/tailwindlabs/tailwindcss-typography/blob/main/README.md>.

- No breaking changes; 0.5.16 added Tailwind v4 install support, 0.5.20 supports stable v4. In v4 the plugin is registered in CSS: `@plugin "@tailwindcss/typography";` (README "Installation").
- This site's heavy `theme.extend.typography` customization in `tailwind.config.cjs` (lines 14–111: `--tw-prose-*` variable overrides plus element styles for `a`, `pre`, `code`, `img`, `strong`, headings) is JS-config-based. Options in v4: keep a slim JS config loaded via `@config` for the typography theme, or move the `--tw-prose-*` overrides into CSS (the README documents overriding prose CSS variables via `@utility prose-*` for custom themes — but per-element style overrides like `code::before: false` still require the JS theme config). <https://github.com/tailwindlabs/tailwindcss-typography/blob/main/README.md#adding-custom-color-themes>

### @shikijs/transformers 1.23.1 → 4.4.2

Sources: <https://shiki.style/blog/v2>, <https://github.com/shikijs/shiki/releases/tag/v3.0.0>, <https://github.com/shikijs/shiki/releases/tag/v4.0.0>, <https://shiki.style/packages/transformers>.

- **v2.0.0**: no hard breaking changes; deprecation warnings enabled by default (stepping-stone release). <https://shiki.style/blog/v2>
- **v3.0.0**: removed APIs deprecated in v2 (`getHighlighter`, `loadWasm`, `@shikijs/compat`, etc.). The site uses none of these — only `transformerNotationDiff` / `transformerNotationHighlight`, which are untouched. <https://github.com/shikijs/shiki/releases/tag/v3.0.0>
- **v4.0.0**: dropped Node 18, removed deprecated APIs; no changes to the transformers API surface. <https://github.com/shikijs/shiki/releases/tag/v4.0.0>
- **`matchAlgorithm` default changed from `v1` to `v3`** (landed with shiki v3): affects how `// [!code highlight:N]` counts lines (v3 counts from the line *below* the comment instead of counting the comment line). Verified in the v4.4.2 dist: `matchAlgorithm ??= "v3"`. This site's posts only use trailing same-line markers (`// [!code ++]` in `src/content/blog/2020-04-20-implementing-dark-color-scheme-with-tailwindcss/index.md` and `src/content/blog/2022-02-06-sql-mass-updating/index.md`), which are unaffected — but if any `:N` range markers exist later, set `matchAlgorithm` explicitly. <https://shiki.style/packages/transformers#matching-algorithm>
- **Version must match Astro's bundled shiki**: Astro's `markdown.shikiConfig.transformers` are applied by Astro's own shiki instance, so `@shikijs/transformers` majors must align with the `shiki` major Astro depends on (astro 7.2.0 → `shiki ^4.0.2`, per `https://registry.npmjs.org/astro/latest`). Custom languages passed via `shikiConfig.langs` (`src/lib/shiki/languages.mjs`, mixing `bundledLanguages` keys with a `LanguageRegistration` object) are still the supported mechanism in current Astro/shiki.
- Note: `src/lib/shiki/languages.mjs` imports the JSON grammar with `assert { type: 'json' }`; current Node versions emit a warning for `assert` in favor of `with` — unrelated to shiki itself, but worth fixing during the upgrade.

### @fontsource-variable/inter 5.1.0 / jetbrains-mono 5.1.1 → 5.3.0

Sources: `https://registry.npmjs.org/@fontsource-variable/inter/latest`, `https://registry.npmjs.org/@fontsource-variable/jetbrains-mono/latest`.

- No breaking changes between 5.1 and 5.3 (font data/metadata updates). Package entry is still `index.css`, so `@import '@fontsource-variable/inter';` / `@import '@fontsource-variable/jetbrains-mono';` in `src/assets/css/app.css` keep working unchanged. Verified via the published `exports` map of `@fontsource-variable/inter@5.3.0` (`"."`, `"./*.css"`, …).
- Interaction with Tailwind v4: CSS `@import`s must precede other statements; keep the fontsource imports at the top of `app.css` (they already are).

### luxon 3.5.0 → 3.7.2 / @types/luxon 3.4.2 → 3.7.3

Sources: <https://github.com/moment/luxon/blob/master/CHANGELOG.md>, `https://registry.npmjs.org/luxon/latest`, `https://registry.npmjs.org/@types/luxon/latest`.

- 3.6.0/3.6.1/3.7.0–3.7.2 are additive/bugfix releases (new `Duration#removeZeros`, `toHuman` `showZeros`, lowercase `t`/`z` ISO acceptance, etc.). No breaking changes.
- **Luxon still does not bundle its own types** — the `luxon` package has no `types`/`typings` field (verified on the registry). Keep `@types/luxon` and bump it to 3.7.3 alongside.

### @types/node 22.10.0 → align with Node LTS

Source: <https://github.com/nodejs/Release#release-schedule> (`schedule.json`).

- As of 2026-08-06: **Node 24 is the active LTS** (LTS since 2025-10-28, maintenance from 2026-10-20, EOL 2028-04-30). Node 22 is in maintenance LTS (EOL 2027-04-30). Node 26 is Current (becomes LTS 2026-10-28). Node 20 went EOL 2026-04-30.
- Recommendation: `@types/node ^24` to match the active LTS (or `^26` if the build/deploy environment already runs Node 26). Type-only dependency — no runtime impact.

### prettier 3.4.1 → 3.9.6, prettier-plugin-organize-imports 4.1.0 → 4.3.0, prettier-plugin-astro

Sources: <https://prettier.io/blog/2025/02/09/3.5.0.html>, <https://prettier.io/blog/2025/06/23/3.6.0.html>, <https://prettier.io/blog/2025/11/27/3.7.0.html>, <https://prettier.io/blog/2026/01/14/3.8.0.html>, <https://prettier.io/blog/2026/06/27/3.9.0.html>, <https://github.com/simonhaenisch/prettier-plugin-organize-imports/releases>, <https://github.com/withastro/prettier-plugin-astro/releases>.

- Prettier 3.5–3.9 contain **no breaking config changes**, but minors do change formatting output: 3.5 added `objectWrap` (default unchanged) and TS config file support; 3.7 changed class/interface formatting consistency; 3.9 upgraded the Markdown parser from remark-parse v8 to micromark v4 and `yaml` to v2 (both can reformat this repo's Markdown posts/frontmatter). Plan one repo-wide re-format after bumping. Prettier officially recommends pinning the exact version.
- `prettier-plugin-organize-imports` 4.2.0/4.3.0: Vue-only fixes plus a new `organizeImportsTypeOrder` option; no breaking changes for this (non-Vue) site.
- `prettier-plugin-astro` is already at latest (0.14.1) and is Astro-5-era current; re-verify formatting once on the upgraded Astro version.

### rehype-autolink-headings 7.1.0 / rehype-external-links 3.0.0 / rehype-slug 6.0.0

Sources: `https://registry.npmjs.org/rehype-autolink-headings/latest`, `https://registry.npmjs.org/rehype-external-links/latest`, `https://registry.npmjs.org/rehype-slug/latest`.

- All three are **already at their latest versions** — the package.json pins match the newest releases as of 2026-08-06. No action; keep the existing usage in `astro.config.mjs` (`rehypePlugins`).
