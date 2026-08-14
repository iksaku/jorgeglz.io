# SEO & Social-Sharing Meta Research — jorgeglz.io

Researched against primary sources on 2026-08-14. Every recommendation below cites the documentation that owns it. The goal is a gap-by-gap map from the current `src/components/Seo.astro` to what the standards/consumers actually support, so a human can turn it into an implementation plan.

## Current state (grounding)

`src/components/Seo.astro` emits, in order:

| Emitted today | Attribute used | Correct attribute |
| --- | --- | --- |
| `<title>{title} \| JorgeGlz</title>` | — | — |
| `og:title`, `og:description`, `og:type`, `og:url`, `og:image`, `og:image:width`, `og:image:height` | `name=` | **`property=`** |
| `og:author`, `og:published_time`, `og:modified_time` (article only) | `name=` | `article:author`, `article:published_time`, `article:modified_time` |
| `<meta name="description">` | `name=` | correct |
| `twitter:site`, `twitter:creator`, `twitter:card` | `name=` | correct |

Absent entirely: `<link rel="canonical">`, robots meta, `og:site_name`, `og:locale`, `og:image:alt`, `twitter:title`/`twitter:description`/`twitter:image`/`twitter:image:alt`, JSON-LD structured data, favicon, sitemap, RSS, `theme-color`.

---

## 1. Corrections needed in the current component (verified)

### (a) Open Graph uses `property=`, not `name=` — CONFIRMED

The Open Graph protocol is RDFa-based and its metadata is emitted with the `property` attribute. The spec's canonical example is `<meta property="og:title" content="The Rock" />` (<https://ogp.me/#metadata>). Twitter's own "Cards and Open Graph" section states it explicitly:

> "Open Graph protocol also specifies the use of `property` and `content` attributes for markup (`<meta property="og:image" content="http://example.com/ogp.jpg"/>`) while Twitter cards use `name` and `content`."

Source: <https://developer.twitter.com/en/docs/twitter-for-websites/cards/guides/getting-started> (currently redirected off developer.twitter.com; archived at <https://web.archive.org/web/20231229091637/https://developer.twitter.com/en/docs/twitter-for-websites/cards/guides/getting-started>).

**Correction:** all `og:*` tags in `Seo.astro` must switch from `name=` to `property=`.

### (b) Article dates/authors use the `article:` prefix, not `og:` — CONFIRMED

`og:published_time`, `og:modified_time`, and `og:author` do not exist in the Open Graph protocol. The `article` object type (namespace `https://ogp.me/ns/article#`) defines:

- `article:published_time` — "When the article was first published."
- `article:modified_time` — "When the article was last changed."
- `article:author` — "Writers of the article."

Source: <https://ogp.me/#type_article>.

**Correction:** `og:published_time` → `article:published_time`, `og:modified_time` → `article:modified_time`, `og:author` → `article:author` (all with `property=`).

### (c) `twitter:title`/`twitter:description`/`twitter:image` are separate tags — CONFIRMED, with a fallback nuance

They are distinct tags with their own constraints, listed in the Cards Markup Tag Reference:

- `twitter:title` — "Title of content (max 70 characters)".
- `twitter:description` — "Description of content (maximum 200 characters)".
- `twitter:image` — "URL of image to use in the card. Images must be less than 5MB in size. JPG, PNG, WEBP and GIF formats are supported… SVG is not supported."
- `twitter:image:alt` — "A text description of the image… Maximum 420 characters."

Source: <https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/markup> (archived at <https://web.archive.org/web/20231229075931/https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/markup>).

The nuance: Twitter falls back to the equivalent Open Graph property when the `twitter:` tag is absent — `twitter:title`→`og:title`, `twitter:description`→`og:description`, `twitter:image`→`og:image`, `twitter:image:alt`→`og:image:alt` (same markup-reference table), and even `twitter:card`→`og:type` for a summary card. So the `twitter:*` values are optional *only because* the corrected `og:*` tags can serve as the fallback. Including them is recommended when the Twitter-specific limits (70/200/420 chars) differ from what you want for OG, but they are not strictly required once `og:*` is correct.

### (d) Documented/recommended optional tags — verification

| Tag | Documented? | Source |
| --- | --- | --- |
| `og:image:alt` | Yes — structured property of `og:image`: "A description of what is in the image (not a caption). If the page specifies an og:image it should specify `og:image:alt`." | <https://ogp.me/#structured> |
| `og:locale` | Yes — optional metadata, "Of the format `language_TERRITORY`. Default is `en_US`." | <https://ogp.me/#optional> |
| `og:site_name` | Yes — optional metadata: "If your object is part of a larger web site, the name which should be displayed for the overall site." | <https://ogp.me/#optional> |
| `twitter:image:alt` | Yes — markup reference + card specs, "Maximum 420 characters", falls back to `og:image:alt`. | <https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/markup> (archived) |
| `theme-color` | Yes — standardized in the HTML Living Standard: "defining a suggested color that user agents should use to customize the display of the page or of the surrounding user interface" (valid CSS `<color>`). | <https://html.spec.whatwg.org/multipage/semantics.html#meta-theme-color> |

All five are legitimately documented; none is folklore.

---

## 2. Gap-by-gap report

### A. Google / SEO (title, description, robots, canonical)

| Gap | Exact syntax | Purpose | Recommended value/derivation | Source |
| --- | --- | --- | --- | --- |
| `<title>` | `<title>…</title>` | Title link in search results. Google's first best practice: "Make sure **every page on your site has a title specified in the `<title>` element**." | Already correct (`tabTitle()`). Keep; it is the strongest title-link signal. | <https://developers.google.com/search/docs/appearance/title-link#page-titles> |
| `<meta name="description">` | `<meta name="description" content="…">` | "Use this tag to provide a short description of the page… used in the snippet shown in search results." | Already present; keep unique per page ("Identical or similar descriptions on every page… aren't helpful"). | <https://developers.google.com/search/docs/crawling-indexing/special-tags> ; <https://developers.google.com/search/docs/appearance/snippet#meta-descriptions> |
| `meta name="robots"` | `<meta name="robots" content="index, follow">` | "These meta tags control the behavior of search engine crawling and indexing." | **Optional** — the default is already `index, follow` ("The default values are `index, follow` and don't need to be specified"). Only emit `noindex`/`nofollow` etc. when you want to *restrict* (e.g. `noindex` on draft posts). | <https://developers.google.com/search/docs/crawling-indexing/special-tags> ; <https://developers.google.com/search/docs/crawling-indexing/robots-meta-tag#using-the-robots-meta-tag> |
| `<link rel="canonical">` | `<link rel="canonical" href="https://…">` | "A `rel="canonical"` link element… is used in the `head` section of HTML to indicate that another page is representative of the content on the page." Google: "Do include a `rel="canonical"` link on the canonical page itself (also known as a self-referential canonical)." | Emit a **self-referential** canonical on every page: `Astro.url` (absolute because `site` is configured). Use **absolute paths** ("Use absolute paths rather than relative paths"). | <https://developers.google.com/search/docs/crawling-indexing/consolidate-duplicate-urls#rel-canonical-link-method> ; <https://developers.google.com/search/docs/crawling-indexing/canonicalization> |
| `meta name="keywords"` | — | **Do NOT add.** "The meta-keyword tag is not used by Google Search, and it has no effect on indexing and ranking at all." | N/A (not present today; keep absent). | <https://developers.google.com/search/docs/crawling-indexing/special-tags#unsupported-tags-and-attributes> |

Note: `og:title` is also a source Google uses when generating title links ("Content in `og:title` `meta` tags"), so fixing `property=` matters for search too. Source: <https://developers.google.com/search/docs/appearance/title-link#how-title-links-in-google-search-are-created>.

### B. Open Graph (all `property=`, base spec <https://ogp.me/>)

The four **required** properties per page are `og:title`, `og:type`, `og:image`, `og:url` (<https://ogp.me/#metadata>). The rest are optional-but-recommended.

| Gap | Exact syntax | Purpose | Recommended value/derivation | Source |
| --- | --- | --- | --- | --- |
| `og:title` | `<meta property="og:title" content="…">` | "The title of your object as it should appear within the graph." (required) | `title` (raw). Fix `name=`→`property=`. | <https://ogp.me/#metadata> |
| `og:type` | `<meta property="og:type" content="…">` | Object type (required). | `article` when `article` prop present, else `website`. Already correct except attribute. | <https://ogp.me/#metadata> ; <https://ogp.me/#types> |
| `og:image` | `<meta property="og:image" content="…">` | "An image URL which should represent your object within the graph." (required) | Keep `new URL(image.src, Astro.url)`. Fix attribute. | <https://ogp.me/#metadata> |
| `og:url` | `<meta property="og:url" content="…">` | "The canonical URL of your object that will be used as its permanent ID in the graph." (required) | `Astro.url` (matches the canonical link). Fix attribute. | <https://ogp.me/#metadata> |
| `og:description` | `<meta property="og:description" content="…">` | "A one to two sentence description of your object." | `description`. Fix attribute. | <https://ogp.me/#optional> |
| `og:site_name` | `<meta property="og:site_name" content="…">` | "The name which should be displayed for the overall site." | Constant `"JorgeGlz"`. **Missing today.** | <https://ogp.me/#optional> |
| `og:locale` | `<meta property="og:locale" content="en_US">` | "The locale these tags are marked up in. Of the format `language_TERRITORY`. Default is `en_US`." | `en_US` (site content is English) — or omit and accept the default. **Missing today.** | <https://ogp.me/#optional> |
| `og:image:width` / `og:image:height` | `<meta property="og:image:width" content="…">` | Structured properties: "The number of pixels wide/high." | Keep; fix attribute. | <https://ogp.me/#structured> |
| `og:image:alt` | `<meta property="og:image:alt" content="…">` | "A description of what is in the image (not a caption)." — "If the page specifies an og:image it should specify `og:image:alt`." | `<post title> header image` (or a real alt). **Missing today.** | <https://ogp.me/#structured> |
| `article:published_time` | `<meta property="article:published_time" content="…">` | "When the article was first published." | `article.published_time.toISO()`. **Currently emitted as the non-existent `og:published_time`.** | <https://ogp.me/#type_article> |
| `article:modified_time` | `<meta property="article:modified_time" content="…">` | "When the article was last changed." | `article.modified_time.toISO()`. **Currently emitted as `og:modified_time`.** | <https://ogp.me/#type_article> |
| `article:author` | `<meta property="article:author" content="…">` | "Writers of the article." | Constant profile (e.g. an author URL/name). **Currently emitted as `og:author`.** | <https://ogp.me/#type_article> |

Quality note (not a bug): OG/Twitter both advise against a generic avatar/logo as the sharing image — "You should not use a generic image such as your website logo, author photo, or other image that spans multiple pages" (Twitter, <https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/summary>, archived). The current `Avatar` fallback for pages without a post image is therefore a weak default; consider a dedicated site OG image instead.

### C. Twitter Cards (all `name=`, fallback to `property=` og: tags)

Spec: <https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/markup> (redirected off developer.twitter.com as of 2026-08; archived at <https://web.archive.org/web/20231229075931/https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/markup>). Twitter tags use `name=` ("Twitter cards use `name` and `content`").

| Gap | Exact syntax | Purpose / limits | Recommended value/derivation | Source |
| --- | --- | --- | --- | --- |
| `twitter:card` | `<meta name="twitter:card" content="…">` | Card type; one of `summary`, `summary_large_image`, `app`, `player`. "Only one card type per-page is supported." | Already present (`summary_large_image` for posts with an image, `summary` otherwise). | <https://developer.twitter.com/en/docs/twitter-for-websites/cards/guides/getting-started> (archived) |
| `twitter:site` | `<meta name="twitter:site" content="@iksaku2">` | "The Twitter @username the card should be attributed to." | Already present. | markup reference (archived) |
| `twitter:creator` | `<meta name="twitter:creator" content="@iksaku2">` | "@username of content creator." | Already present. | markup reference (archived) |
| `twitter:title` | `<meta name="twitter:title" content="…">` | "Title of content (max 70 characters)." | `title`. Falls back to `og:title`; include for length control. **Missing today.** | markup reference (archived) |
| `twitter:description` | `<meta name="twitter:description" content="…">` | "Description of content (maximum 200 characters)." | `description`. Falls back to `og:description`. **Missing today.** | markup reference (archived) |
| `twitter:image` | `<meta name="twitter:image" content="…">` | "URL of image to use in the card." <5MB; JPG/PNG/WEBP/GIF; SVG unsupported. | `new URL(image.src, Astro.url)`. Falls back to `og:image`. **Missing today.** | markup reference (archived) |
| `twitter:image:alt` | `<meta name="twitter:image:alt" content="…">` | Alt text, max 420 chars. | Same as `og:image:alt`. Falls back to `og:image:alt`. **Missing today.** | markup reference (archived) |

Card image dimension requirements (choose by card type):

- `summary` — "Images for this Card support an aspect ratio of 1:1 with minimum dimensions of 144x144 or maximum of 4096x4096 pixels… The image will be cropped to a square on all platforms."
- `summary_large_image` — "Images for this Card support an aspect ratio of 2:1 with minimum dimensions of 300x157 or maximum of 4096x4096 pixels."

Sources: <https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/summary> and <https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/summary-card-with-large-image> (both archived on web.archive.org, 2023-12 snapshots).

### D. JSON-LD structured data

Google's Article documentation (<https://developers.google.com/search/docs/appearance/structured-data/article>) accepts `Article`, `NewsArticle`, and `BlogPosting` based on schema.org, with **no required properties** — "There are no required properties; instead, add the properties that apply to your content." Recommended properties: `author`, `author.name`, `author.url`, `dateModified`, `datePublished`, `headline`, `image`.

| Gap | Type | Purpose | Recommended derivation | Source |
| --- | --- | --- | --- | --- |
| Blog post JSON-LD | `BlogPosting` | "Adding `Article` structured data… can help Google understand more about the web page and show better title text, images, and date information." | On `/blog/<slug>` emit `@type: BlogPosting` with `headline` (title), `description`, `image` (absolute URL), `datePublished`, `dateModified` (ISO 8601 **with timezone**), `author: [{ "@type":"Person","name":"Jorge González","url":"https://jorgeglz.io/about" }]`, `mainEntityOfPage`. | <https://developers.google.com/search/docs/appearance/structured-data/article> ; type hierarchy `Thing > CreativeWork > Article > SocialMediaPosting > BlogPosting` at <https://schema.org/BlogPosting> |
| Site JSON-LD | `WebSite` | Site name in search results: "To indicate your site name preference, add `WebSite` structured data to your home page." Required: `name` + `url`; recommended `alternateName`. | On the home page only, emit `@type: WebSite`, `name: "JorgeGlz"`, `url: "https://jorgeglz.io/"`. Note the home page here is `/` (redirects to `/blog`), so put it on `/`. | <https://developers.google.com/search/docs/appearance/site-names#website> ; <https://schema.org/WebSite> |
| Author entity | `Person` | Used as the `author` value of `BlogPosting`; Google recommends `@type` + `url`/`sameAs` ("strongly recommend using the `type` and `url` (or `sameAs`) properties"). | `{"@type":"Person","name":"Jorge González","url":"https://jorgeglz.io/about","sameAs":["https://twitter.com/iksaku2","https://github.com/iksaku","https://www.linkedin.com/in/jorge-glz"]}`. | <https://developers.google.com/search/docs/appearance/structured-data/article#author-bp> ; <https://schema.org/Person> |

Minimal `BlogPosting` JSON-LD (illustrative; derive fields from the existing props):

```html
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "{title}",
  "description": "{description}",
  "image": "{absolute image URL}",
  "datePublished": "{article.published_time.toISO()}",
  "dateModified": "{article.modified_time.toISO()}",
  "author": [{ "@type": "Person", "name": "Jorge González", "url": "https://jorgeglz.io/about" }],
  "mainEntityOfPage": { "@type": "WebPage", "@id": "{Astro.url}" }
}
</script>
```

Google's date guidance: "The date and time… in ISO 8601 format. We recommend that you provide timezone information" (`datePublished`/`dateModified`). Source: <https://developers.google.com/search/docs/appearance/structured-data/article#structured-data-type-definitions>. The site's `toISO()` already returns UTC (`Z`) with a timezone marker.

### E. Other head elements

| Element | Exact syntax | Purpose | Recommended | Source |
| --- | --- | --- | --- | --- |
| Canonical link | `<link rel="canonical" href="…">` | Deduplication; strong canonicalization signal. | Self-referential on every page; absolute URL. | <https://developers.google.com/search/docs/crawling-indexing/consolidate-duplicate-urls#rel-canonical-link-method> |
| Robots | `<meta name="robots" content="…">` | Per-page indexing control. | Omit (defaults apply), or `noindex` for drafts. | <https://developers.google.com/search/docs/crawling-indexing/robots-meta-tag> |
| Favicon | `<link rel="icon" href="…">` | Browser tab/bookmark icon. Not a Google ranking signal. | Add a standard `rel="icon"` (and optionally `rel="apple-touch-icon"`). Standard HTML link type. | WHATWG HTML link type `icon` (<https://html.spec.whatwg.org/multipage/links.html#rel-icon>) |
| `theme-color` | `<meta name="theme-color" content="#…">` | "A suggested color that user agents should use to customize the display of the page." Valid CSS `<color>`; `media` attr can vary by color scheme. | Optional; e.g. the site's zinc-950 background (`#18181b`). | <https://html.spec.whatwg.org/multipage/semantics.html#meta-theme-color> |
| Sitemap | `/sitemap.xml` (or `sitemap-index.xml`) | "All pages listed in a sitemap are suggested as canonicals" (weak signal). | Generate an XML sitemap and submit it in Search Console. | <https://developers.google.com/search/docs/crawling-indexing/consolidate-duplicate-urls#use-a-sitemap> ; build guidance <https://developers.google.com/search/docs/crawling-indexing/sitemaps/build-sitemap> |
| RSS/Atom feed | `<link rel="alternate" type="application/rss+xml" …>` | Syndication/feed readers. **Not** a Google search feature/requirement. | Optional; no SEO benefit, purely a reader convenience. | No Google doc owns this — folklore if claimed as an SEO signal. |

---

## 3. Folklore vs. documented (flagged)

- **`meta name="keywords"`** — folklore for SEO; explicitly ignored by Google ("has no effect on indexing and ranking at all"). <https://developers.google.com/search/docs/crawling-indexing/special-tags#unsupported-tags-and-attributes>
- **`rel="next"`/`rel="prev"`** — folklore; "Google no longer uses these HTML `<link>` tags." <https://developers.google.com/search/docs/crawling-indexing/special-tags#unsupported-tags-and-attributes>
- **`og:published_time` / `og:modified_time` / `og:author`** — not part of any spec; the real names are `article:published_time` / `article:modified_time` / `article:author`. <https://ogp.me/#type_article>
- **`lang` attribute for SEO** — Google "detects the language of a page based on the textual content… It doesn't rely on code annotations such as the `lang`." (Still keep `<html lang="en">` for accessibility/screen readers — it's correct HTML, just not an SEO signal.) <https://developers.google.com/search/docs/crawling-indexing/special-tags#unsupported-tags-and-attributes>
- **RSS/sitemap as "required SEO"** — a sitemap is a weak, optional canonicalization aid; RSS has no Google Search role. Neither is required.

---

## 4. Suggested implementation priority

1. **Bug fixes (cheap, high value):** switch all `og:*` tags to `property=`; rename `og:published_time`/`og:modified_time`/`og:author` → `article:published_time`/`article:modified_time`/`article:author`.
2. **Add missing OG/Twitter fields:** `og:site_name`, `og:locale`, `og:image:alt`, and the four `twitter:*` content tags (title/description/image/image:alt) using `name=`.
3. **Add `<link rel="canonical">`** (self-referential, absolute) on every page.
4. **Add `BlogPosting` JSON-LD** on post pages and **`WebSite` JSON-LD** on the home page.
5. **Site-level:** `theme-color`, favicon, XML sitemap; optional RSS; `noindex` on draft posts if you want them hidden from search.
