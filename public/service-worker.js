/* global self, caches, fetch */

const VERSION = 'v1';
const STATIC_CACHE = `static-${VERSION}`;
const RUNTIME_CACHE = `runtime-${VERSION}`;

self.addEventListener('install', (event) => {
  self.skipWaiting();
  event.waitUntil(
    caches.open(STATIC_CACHE).then((cache) =>
      cache.addAll([
        '/',
        '/manifest.json',
        '/logo.png'
      ])
    )
  );
});

self.addEventListener('activate', (event) => {
  self.clients.claim();
  if (self.registration.navigationPreload) {
    self.registration.navigationPreload.enable();
  }
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(
        keys
          .filter((key) => ![STATIC_CACHE, RUNTIME_CACHE].includes(key))
          .map((key) => caches.delete(key))
      )
    )
  );
});

// Offline fallback HTML kept inline to avoid extra file
const OFFLINE_HTML = `
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arvaya De Aure • Offline</title>
    <style>
      body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Noto Sans,sans-serif;background:#121212;color:#E0E0E0;margin:0;padding:2rem}
      .card{max-width:640px;margin:5vh auto;background:#1a1a1a;border:1px solid #333;border-radius:16px;padding:2rem;text-align:center}
      .btn{display:inline-block;margin-top:1rem;background:#D4AF37;color:#121212;padding:.6rem 1rem;border-radius:10px;text-decoration:none;font-weight:700}
      p{color:#A0A0A0}
    </style>
  </head>
  <body>
    <div class="card">
      <h1>Anda sedang offline</h1>
      <p>Beberapa fitur tidak tersedia tanpa koneksi internet.</p>
      <a class="btn" href="/">Coba lagi</a>
    </div>
  </body>
</html>`;

// Helper: classify request
const isNavigation = (req) => req.mode === 'navigate';
const isGET = (req) => req.method === 'GET';

// Cache rules
const isImage = (url) => /\.(png|jpg|jpeg|webp|gif|svg)$/.test(url.pathname);
const isFont = (url) => /\.(woff2?|ttf|otf)$/.test(url.pathname);
const isStaticAsset = (url) => /\.(css|js)$/.test(url.pathname);
const isStorageImage = (url) => url.pathname.startsWith('/storage/');

// Do not cache Livewire or mutation endpoints
const isLivewire = (url) => url.pathname.startsWith('/livewire/');

self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);

  if (!isGET(request)) return;
  if (isLivewire(url)) return;

  // Navigation: NetworkFirst with offline fallback
  if (isNavigation(request)) {
    event.respondWith(
      (async () => {
        try {
          const preload = await event.preloadResponse;
          if (preload) return preload;
          const network = await fetch(request);
          const cache = await caches.open(RUNTIME_CACHE);
          cache.put(request, network.clone());
          return network;
        } catch {
          const cached = await caches.match(request);
          if (cached) return cached;
          return new Response(OFFLINE_HTML, {
            headers: { 'Content-Type': 'text/html; charset=utf-8' }
          });
        }
      })()
    );
    return;
  }

  // Fonts & images: CacheFirst
  if (isFont(url) || isImage(url) || isStorageImage(url)) {
    event.respondWith(
      caches.match(request).then((cached) => {
        if (cached) return cached;
        return fetch(request)
          .then((resp) => {
            const copy = resp.clone();
            caches.open(RUNTIME_CACHE).then((cache) => cache.put(request, copy));
            return resp;
          })
          .catch(() => cached || Response.error());
      })
    );
    return;
  }

  // Static CSS/JS: StaleWhileRevalidate
  if (isStaticAsset(url)) {
    event.respondWith(
      caches.match(request).then((cached) => {
        const network = fetch(request).then((resp) => {
          const copy = resp.clone();
          caches.open(RUNTIME_CACHE).then((cache) => cache.put(request, copy));
          return resp;
        });
        return cached ? Promise.race([network, Promise.resolve(cached)]) : network;
      })
    );
    return;
  }
});

