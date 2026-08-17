# Typography Research — Comfortable Long-Form Reading

Researched against primary sources on 2026-08-17. Every numeric claim cites the source that owns it. The goal is evidence-based values for this dark-theme blog (Inter body, JetBrains Mono code, `@tailwindcss/typography` `prose` in a `max-w-2xl` container), plus the Tailwind v4 utility that realizes each value.

## Recommended values (summary table)

| Property | Recommended value | Source |
| --- | --- | --- |
| Body font size (floor) | ≥ 16px (de-facto floor; WCAG mandates no minimum but requires 200% resizability via relative units) | [WCAG 1.4.4 Resize Text](https://www.w3.org/WAI/WCAG21/Understanding/resize-text.html) |
| Body font size (comfort range, web) | 15–25px | [Butterick — Point size](https://practicaltypography.com/point-size.html) |
| Body font size (design-system default) | 16sp (Body Large); Apple: 17pt default on iOS | [Material 3 type scale tokens](https://m3.material.io/styles/typography/type-scale-tokens) (values verified in [androidx `TypeScaleTokens.kt`](https://raw.githubusercontent.com/androidx/androidx/androidx-main/compose/material3/material3/src/commonMain/kotlin/androidx/compose/material3/tokens/TypeScaleTokens.kt)); [Apple HIG — Typography](https://developer.apple.com/design/human-interface-guidelines/typography) |
| Body font size (comfortable upgrade) | 18px — inside Butterick's 15–25px comfort range and the value `@tailwindcss/typography` picks for `prose-lg` | [Butterick — Point size](https://practicaltypography.com/point-size.html); [tailwindcss-typography `styles.js`](https://raw.githubusercontent.com/tailwindlabs/tailwindcss-typography/main/src/styles.js) |
| Body line-height (accessibility floor) | ≥ 1.5× font size (paragraph spacing ≥ 2×, letter spacing ≥ 0.12×, word spacing ≥ 0.16×) | [WCAG 1.4.12 Text Spacing (AA)](https://www.w3.org/WAI/WCAG21/Understanding/text-spacing.html) |
| Body line-height (AAA) | ≥ 1.5 ("space-and-a-half"); paragraph spacing ≥ 1.5× line spacing | [WCAG 1.4.8 Visual Presentation](https://www.w3.org/WAI/WCAG21/Understanding/visual-presentation.html) |
| Body line-height (typographic optimum) | 1.2–1.45 (120–145% of point size) | [Butterick — Line spacing](https://practicaltypography.com/line-spacing.html) |
| Body line-height (design-system) | 1.5 (24sp on 16sp Body Large) | [androidx `TypeScaleTokens.kt`](https://raw.githubusercontent.com/androidx/androidx/androidx-main/compose/material3/material3/src/commonMain/kotlin/androidx/compose/material3/tokens/TypeScaleTokens.kt) |
| Line length / measure (optimal) | 50–75 characters per line (Ruder: 50–60; up to 75 acceptable) | [Baymard — Readability: The Optimal Line Length](https://baymard.com/blog/line-length-readability) |
| Line length / measure (comfortable range) | 45–90 characters ("2–3 alphabets" test) | [Butterick — Line length](https://practicaltypography.com/line-length.html) |
| Line length / measure (accessibility max) | ≤ 80 characters (≤ 40 for CJK) | [WCAG 1.4.8 Visual Presentation](https://www.w3.org/WAI/WCAG21/Understanding/visual-presentation.html) |
| Line length in CSS | `max-width: ~70ch` or `~34em`, adjusted per font | [Baymard — Readability: The Optimal Line Length](https://baymard.com/blog/line-length-readability) |
| Secondary / caption text minimum | 12px floor: MD3 Body Small & Label Medium = 12sp; smallest MD3 token = 11sp (Label Small); Apple minimum = 11pt iOS / 10pt macOS | [Material 3 type scale tokens](https://m3.material.io/styles/typography/type-scale-tokens) / [androidx tokens](https://raw.githubusercontent.com/androidx/androidx/androidx-main/compose/material3/material3/src/commonMain/kotlin/androidx/compose/material3/tokens/TypeScaleTokens.kt); [Apple HIG — Typography](https://developer.apple.com/design/human-interface-guidelines/typography) |
| Secondary text preferred | 14px for readable meta (dates, descriptions): MD3 Body Medium / Label Large = 14sp; `prose` figcaption = 14px (0.875em) | [androidx `TypeScaleTokens.kt`](https://raw.githubusercontent.com/androidx/androidx/androidx-main/compose/material3/material3/src/commonMain/kotlin/androidx/compose/material3/tokens/TypeScaleTokens.kt); [tailwindcss-typography `styles.js`](https://raw.githubusercontent.com/tailwindlabs/tailwindcss-typography/main/src/styles.js) |
| Tap target (AA floor, WCAG 2.2) | ≥ 24×24 CSS px (or pass the 24px-circle spacing exception) | [WCAG 2.5.8 Target Size (Minimum)](https://www.w3.org/WAI/WCAG22/Understanding/target-size-minimum.html) |
| Tap target (AAA / best practice) | ≥ 44×44 CSS px | [WCAG 2.5.5 Target Size (Enhanced)](https://www.w3.org/WAI/WCAG21/Understanding/target-size.html) |

## Tailwind v4 mapping

| Recommendation | Tailwind v4 utility | Notes |
| --- | --- | --- |
| Body 16px | `text-base` (1rem) | default `prose` size |
| Body 18px | `text-lg` (1.125rem) | equals `prose-lg` |
| Line-height 1.5 | `leading-normal` (1.5) | |
| Line-height ~1.56 | `leading-7` (1.75rem on 18px) | Tailwind's default pairing for `text-lg` |
| Line-height 1.75 | `leading-relaxed` (1.75) | what `prose` (base) sets for 16px body |
| Measure ≤ ~65–70ch | `max-w-prose` (65ch) | the plugin also sets `max-width: 65ch` on `.prose` itself |
| Meta / captions 12px (floor) | `text-xs` | MD3 Body Small / Label Medium equivalent |
| Meta 14px (preferred) | `text-sm` | MD3 Body Medium; `prose` figcaption/code size (0.875em of 16px) |
| Icon button 24px (AA floor) | `size-6` | |
| Icon button 36px | `size-9` | current footer size; passes AA 24px, below AAA 44px |
| Icon button 44px (AAA) | `size-11` | WCAG 2.5.5 / Apple-equivalent comfortable target |

## What `@tailwindcss/typography` actually sets

From [`src/styles.js`](https://raw.githubusercontent.com/tailwindlabs/tailwindcss-typography/main/src/styles.js) (plugin source of truth):

| Property | `prose` (base) | `prose-lg` |
| --- | --- | --- |
| Body font-size | 1rem (16px) | 1.125rem (18px) |
| Body line-height | 1.75 (28/16) | 1.7778 (32/18) |
| `.prose` max-width | 65ch | 65ch (same DEFAULT) |
| `h1` | 2.25em (36px), lh 1.111 (40/36) | 2.6667em (48px), lh 1 (48/48) |
| `h2` | 1.5em (24px), lh 1.333 (32/24) | 1.6667em (30px), lh 1.333 (40/30) |
| `h3` | 1.25em (20px), lh 1.6 (32/20) | 1.3333em (24px), lh 1.5 (36/24) |
| Inline `code` | 0.875em (14px) | 0.8889em (16px) |
| `pre` | 0.875em (14px), lh 1.714 (24/14) | 0.8889em (16px), lh 1.75 (28/16) |
| `figcaption` | 0.875em (14px), lh 1.4286 (20/14) | 0.8889em (16px), lh 1.5 (24/16) |

Note the heading line-heights: the plugin uses ~1.1–1.6 for headings, deliberately tighter than body — consistent with Butterick's point that large sizes need less relative spacing, and with MD3 (Headline Small: 32/24 = 1.33).

## What to change (dark-theme blog, Inter body)

1. **Body size:** 16px is the floor, not the optimum. Butterick's comfort band (15–25px), Apple's 17pt default, and the plugin's own `prose-lg` all point up. **Switch post body to `prose-lg` (18px)** — Inter's tall x-height keeps it readable, and on a dark theme (zinc-950/zinc-300) the extra size counters the perceived "heaviness" of light-on-dark text.
2. **Measure:** the `prose` class self-caps at `65ch`, which already sits inside Baymard's 50–75 optimal and under WCAG's 80-char max. The outer `max-w-2xl` (672px) is not the constraint; **keep `65ch`, or tighten to `max-w-[68ch]` if you want the middle of the 50–75 band at 18px**.
3. **Line-height:** the plugin's 1.75–1.78 body leading satisfies WCAG 1.4.8/1.4.12 (≥1.5) with margin. It is looser than Butterick's 1.2–1.45 optimum, but 1.75 is a deliberate web-friendly choice and harms nothing; keep it.
4. **Secondary text:** `text-xs` (12px) is the evidence floor (MD3 Body Small, HIG ≈11pt). **Raise dates/meta to `text-sm` (14px)** where they carry real information (post dates, card descriptions); reserve `text-xs` for truly tertiary content like the copyright line.
5. **Footer icon buttons:** current `size-9` (36px) passes WCAG 2.2 AA (2.5.8, 24px) but falls short of AAA 2.5.5 (44px). **Bump to `size-11` (44px)** with `size-5` (20px) glyphs — cheap on a sparse footer, meaningful for touch users.
6. **Headings/code:** plugin defaults are already evidence-consistent (tight heading leading, 14–16px code at 1.7+ line-height). No change needed beyond the `prose` → `prose-lg` bump.
