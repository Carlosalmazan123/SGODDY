self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open("app-cache").then((cache) => {
      return cache.addAll([
        "/",
        "/offline.html"
      ]);
    })
  );
});

self.addEventListener("fetch", event => {
    event.respondWith(
        fetch(event.request)
            .then(response => {
                return response;
            })
            .catch(() => caches.match(event.request).then(r => r || caches.match('offline.html')))
    );
});
