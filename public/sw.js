const CACHE_NAME = 'naseja-v4';

const BASE_PATH = '/laravel/naseja/core/public';

const APP_SHELL = [
    `${BASE_PATH}/`,
    `${BASE_PATH}/manifest.json`,
    `${BASE_PATH}/images/naseja-logo.png`
];

/*
|--------------------------------------------------------------------------
| Dynamic/auth pages
|--------------------------------------------------------------------------
| These pages must always come from the server so registration/login changes
| appear immediately and never require F5.
*/
const NETWORK_ONLY_PATHS = [
    `${BASE_PATH}/start-register`,
    `${BASE_PATH}/register`,
    `${BASE_PATH}/login`,
    `${BASE_PATH}/admin/login`
];

function isNetworkOnlyUrl(url) {
    return NETWORK_ONLY_PATHS.some(path => {
        return url.pathname === path || url.pathname.startsWith(path + '/');
    });
}

/*
|--------------------------------------------------------------------------
| INSTALL
|--------------------------------------------------------------------------
*/
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(APP_SHELL))
            .then(() => self.skipWaiting())
    );
});

/*
|--------------------------------------------------------------------------
| ACTIVATE
|--------------------------------------------------------------------------
| Deletes old naseja-v3 cache and takes control immediately.
*/
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys()
            .then(cacheNames => {
                return Promise.all(
                    cacheNames
                        .filter(name => name !== CACHE_NAME)
                        .map(name => caches.delete(name))
                );
            })
            .then(() => self.clients.claim())
    );
});

/*
|--------------------------------------------------------------------------
| FETCH
|--------------------------------------------------------------------------
*/
self.addEventListener('fetch', event => {
    const request = event.request;

    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    /*
     * Registration/login pages:
     * always bypass cache.
     */
    if (url.origin === self.location.origin && isNetworkOnlyUrl(url)) {
        event.respondWith(
            fetch(request, { cache: 'no-store' })
        );
        return;
    }

    /*
     * Any HTML navigation:
     * network first, cached home only as offline fallback.
     * Never cache dynamic Laravel HTML pages.
     */
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request, { cache: 'no-store' })
                .catch(() => caches.match(`${BASE_PATH}/`))
        );
        return;
    }

    /*
     * Static assets:
     * cache first, then network and store successful same-origin assets.
     */
    event.respondWith(
        caches.match(request)
            .then(cachedResponse => {
                if (cachedResponse) {
                    return cachedResponse;
                }

                return fetch(request)
                    .then(networkResponse => {
                        if (
                            !networkResponse ||
                            networkResponse.status !== 200 ||
                            networkResponse.type === 'opaque'
                        ) {
                            return networkResponse;
                        }

                        if (url.origin === self.location.origin) {
                            const responseToCache = networkResponse.clone();

                            caches.open(CACHE_NAME)
                                .then(cache => cache.put(request, responseToCache));
                        }

                        return networkResponse;
                    });
            })
    );
});