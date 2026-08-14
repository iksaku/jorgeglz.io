# Head / Metadata Management for Astro — Research Report

Researched against primary sources on 2026-08-14. Every claim is cited to its owning source (official docs, source repos, or the npm registry). The question answered here: **should jorgeglz.io (an Astro 7.2 static blog) adopt a head-management library — and if so, which one — or keep its hand-rolled `Seo.astro`?** The reference API surface being compared against is Laravel Head v13.

## Grounding: current state

`src/components/Seo.astro` (read in full) is a hand-rolled component that already emits, per page:

- `<title>{title} | JorgeGlz</title>` and `<link rel="canonical" href={Astro.url}>`
- `<meta name="description">`
- Full Open Graph set with `property=` and an `og:image` object expanded to `og:image`, `og:image:width`, `og:image:height`, `og:image:alt` (via `astro:assets` `getImage`), plus `og:site_name`, `og:locale`
- `article:author` / `article:published_time` / `article:modified_time` when the `article` prop is present
- Full `twitter:*` set (`card`, `site`, `creator`, `title`, `description`, `image`, `image:alt`)
- `BlogPosting` JSON-LD (`<script is:inline type="application/ld+json">`) for posts; `WebSite` JSON-LD is emitted separately in `src/pages/blog/index.astro`

So the component already covers the Laravel Head surface's *document/social/structured-data* columns for this site's two page types (post, index). What it lacks vs Laravel Head: a defaults/merge/precedence model, theme color, icons, performance hints, and robots (all trivial to add by hand). This is the baseline any library must beat.

## Reference surface: Laravel Head v13 (from the official docs)

Source: <https://laravel.com/docs/13.x/head>

- **Fluent builder** driven from a service provider: `Head::defaults(fn (HeadBuilder $head) => $head->title('Laravel', suffix: ' - Laravel')->description('Build something great.'))`, with per-page overrides at runtime via `Head::title($post->title)->description(...)`.
- **Five-layer precedence**, field by field, lowest to highest: *Page defaults → Route group metadata → Route metadata → Runtime metadata → Error metadata* ("Higher layers replace lower layers field by field"). Single-value fields (title, description, canonical, robots) resolve to the later call; repeatable fields (e.g. `ogImage`, `preload`, `feed`, `schema`, `icon`) retain multiple entries, keyed so re-adding the same key updates the earlier entry (`ogImage` is keyed by URL).
- **Auto-generation**: "Document title and description automatically fill missing `og:title` and `og:description` values"; `ogImage(url, alt:, width:, height:, type:)` expands to `og:image` + `og:image:width/height/alt`; passing an image via `og(image: ...)` writes to the same list.
- **Twitter**: `twitter(card: TwitterCard::SummaryWithLargeImage)`; providing OG + `ogImage` renders matching `twitter:*` tags (the docs show `twitter:card`, `twitter:title`, `twitter:description` emitted from the OG example).
- **Structured data**: `Head::schema(Schema::blogPosting()/article()/breadcrumbs()/faq()/product()/...)` plus custom `Schema::register()` types.
- **Other columns**: theme color (`themeColor`), application metadata/icons (`icon`, `favicon`, `appleTouchIcon`, `appleTouchStartupImage`, `maskIcon`, `manifest`), performance hints (`preload`, `prefetch`, `preconnect`, `dnsPrefetch`, `preloadAsset`/`prefetchAsset`), and custom tags (`meta`, `link`).

---

## Candidate profiles

### 1. Unhead (`unhead`) — **no official Astro integration**

Repo: <https://github.com/unjs/unhead> · Docs: <https://unhead.dev/> · npm: `unhead` v3.3.2 (MIT), ~3.5 M downloads/week (npm API, last-week point).

**Critical, verified finding — there is no `@unhead/astro`.** The package requested in the task brief does not exist on npm: `https://registry.npmjs.org/@unhead%2Fastro` returns HTTP 404. The unhead monorepo (`unjs/unhead`, `main` branch tree fetched) has packages for `angular`, `react`, `solid-js`, `svelte`, `vue`, `schema-org`, `unhead`, `bundler` — and **no `astro` package**. The repo's `docs/` tree contains framework sections only for `0.angular`, `0.nuxt`, `0.react`, `0.solid-js`, `0.svelte`, `0.typescript`, `0.vue` — **no Astro section**. Unhead is a framework-agnostic head manager whose official integrations are the per-framework adapters; an Astro adapter is not among them.

**API shape.** Core is framework-agnostic and requires a `createUnhead()` instance; official framework adapters wrap it (e.g. `@unhead/vue`). The core composables (verified in `packages/unhead/src/composables.ts`):

```ts
export function useHead<T>(unhead, input?: ResolvableHead, options?: HeadEntryOptions): ActiveHeadEntry<I>
export function useHeadSafe<T>(unhead, input?: HeadSafe, options?: HeadEntryOptions): ActiveHeadEntry<HeadSafe>
export function useSeoMeta<T>(unhead, input: UseSeoMetaInput = {}, options?): ActiveHeadEntry<UseSeoMetaInput>
```

**SeoMeta and what it auto-generates.** `useSeoMeta` uses a `FlatMetaPlugin` and `unpackMeta` (`packages/unhead/src/utils/meta.ts`) to map *flat keys* (`ogTitle`, `ogDescription`, `twitterCard`, …) to real tags with the correct attribute: `og`/`article`/`book` namespaces → `property=`, `twitter`/`fediverse` → `name=`. An image **object** value for `ogImage`/`twitterImage` (e.g. `{ url, width, height, alt }`) expands to `og:image` + `og:image:width` + `og:image:height` + `og:image:alt` (the `MEDIA_KEYS` branch in `unpackMeta`). So Unhead gives the same image-expansion behavior as Laravel Head's `ogImage(...)`.

**However, Unhead does NOT auto-fill OG/Twitter from title/description by default.** That inference lives in an opt-in `InferSeoMetaPlugin` (`packages/unhead/src/plugins/inferSeoMetaPlugin.ts`), which is a separate plugin you must call `unhead.use(InferSeoMetaPlugin(...))` on; it emits `og:title`/`og:description`/`twitter:card` from the resolved title/description. This is analogous to — but weaker than — Laravel Head's built-in "title/description automatically fill missing og:*" behavior, and it is not part of `useSeoMeta` itself.

**Defaults / merge / precedence.** Unhead dedupes tags by `key` and honors `tagPriority`/`tagPosition`, but it has **no Laravel-Head-style layered default→route→runtime precedence model**. "Defaults" are expressed by pushing a base head entry (e.g. a layout calling `useHead` with site defaults) that later per-page entries override by key. It is a per-request tag accumulator, not a five-layer field-resolution system.

**Astro integration mechanics.** There is no official one. The only path on npm is the third-party `astro-unhead` (below). Any manual Astro integration would require creating a `createUnhead()` per page/render, calling composables during Astro's render, and injecting the resolved tags into `<head>` — i.e. reimplementing what an adapter should do. Unhead is SSR-oriented and static-output-compatible in principle (its server entry renders tags to HTML strings), but with no Astro adapter the integration work is on the user.

**TypeScript.** Strong — the package ships `.d.ts` (exports `./dist/index.d.ts`), and `UseSeoMetaInput`/`MetaFlat` are deeply typed.

**Maintenance.** Very healthy: v3.3.2, MIT, published 2026-08-13 (npm `time.modified`), ~3.5 M downloads/week, main maintainer `harlan_zw` (the same author as Nuxt SEO). Monorepo actively developed.

**Health for *this* decision:** the missing Astro adapter is the deal-breaker regardless of how healthy the core is.

---

### 2. `astro-unhead` (third-party Unhead adapter) — the only Unhead-for-Astro path

Repo: <https://github.com/Nickersoft/astro-unhead> · npm: `astro-unhead` v1.0.1 (MIT), ~767 downloads/week (npm API), first published 2026-06-11.

**Mechanics (verified from source).** It is a **middleware adapter**, not an integration. `src/middleware.ts` uses `defineMiddleware` from `astro/middleware`, creates a per-request `createHead(init)` held in an `AsyncLocalStorage` context (`ctx.callAsync(head, ...)`), lets the page render, then post-processes the HTML response: `transformHtmlTemplate(head, html)` from `unhead/server` injects the resolved tags into the served `<head>`. It exposes the full unhead toolkit (`useHead`, `useSeoMeta`, `useHeadSafe`, `useScript`, `useSchemaOrg`) from `astro-unhead`, and `useSchemaOrg` from `astro-unhead/schema-org` wired to `@unhead/schema-org`.

**Static build support.** Because Astro runs middleware at build time for statically rendered pages and `transformHtmlTemplate` rewrites the final HTML string, this *can* produce static output with tags baked in. It also supports a streaming mode. Caveat: middleware-based head injection rewrites the full HTML response, so it behaves differently from a first-party integration and must be sequenced with any other middleware.

**Health.** Very new and low-adoption: created and first published 2026-06-11, v1.0.1, ~767 downloads/week. It is a single-community-package adapter with no official status from unjs. Maintenance risk is the main concern for a site that wants a stable dependency.

---

### 3. `astro-seo` (jonasmerlin)

Repo: <https://github.com/jonasmerlin/astro-seo> · npm: `astro-seo` v1.1.0 (MIT), ~123 k downloads/week (npm API), last publish 2026-01-13, repo `pushed_at` 2026-01-14, 1381 stars, 7 open issues.

**API shape.** A single `.astro` **component** rendered inside `<head>` with props (verified from `src/SEO.astro`): `title`, `titleTemplate`, `titleDefault`, `charset`, `description`, `canonical`, `noindex`/`nofollow`/`noarchive`/`nocache`/`robotsExtras`, `languageAlternates`, `openGraph` (`basic`/`optional`/`image`/`article`), `twitter`, `extend` (raw `link`/`meta` arrays), `removeTrailingSlashForRoot`. It computes a default self-referential canonical from `Astro.site`/`Astro.url`.

**Auto-generation.** Minimal. It emits title/canonical/description/robots always, and OG/Twitter **only from the explicit `openGraph`/`twitter` props** — there is no inference from `title`/`description`. It emits a `robots` meta even when no restrictions are set (defaults to `index, follow`). It does **not** expand image dimensions/alt automatically (you pass `openGraph.image.{width,height,alt}`), and it emits **no JSON-LD** at all (no `BlogPosting`/`WebSite`). The repo has **no** schema/structured-data component.

**Defaults / merge / precedence.** None — it's a pure per-page component. Site-wide defaults must be re-declared on every page or wrapped in your own layout.

**Astro integration mechanics.** Native `.astro` component; renders at build, fully static-output compatible, no middleware, works with Astro's `is:inline`/islands trivially (it's just markup). Uses `set:html` for the title.

**TypeScript.** Ships props interfaces (`Props`, `TwitterCardType`, `Link`, `Meta`) in the `.astro` frontmatter.

**Health.** Healthy and popular (123 k/wk, maintained through Jan 2026, MIT). It is the most adopted pure-component SEO option for Astro.

**Fit for this site:** it covers OG/Twitter/canonical/robots, but you would still hand-write the `BlogPosting`/`WebSite` JSON-LD scripts and the `og:image` width/height/alt expansion (it accepts them but doesn't derive them), and you lose the current component's `article:*` + image-object convenience. Net code reduction is marginal.

---

### 4. `astro-seo-meta`

Repo: <https://github.com/codiume/orbit> (monorepo `packages/astro-seo-meta`) · npm: `astro-seo-meta` v7.0.0 (MIT), ~2.2 k downloads/week (npm API), last publish 2026-06-22, repo `pushed_at` 2026-08-13, 605 stars, 1 open issue, `peerDependencies: astro ^7.0.0`.

**API shape.** A `<Seo>` component that composes three subcomponents (verified from `src/Seo.astro`, `Meta.astro`, `Facebook.astro`, `Twitter.astro`): props `title`, `description`, `keywords`, `icon`, `themeColor`, `colorScheme`, `robots`, `facebook` (`url`/`type`/`image`), `twitter` (`card`/`site`/`image`).

**Auto-generation.** Emits `<title>`, description, keywords, icon, `color-scheme`, `theme-color`, robots, `og:*` (`og:url/type/title/description/image` via `Facebook.astro`), and `twitter:*` (`twitter:card/site/title/description/image` via `Twitter.astro`). It passes the same `title`/`description` to OG and Twitter (so it *shares* values, but does not infer anything). It does **not** emit canonical, **no** `og:image:width/height/alt`, **no** `og:site_name`/`og:locale`, **no** `article:*`, and **no JSON-LD**.

**Defaults / merge / precedence.** None — pure per-page component.

**Astro mechanics.** Native `.astro` components, static-build compatible, no middleware.

**Health.** Maintained (pushed 2026-08-13), MIT, but low adoption (~2.2 k/wk) and a narrower feature set. For this site it is strictly *less* capable than the current hand-rolled `Seo.astro` (no canonical, no image dimensions/alt, no JSON-LD), so it is not a candidate.

---

### 5. Astro ecosystem / adjacent (brief)

These cover *parts* of the surface but are not head managers; listed only to acknowledge what exists.

- **`@astrojs/sitemap`** — official Astro integration, v3.7.3, ~2.26 M downloads/week, last publish 2026-05-26. Generates `sitemap.xml` from routes; handles the sitemap column only. Docs: <https://docs.astro.build/en/guides/integrations-guide/sitemap/>. Out of scope as a head manager.
- **`astro-robots-txt`** (repo `alextim/astro-lib`, MIT) — v1.0.0, ~24 k downloads/week, **last publish 2023-09-08** and repo last pushed 2023-12-15 (stale). Builds `robots.txt` (and optionally sitemap + web app manifest) via an integration. Covers the robots.txt *file*, not per-page robots *meta*; effectively unmaintained. Repo: <https://github.com/alextim/astro-lib>.
- **Astro's official SEO guidance** — the former page at `docs.astro.build/en/guides/seo/` now returns HTTP 404; current official guidance on head/meta lives inside the Layouts and Config docs (e.g. <https://docs.astro.build/en/basics/layouts/> recommends a `BaseHead.astro` component pattern for "SEO meta tags"). Astro's position is that head/meta is ordinary markup in a layout component — there is no first-party head-management API. <https://docs.astro.build/en/basics/layouts/>

**Framework analogues that do NOT fit Astro** (one paragraph, no deep dive): Nuxt uses Nuxt SEO / `unhead-vue` because it is Vue+Nuxt-specific (<https://nuxt.com/docs/getting-started/seo-meta>); `next-seo` is a React/Next.js component library (<https://github.com/garmeeh/next-seo>); `react-helmet` / `react-helmet-async` manage head reactively for React only (<https://github.com/nfl/react-helmet>); TanStack Router's `HeadContent`/`Meta` is coupled to its React/Vue router context (<https://tanstack.com/router/latest/docs/framework/react/guide/document-head-management>). All four assume a client-rendered or framework-routed app and a reactive runtime; Astro is static-first and renders head as plain markup at build time, so these are out of scope — they neither generate static tags at build nor match Astro's component model.

---

## Feature-coverage table (vs Laravel Head v13 surface)

| Laravel Head surface | `unhead` (official) | `astro-unhead` (3rd-party) | `astro-seo` | `astro-seo-meta` | Current `Seo.astro` |
| --- | --- | --- | --- | --- | --- |
| title / description | ✅ (`useHead`) | ✅ | ✅ | ✅ | ✅ |
| canonical | ✅ (`link`) | ✅ | ✅ (self-ref default) | ❌ | ✅ |
| robots (per-page meta) | ✅ (`meta.robots`) | ✅ | ✅ (noindex/nofollow/…) | ✅ (raw string) | ❌ (absent; defaults apply) |
| OG (`og:title/description/…`) | ✅ via `useSeoMeta` flat keys | ✅ | ✅ (explicit props) | ✅ | ✅ |
| OG image w/ width/height/alt | ✅ object→expansion | ✅ | ✅ (pass-through, not derived) | ❌ (image only) | ✅ (via `astro:assets`) |
| `article:*` tags | ✅ (flat keys) | ✅ | ✅ (`openGraph.article`) | ❌ | ✅ |
| Twitter cards | ✅ (`twitter*` keys) | ✅ | ✅ | ✅ | ✅ |
| JSON-LD structured data | ✅ via `@unhead/schema-org` (`defineArticle`/`defineWebSite`) | ✅ (`useSchemaOrg`) | ❌ | ❌ | ✅ (hand-written) |
| Defaults + per-page precedence (5-layer) | ⚠️ tag dedupe only; **no layer model** | ⚠️ same as unhead | ❌ | ❌ | ❌ |
| Auto-fill og from title/description | ⚠️ only via opt-in `InferSeoMetaPlugin` | ⚠️ same | ❌ | ❌ | ❌ (explicit, but site is 2 page types) |
| theme color | ✅ | ✅ | ❌ | ✅ | ❌ |
| icons (favicon/apple-touch-icon/…) | ✅ | ✅ | ✅ (`extend.link`) | ✅ (`icon`) | ❌ |
| performance hints (preload/prefetch/preconnect) | ✅ | ✅ | ✅ (`extend.link`) | ❌ | ❌ (uses Astro `rel="prefetch"` on links) |
| Official Astro integration | ❌ **none** | ✅ (3rd-party middleware) | ✅ (native component) | ✅ (native component) | n/a |

---

## Recommendation

**Keep the hand-rolled `Seo.astro`. Do not adopt a head-management library for this site.** Reasoning:

1. **Unhead has no official Astro integration** — this is decisive. The task brief assumed `@unhead/astro`; it does not exist (npm 404, no such package in the unjs/unhead monorepo, no Astro section in its docs). Adopting Unhead means either the very-new, low-adoption third-party `astro-unhead` middleware (~767 downloads/week, published 2026-06-11) or hand-rolling an adapter yourself. That is a maintenance and trust cost on a personal static blog with no runtime/dynamic metadata needs.

2. **Unhead's model doesn't match what Laravel Head gives you anyway.** Laravel Head's headline feature is five-layer default→route→runtime precedence and auto-filling og from title/description. Unhead (even fully integrated) has neither a layer model (only tag dedupe + an opt-in `InferSeoMetaPlugin`) — so adopting it would *not* reproduce the Laravel Head behavior the user cited, and would add ~3.5 M-download dependency weight for a feature the site doesn't need (there is no SSR, no runtime metadata, only two static page types).

3. **The lighter components are strictly less capable than the current code.** `astro-seo` (123 k/wk) covers OG/Twitter/canonical/robots but emits **no JSON-LD** and doesn't derive image dimensions/alt — you'd keep hand-writing the `BlogPosting`/`WebSite` scripts and the `og:image` expansion, so code is not reduced. `astro-seo-meta` (2.2 k/wk) lacks canonical, `og:image` dimensions/alt, `og:site_name`/`og:locale`, `article:*`, and JSON-LD — adopting it would be a *regression*.

4. **Auto-generation would not reduce code here.** The current `Seo.astro` (~100 lines) already derives everything from `title`/`description`/`image`/`article` props, including image width/height via `astro:assets` and both JSON-LD blocks. There is no repeated boilerplate across many templates to eliminate — the component is used from layouts, and the site has two page shapes. Laravel Head's auto-fill exists to save per-page declaration in a large, dynamic app; this static blog has nothing to save.

### Tradeoffs of the recommendation

- **If you later add SSR/on-demand rendering, many layouts, or runtime/dynamic metadata:** revisit Unhead via `astro-unhead` (or a future first-party adapter) — it is the only candidate that approaches Laravel Head's structured-data + social surface, and it is healthy (~3.5 M/wk, active 2026-08). But treat `astro-unhead`'s single-package status as a dependency-risk flag until it matures.
- **If you want a maintained, popular component with minimal effort and are willing to hand-write JSON-LD:** `astro-seo` is the reasonable middle option — but for this site it swaps a working 100-line component for a dependency plus the same JSON-LD you already write.
- **Small gaps worth closing by hand** (not by a library): add a self-referential `robots` meta only where you want restrictions (e.g. drafts), a `theme-color`, and an `icon` link — all one-liners in the existing component. `@astrojs/sitemap` (official) is the only adjacent addition with real value if a sitemap is wanted.

**Net:** the current hand-rolled `Seo.astro` already equals or exceeds every candidate's feature coverage for this site's two static page types, with zero dependency and no integration risk. Adopt a library only if the site's metadata requirements grow (runtime metadata, many layouts) — and when that happens, Unhead is the strongest technical choice but lacks an official Astro adapter today.
