# Cloudflare Pages — Node.js support and pinning

Resolution of issue #43 (wayfinder map #42, Astro 4 → 7 upgrade). All facts from first-party Cloudflare sources, verified 2026-08-06.

## Facts

### Default Node.js version on Pages builds
- Current build image (v3, default for new projects since May 2025) ships **Node.js 22.16.0** by default.
  Source: https://developers.cloudflare.com/pages/configuration/build-image/ ("Supported languages and tools" table, v3 build system)
- The older v2 build system defaults to Node.js **18.17.1** (now EOL); v1 defaults to 12.18.0.
  Source: https://developers.cloudflare.com/pages/configuration/build-image/
- v1 projects auto-migrate to v3 on 2026-09-15; v2 projects on 2027-02-23. v3 gets rolling updates (minor updates without notice; major LTS bumps with 3 months' notice) — so unpinned builds can drift.
  Source: https://developers.cloudflare.com/pages/configuration/build-image/ ("Build Image Policy")

### Supported Node range and how to pin
- **Any version** of Node.js is supported (including versions newer than the default). "Any version" explicitly includes newer-than-default releases.
  Source: https://developers.cloudflare.com/pages/configuration/build-image/
- Pin via either:
  - `NODE_VERSION` environment variable (Pages project **Settings → Environment variables**, or via Wrangler), or
  - a `.nvmrc` or `.node-version` file in the project root containing the version number.
  Source: https://developers.cloudflare.com/pages/configuration/build-image/ ("Override default versions")
- Cloudflare itself strongly recommends pinning a modern Node version for consistent, secure builds (v2 default was frozen at Node 18).
  Source: https://developers.cloudflare.com/pages/platform/changelog/ (2025-04-18 entry)

### v3 build-image limitations relevant to pinning
- Node.js version **codenames are not supported** (e.g. `lts/*`, `hydrogen`) — pin an exact version number.
- Node/package-manager detection from `package.json` → `"engines"` is **not supported**; pnpm version is not detected from `pnpm-lock.yaml`.
  Source: https://developers.cloudflare.com/pages/configuration/build-image/ ("v3 build system → Limitations")

### pnpm availability/version on the build image
- pnpm is preinstalled on the v3 build image at **10.11.1** by default; **any version** is supported and can be pinned via the `PNPM_VERSION` environment variable.
  Source: https://developers.cloudflare.com/pages/configuration/build-image/ ("Tools" table, v3 build system)

### Verdict for astro ≥ 6 (requires Node ≥ 22.12.0, pnpm ≥ 7.1.0)
- **Nothing in the deploy path blocks astro ≥ 6.**
- The v3 default Node 22.16.0 already satisfies ≥ 22.12.0; default pnpm 10.11.1 satisfies ≥ 7.1.0.
- If the project is still on the v2 build image (default Node 18.17.1), the build would fail without action — pin `NODE_VERSION` (e.g. `22.16.0` or newer exact version) via env var or `.nvmrc`/`.node-version`, and confirm the project uses the v3 build system.
- Recommended: commit an exact-version `.nvmrc`/`.node-version` (not a codename) so builds are immune to the v3 rolling-update policy.

## Sources
- Build image (languages, tools, defaults, overrides, v3 limitations, image policy): https://developers.cloudflare.com/pages/configuration/build-image/
- Build configuration (env vars, framework presets incl. Astro `npm run build` → `dist`): https://developers.cloudflare.com/pages/configuration/build-configuration/
- Pages changelog (pinning recommendation, 2025-04-18): https://developers.cloudflare.com/pages/platform/changelog/
- Changelog: Pages build image v3 / Node 22 default (2025-05-30): https://developers.cloudflare.com/changelog/post/2025-05-30-pages-build-image-v3/
