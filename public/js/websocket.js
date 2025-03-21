import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'dev', // change to dev if local or non-https. Else if production make it app
    cluster: 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001, // Change from 6001 to 8081
    wssPort: 6001, // Change from 6001 to 8081
    forceTLS: false,
    encrypted: true,
    enabledTransports: ['ws', 'wss'],
    authEndpoint: 'broadcasting/auth',
});  
