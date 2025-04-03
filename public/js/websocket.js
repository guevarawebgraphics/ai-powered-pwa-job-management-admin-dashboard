// import Echo from 'laravel-echo';
// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'dev', // change to dev if local or non-https. Else if production make it app
//     cluster: 'mt1',
//     wsHost: window.location.hostname,
//     wsPort: 6001, // Change from 6001 to 8081
//     wssPort: 6001, // Change from 6001 to 8081
//     forceTLS: false,
//     encrypted: true,
//     enabledTransports: ['ws', 'wss'],
//     authEndpoint: 'broadcasting/auth',
// });



// resources/js/firebase.js
import firebase from "firebase/compat/app";
import "firebase/compat/messaging";

const firebaseConfig = {
  apiKey: "AIzaSyAQ-DqNt7F9f5kPX-Txj3Sb4mqm__OYtTE",
  authDomain: "appliance-repair-american.firebaseapp.com",
  projectId: "appliance-repair-american",
  storageBucket: "appliance-repair-american.firebasestorage.app",
  messagingSenderId: "294328886559",
  appId: "1:294328886559:web:cb2273554de57d21b33c2a",
  measurementId: "G-SQJZVSFM2L"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

export { messaging };
