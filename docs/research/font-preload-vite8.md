# Research: Font-preload integration under Astro 7 / Vite 8 — keep, fix, or delete

Ticket: <https://github.com/iksaku/jorgeglz.io/issues/49>
Subject: `src/lib/font-preload/index.mjs` — an `astro:build:done` integration that regex-scans `dist/_astro/*.css` for `.woff2` URLs and regex-rewrites every built HTML page's `<head>` to inject `<link rel="preload" as="font" type="font/woff2">` tags.
Date: 2026-08-07. Target state: Astro 7.2.0 + Vite 8 (per `docs/upgrade-research.md`).

## Verdict: **DELETE**

The integration still *runs* under Astro 7 + Vite 8 (hook, asset layout, and the `<head>` regex all survive), but it should be deleted at the Astro 7 step and replaced with Astro's now-stable **Fonts API**, which does the same job natively, at render time, and correctly. Keeping it is not neutral: as written it preloads *every subset* of both variable fonts on every page, defeating `unicode-range` subsetting — an explicit anti-pattern per web.dev.

## Q1 — Does `astro:build:done` and the `dist/_astro` layout survive into Astro 7 + Vite 8?

**Yes.**

- Astro v7.0 upgrades to Vite 8 as the dev server and production bundler; "Most Astro users should be able to upgrade without any changes to their project code. This is primarily a breaking change for Astro integrations and plugins that depend on Vite internals." The font-preload integration uses no Vite APIs — only `node:fs/promises` against `dist/`. <https://docs.astro.build/en/guides/upgrade-to/v7/#vite-8>
- `astro:build:done` is still a documented built-in hook in the current (v7) Integration API reference, with a *superset* of the old contract: `(options: { pages: { pathname: string }[]; dir: URL; assets: Map<string, URL[]>; logger: AstroIntegrationLogger })`. The integration only destructures `dir`, which is unchanged. (Notably, the hook now hands you per-page `assets` — the regex-scan of HTML for stylesheet names was never necessary even mechanically.) <https://docs.astro.build/en/reference/integrations-reference/#astrobuilddone>
- The asset directory convention is unchanged: `build.assets` default is still `'_astro'` in the current configuration reference, so built CSS/fonts still land in `dist/_astro/` with hashed filenames. <https://docs.astro.build/en/reference/configuration-reference/#buildassets> (also visible in current docs examples such as `/_astro/my_image.hash.webp` at <https://docs.astro.build/en/guides/images/>)

## Q2 — Does `compressHTML: 'jsx'` break the `<head>` regex?

**No.**

- Astro v7.0 changes the `compressHTML` default from `true` to `'jsx'`: whitespace is now stripped using JSX rules (like React). The documented effect is limited to whitespace between elements (e.g. `<span>hello</span>\n<em>world</em>` rendering as `helloworld`). It does not rename, restructure, or remove elements. <https://docs.astro.build/en/guides/upgrade-to/v7/#new-default-whitespace-handling-compresshtml-jsx>
- The integration's patterns — `/<head>(.*)<\/head>/s` and the replace of `/<head>.*<\/head>/s` — only depend on literal `<head>`/`</head>` tags with no attributes, which compression never alters. If anything, JSX-style whitespace stripping makes the single-line `(.*)` match *more* reliable, not less.
- Side note: the v7 Rust compiler may change `url()` quoting in serialized CSS ("`url()` values may gain or lose quotes… does not require any action unless you have tests or tools that rely on exact CSS string matching"). The integration's `/\/\S*\.woff2/g` scan is insensitive to this because the match terminates at the literal `.woff2` before any trailing quote. <https://docs.astro.build/en/guides/upgrade-to/v7/#css-output-differences>

## Q3 — Is there now a native Astro fonts/preload path that replaces the integration?

**Yes — the Fonts API, experimental in Astro 5, is stable in current (v7) docs and is a direct, superior replacement.**

- Fonts are registered in the top-level `fonts` config key with a built-in **Fontsource provider**: `fonts: [{ provider: fontProviders.fontsource(), name: "Inter", cssVariable: "--font-inter" }]`. Local files and Google/Bunny/Adobe/etc. providers are also built in. <https://docs.astro.build/en/guides/fonts/#configuring-custom-fonts> <https://docs.astro.build/en/reference/configuration-reference/#fonts>
- The `<Font />` component from `astro:assets` is placed in the page `<head>` and emits the `@font-face` CSS; passing **`preload`** injects `<link rel="preload">` tags **at render time** — exactly what the integration post-processes in, but natively, per-page, and with the correct hashed URLs (no regex, no post-build rewrite): `<Font cssVariable="--font-inter" preload />`. <https://docs.astro.build/en/guides/fonts/#applying-custom-fonts> <https://docs.astro.build/en/reference/modules/astro-assets/#font->
- The API "helps you keep your site performant with automatic web font optimizations including preload links, optimized fallbacks, and opinionated defaults"; fonts are downloaded/cached and self-hosted under `_astro/fonts` for long-lived HTTP caching. <https://docs.astro.build/en/guides/fonts/>
- Migration shape for this site: replace the two `@import '@fontsource-variable/…'` lines in `src/assets/css/app.css` with two `fonts` entries (Fontsource provider supports weight lists; for variable-font behavior the local provider accepts a `weight: "100 900"` range with files copied out of the installed `@fontsource-variable/*` packages), register the CSS variables in Tailwind v4 via `@theme inline { --font-sans: var(--font-inter); }`, and put `<Font cssVariable preload />` in the layout head. <https://docs.astro.build/en/guides/fonts/#register-fonts-in-tailwind> <https://docs.astro.build/en/guides/fonts/#using-variable-fonts>

## Q4 — The performance case: is manual woff2 preloading still right for a two-font static site?

**Preloading the *critical* font file is still recommended; preloading *everything the CSS references* — what this integration does — is an anti-pattern.**

- web.dev, "Best practices for fonts": with external stylesheets "preloading the most important fonts can be very effective since the browser won't otherwise discover whether the font is needed until much later" — the late-discovery problem is real and preload is a valid fix. <https://web.dev/articles/font-best-practices#be_cautious_when_using_preload_to_load_fonts>
- But the same source: "**Be cautious when using `preload`** … this comes at the cost of taking away browser resources from the loading of other resources", and crucially "**preload ignores `unicode-range` declarations**, and if used prudently, should only be used to load a single font format." <https://web.dev/articles/font-best-practices#be_cautious_when_using_preload_to_load_fonts>
- This is exactly what the integration gets wrong today. `@fontsource-variable/inter@5.3.0/index.css` declares **7 subset `@font-face` blocks** (cyrillic-ext, cyrillic, greek-ext, greek, vietnamese, latin-ext, latin), each pointing at a separate `.woff2` gated by `unicode-range` (verified: <https://cdn.jsdelivr.net/npm/@fontsource-variable/inter@5.3.0/index.css>). The integration's `contents.match(/\/\S*\.woff2/g)` collects *all* of them and injects a preload tag per file into every page that includes the stylesheet. Because preload ignores `unicode-range`, browsers fetch every subset — roughly a dozen font files instead of the 1–2 latin files the page would otherwise download. HTTP/2 on Cloudflare Pages makes those downloads cheap, but they still compete with CSS/JS on initial load and waste bandwidth.
- Fontsource's own preload guide says the same: preload "only critical fonts and subsets … such as the latin subset only", warns of negative Core Web Vitals effects otherwise, and confirms the hashed-filename problem that motivated this integration ("bundlers like Vite rewrite URLs to hashed filenames") — the problem Astro's Fonts API now solves natively. <https://fontsource.org/docs/getting-started/preload>
- WOFF2-only, self-hosted, subset fonts remain the recommended delivery baseline in 2026 (web.dev cites the Web Almanac: "Use only WOFF2 and forget about everything else"), so the *technique* isn't obsolete — only this blanket implementation is. <https://web.dev/articles/font-best-practices#use-woff2>

## Recommendation

1. At the Astro 7 upgrade step: **delete `src/lib/font-preload/`** and its registration in `astro.config.mjs`.
2. Adopt the Fonts API: `fonts` config with `fontProviders.fontsource()` (or `fontProviders.local()` with the variable files + `weight: "100 900"`), `<Font cssVariable="--font-inter" preload />` in the layout `<head>` (preload Inter latin only; JetBrains Mono is used for code blocks — below the fold on index pages — so either don't preload it or preload selectively per Astro's guidance to preload "only the most essential fonts"). <https://docs.astro.build/en/guides/fonts/#applying-custom-fonts>
3. If the team wants to defer the Fonts API migration past the upgrade: the integration will keep functioning under Astro 7 + Vite 8 (Q1/Q2), so no fix is *required* to survive the upgrade — but consider scoping the regex to `-latin-` files as a minimal harm-reduction fix in the interim.
