window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
console.log("Echo: " )
import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'app-key',
    encrypted: true,
    wsHost: '127.0.0.1',
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    // cluster: 'mt1',
});

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'app-key'
// });
