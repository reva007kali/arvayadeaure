## Goals
- Make the app installable on desktop and mobile browsers (Chrome, Edge, Safari*).
- Provide robust offline support, reliable caching, and an install prompt UX.
- Respect Livewire’s POST endpoints and avoid caching dynamic mutations.

## Architecture Overview
- **Manifest**: `public/manifest.json` with name, icons, `display: 'standalone'`, `start_url: '/'`, shortcuts.
- **Service Worker**: `public/service-worker.js` using Workbox (via CDN) for precache + runtime caching.
- **Registration**: Add SW + manifest tags into base layouts already referencing `@vite`.
- **Install UX**: Capture `beforeinstallprompt` to show a custom “Install app” button/banner.
- **Offline Fallback**: Serve a lightweight offline HTML (or inline template) for navigations when network is down.
- **Push & BG Sync (optional)**: Stage hooks for Web Push and Background Sync for future iterations.

## Files To Add
1. `public/manifest.json`
2. `public/service-worker.js`
3. Icon set under `public/icons/` (192, 512, maskable variants)
4. Optional: `resources/views/pwa/offline.blade.php` for a friendly offline page

## Manifest Content
- `name`: "Arvaya Deaure"
- `short_name`: "Arvaya"
- `start_url`: "/?source=pwa"
- `display`: "standalone"
- `theme_color`: match `#121212` / brand color
- `background_color`: match `#121212`
- `icons`: 192, 512, maskable
- `shortcuts`: Dashboard, Invitations, Messages (routes you specify)

## Service Worker Strategy
- **Precaching**: Vite build assets (`/build/*`), core pages (`/`, dashboard shell).
- **Runtime caching**:
  - `CacheFirst`: fonts (`*.woff2`), static images (`/storage/*`, `/images/*`), theme thumbnails.
  - `StaleWhileRevalidate`: CSS/JS from Vite and CDN (Google Fonts, FontAwesome).
  - `NetworkFirst`: HTML navigations (`navigation` requests) for freshness with offline fallback.
- **Livewire Safety**: Exclude `POST` and `fetch` to `/livewire/*` from caching; bypass mutation requests.
- **Lifecycle**: `skipWaiting()` and `clientsClaim()` to update quickly; add `navigationPreload`.

## Registration & Head Tags
- In `components/layouts/app.blade.php`, `guest.blade.php`, and `public.blade.php`:
  - Link manifest: `<link rel="manifest" href="/manifest.json">`
  - Add theme color meta: `<meta name="theme-color" content="#121212">`
  - Register SW: `navigator.serviceWorker.register('/service-worker.js')` on load if supported.
  - Fix any mis-typed registration calls (use `register`, not `login`).

## Install Prompt UX
- In a small JS module (in `resources/js/app.js` or a new `pwa.js` imported by Vite):
  - Listen for `beforeinstallprompt` and store the event.
  - Display an install banner/button in the UI when criteria are met.
  - On click, call `prompt()` and handle `userChoice`.
- Add a fallback helper for iOS (no prompt), with guidance to "Add to Home Screen".

## iOS & Safari Considerations
- Add Apple-specific meta tags in `<head>`:
  - `apple-mobile-web-app-capable=yes`, `apple-mobile-web-app-status-bar-style=black-translucent`
  - `apple-touch-icon` references to our 180x180 icon
- Provide inline tooltip/banner explaining A2HS steps on iOS Safari.

## Security & Correctness
- HTTPS required for SW in production.
- Don’t cache authenticated HTML responses containing sensitive data beyond session scope; rely on NetworkFirst for pages.
- Never cache `POST` or mutation endpoints (`/livewire/update`, `POST /messages`, etc.).

## Rollout & Validation
- Add Lighthouse PWA audit and fix any manifest/SW warnings.
- Manual tests:
  - Install prompt on Chrome desktop/mobile.
  - Offline navigation to cached routes; show friendly offline page.
  - Asset caching behavior for images and fonts.
  - SW update flow (skipWaiting + clientsClaim).

## Step-by-Step Implementation
1. Create `public/manifest.json` with icons and shortcuts.
2. Add icons to `public/icons/` (generate from existing brand assets).
3. Create `public/service-worker.js` with Workbox and caching strategies; exclude Livewire POST.
4. Update base layouts: link manifest, add theme-color, register SW.
5. Add install prompt logic in `resources/js/app.js` (or `pwa.js` via Vite) and minimal UI hook.
6. Add optional offline blade and route; include in SW as navigation fallback.
7. Validate via Lighthouse and manual installs. Iterate on cache scopes.

## Notes Specific to This Repo
- The app already uses Vite per blades and config. We will precache `@vite` build assets and respect dynamic Livewire routes.
- Existing layouts reference `/manifest.json` and `/service-worker.js`; we will provide these files and correct any registration typos.

Please confirm, and I’ll implement the manifest, service worker, registration, icons, install UX, and offline fallback in one pass, then run PWA audits and verification.