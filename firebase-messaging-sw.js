// public/firebase-messaging-sw.js

importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js');

firebase.initializeApp({
  apiKey: "AIzaSyAQ-DqNt7F9f5kPX-Txj3Sb4mqm__OYtTE",
  authDomain: "appliance-repair-american.firebaseapp.com",
  projectId: "appliance-repair-american",
  storageBucket: "appliance-repair-american.firebasestorage.app",
  messagingSenderId: "294328886559",
  appId: "1:294328886559:web:cb2273554de57d21b33c2a",
  measurementId: "G-SQJZVSFM2L"
});

const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  const notificationTitle = payload.notification.title || 'Notification Title';
  const notificationOptions = {
    body: payload.notification.body || 'Notification Body',
    icon: '/firebase-logo.png' // Update with your icon path if needed
  };
  return self.registration.showNotification(notificationTitle, notificationOptions);
});



if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('/firebase-messaging-sw.js')
    .then(registration => {
      console.log('Service Worker registered:', registration);
      // You can now pass this registration to getToken if needed:
      getToken(messaging, {
        vapidKey: 'BLkq7l4l-zOfRzHLgorPBX_L7N-mX5bPK8HzH2kohqTGfZpbSonTqWWxV6RZ4IRMCGnaEOnnWsyUoMlsTwFUguI',
        serviceWorkerRegistration: registration
      })
      .then((currentToken) => {
        if (currentToken) {
          console.log('FCM token:', currentToken);
          // Send this token to your Laravel back end...
        } else {
          console.log('No registration token available. Request permission to generate one.');
        }
      })
      .catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
      });
    })
    .catch(err => {
      console.error('Service Worker registration failed:', err);
    });
}
