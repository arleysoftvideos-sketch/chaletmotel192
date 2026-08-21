const CACHE_NAME = 'liquorguard-cache-v5';
const ASSETS_TO_CACHE = [
  'css/style.css',
  'js/face-api.min.js',
  'models/tiny_face_detector_model-weights_manifest.json',
  'models/tiny_face_detector_model-shard1',
  'models/age_gender_model-weights_manifest.json',
  'models/age_gender_model-shard1',
  'models/face_landmark_68_tiny_model-weights_manifest.json',
  'models/face_landmark_68_tiny_model-shard1',
  'models/face_expression_model-weights_manifest.json',
  'models/face_expression_model-shard1'
];

self.addEventListener('install', (event) => {
  self.skipWaiting();
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(ASSETS_TO_CACHE).catch(err => {
        console.warn('Some assets could not be cached immediately:', err);
      });
    })
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(
        keys.map((key) => {
          if (key !== CACHE_NAME) {
            console.log('Clearing old cache:', key);
            return caches.delete(key);
          }
        })
      );
    }).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (event) => {
  // Only cache-first for models and vendor libs to save bandwidth, NOT app.js
  if (event.request.url.includes('/models/') || event.request.url.includes('face-api.min.js')) {
    event.respondWith(
      caches.match(event.request).then((cachedResponse) => {
        if (cachedResponse) {
          return cachedResponse;
        }
        return fetch(event.request).then((networkResponse) => {
          if (networkResponse && networkResponse.status === 200) {
            const responseClone = networkResponse.clone();
            caches.open(CACHE_NAME).then((cache) => {
              cache.put(event.request, responseClone);
            });
          }
          return networkResponse;
        });
      })
    );
  }
});

