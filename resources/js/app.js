import './bootstrap';
import Echo from "laravel-echo";
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Pusher = require("pusher-js");

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});


// const files = require.context('../myFolder', true, /(Module|Utils)\.js$/)
