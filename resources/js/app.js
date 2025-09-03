import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
import Echo from "laravel-echo";
window.Pusher = require("pusher-js");

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});

// registrar el service worker
if ("serviceWorker" in navigator) {
    navigator.serviceWorker.register('/sw.js').then(async (reg) => {
        let subscription = await reg.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: "VAPID_PUBLIC_KEY"
        });

        // Enviar la suscripción al backend
        await fetch("/push-subscribe", {
            method: "POST",
            headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify(subscription)
        });
    });
}

// const files = require.context('../myFolder', true, /(Module|Utils)\.js$/)
