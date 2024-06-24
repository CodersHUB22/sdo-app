const cacheName = 'sdoocpanel';
const filesToCache = [
  '/',
  '/login.php',
  '/index.php',
  '/manifest.json',
  '/img/logo.png',
];

self.addEventListener('install', (e) => {
  e.waitUntil(
    caches.open(cacheName).then((cache) => {
      return cache.addAll(filesToCache);
    })
  );
});

self.addEventListener('fetch', (event) => {
  event.respondWith(
    (async function () {
      const response = await caches.match(event.request);
      if (response) {
        return response;
      }

      const url = new URL(event.request.url);
      if (url.pathname === '/') {
        return Response.redirect('/index.php', 302);
      } else if (url.pathname === '/index.php' && !url.searchParams.has('fromWeb')) {
        return Response.redirect('/login.php', 302);
      }

      return fetch(event.request);
    })()
  );
});