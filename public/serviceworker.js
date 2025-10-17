// Nombre del caché (cambia la versión si haces grandes modificaciones)
const CACHE_NAME = "pwa-cache-v1";

// Archivos mínimos necesarios para el modo offline
const OFFLINE_URL = "/offline";
const FILES_TO_CACHE = [
    OFFLINE_URL,
    "/images/icons/icon-72x72.png",
    "/images/icons/icon-96x96.png",
    "/images/icons/icon-128x128.png",
    "/images/icons/icon-144x144.png",
    "/images/icons/icon-152x152.png",
    "/images/icons/icon-192x192.png",
    "/images/icons/icon-384x384.png",
    "/images/icons/icon-512x512.png",
];

// Instalar Service Worker → cachea solo lo esencial
self.addEventListener("install", event => {
    self.skipWaiting();
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => cache.addAll(FILES_TO_CACHE))
    );
});

// Activar → elimina versiones viejas del caché
self.addEventListener("activate", event => {
    event.waitUntil(
        caches.keys().then(keys => 
            Promise.all(keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k)))
        )
    );
    self.clients.claim();
});

// Estrategia: NETWORK FIRST → usa caché solo si no hay red
self.addEventListener("fetch", event => {
    // Solo manejar solicitudes GET
    if (event.request.method !== "GET") return;

    const url = new URL(event.request.url);

    // ❌ EXCLUSIONES:
    // No cachear nada que empiece con /admin o /api
    if (
        url.pathname.startsWith("/admin") ||
        url.pathname.startsWith("/api")
    ) {
        return; // Deja que Laravel maneje normalmente esas rutas
    }

    // Intentar obtener del servidor primero
    event.respondWith(
        fetch(event.request)
            .then(response => {
                // Guardar archivos estáticos en caché (no rutas dinámicas)
                if (
                    response &&
                    response.status === 200 &&
                    (url.pathname.includes("/css/") ||
                     url.pathname.includes("/js/") ||
                     url.pathname.includes("/images/"))
                ) {
                    const cloned = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(event.request, cloned));
                }
                return response;
            })
            .catch(() => {
                // Si no hay conexión, usar caché o mostrar página offline
                return caches.match(event.request).then(cached => {
                    return cached || caches.match(OFFLINE_URL);
                });
            })
    );
});
