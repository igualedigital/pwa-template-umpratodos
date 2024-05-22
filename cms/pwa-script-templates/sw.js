importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.4.1/workbox-sw.js');

if (workbox) {
    console.log(`[Workbox] carregado!`);

    const base_dir = '@basedir';
    const rev_val = 2;

    workbox.core.setCacheNameDetails({
        prefix: '@bappid',
        suffix: 'v'+rev_val,
        precache: 'precache',
        runtime: 'runtime-cache'
    });
    
    // Precaching of critical resources
    workbox.precaching.precacheAndRoute([
        { url: base_dir + 'sw.js', revision: rev_val },
        { url: base_dir + 'manifest.json', revision: rev_val },

        { url: base_dir + 'assets/css/colors.css', revision: rev_val },
        { url: base_dir + 'assets/css/components.css', revision: rev_val },
        { url: base_dir + 'assets/css/fonts.css', revision: rev_val },
        { url: base_dir + 'assets/css/normalize.css', revision: rev_val },
        { url: base_dir + 'assets/css/root.css', revision: rev_val },
        { url: base_dir + 'assets/css/style.css', revision: rev_val },
        { url: base_dir + 'assets/css/views.css', revision: rev_val },
        { url: base_dir + 'assets/css/webapp.css', revision: rev_val },
        { url: base_dir + 'assets/css/webapp.default.theme.css', revision: rev_val },

        { url: base_dir + 'assets/js/jquery/jquery.3.7.1.js', revision: rev_val },
        { url: base_dir + 'assets/js/class.MediaTracks.js', revision: rev_val },
        { url: base_dir + 'assets/js/conteudos.js', revision: rev_val },
        { url: base_dir + 'assets/js/index.js', revision: rev_val },
        { url: base_dir + 'assets/js/main.js', revision: rev_val },

        { url: base_dir + 'assets/pwa/icon-48.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/icon-48.svg', revision: rev_val },
        
        { url: base_dir + 'assets/pwa/icon-72.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/icon-72.svg', revision: rev_val },

        { url: base_dir + 'assets/pwa/icon-96.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/icon-96.svg', revision: rev_val },
        { url: base_dir + 'assets/pwa/icon-144.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/icon-144.svg', revision: rev_val },
        { url: base_dir + 'assets/pwa/icon-168.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/icon-168.svg', revision: rev_val },
        
        { url: base_dir + 'assets/pwa/icon-192.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/icon-192.svg', revision: rev_val },

        { url: base_dir + 'assets/pwa/icon-256.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/icon-256.svg', revision: rev_val },

        { url: base_dir + 'assets/pwa/icon-512.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/icon-512.svg', revision: rev_val },

        { url: base_dir + 'assets/pwa/icon-svg.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/icon-svg.svg', revision: rev_val },

        { url: base_dir + 'assets/pwa/logo-fundo-branco.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/logo-fundo-branco.svg', revision: rev_val },

        { url: base_dir + 'assets/pwa/logo-fundo-preto.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/logo-fundo-preto.svg', revision: rev_val },

        { url: base_dir + 'assets/pwa/logo-transparente.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/logo-transparente.svg', revision: rev_val },

        { url: base_dir + 'assets/pwa/preloader-install-logo.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/preloader-install-logo.svg', revision: rev_val },

        { url: base_dir + 'assets/pwa/pwa-screenshot.png', revision: rev_val },

        { url: base_dir + 'assets/pwa/splash-screen.png', revision: rev_val },
        { url: base_dir + 'assets/pwa/splash-screen.svg', revision: rev_val },

        { url: base_dir + 'assets/images/sample.jpg', revision: rev_val },
        
        { url: base_dir + 'assets/images/icons/icon-home-46px-branco.svg', revision: rev_val },
        { url: base_dir + 'assets/images/icons/icon-ad-46px.svg', revision: rev_val },
        { url: base_dir + 'assets/images/icons/icon-libras-46px.svg', revision: rev_val },
        { url: base_dir + 'assets/images/icons/icon-text-46px-branco.svg', revision: rev_val },

        { url: base_dir + 'includes/appFooter.html', revision: rev_val },
        { url: base_dir + 'includes/appHeader.html', revision: rev_val },

        { url: base_dir + 'index.html', revision: rev_val },

        { url: base_dir + 'views/preloader.html', revision: rev_val },
        { url: base_dir + 'views/preloader.js', revision: rev_val },

        { url: base_dir + 'views/configuracao.html', revision: rev_val },
        { url: base_dir + 'views/configuracao.js', revision: rev_val },
        { url: base_dir + 'views/changelog.html', revision: rev_val },
        { url: base_dir + 'views/changelog.js', revision: rev_val },

        { url: base_dir + 'views/home.html', revision: rev_val },
        { url: base_dir + 'views/home.js', revision: rev_val },
        
        { url: base_dir + 'views/audiodescricao.html', revision: rev_val },
        { url: base_dir + 'views/audiodescricao.js', revision: rev_val },
        
        { url: base_dir + 'views/libras.html', revision: rev_val },
        { url: base_dir + 'views/libras.js', revision: rev_val },
        
        { url: base_dir + 'views/texto.html', revision: rev_val },
        { url: base_dir + 'views/texto.js', revision: rev_val },
        
        // Adicione outros conteúdos de mídia... (Arquivos de conteúdo do PWA)
        
        // Arquivos de audio
       
        // @conteudo@
        
       
    ]);

   // Image Cache Strategy
    workbox.routing.registerRoute(
        ({request}) => request.destination === 'image',
        new workbox.strategies.CacheFirst({
            cacheName: 'image-cache',
            plugins: [
                new workbox.expiration.ExpirationPlugin({
                    maxEntries: 60,
                    maxAgeSeconds: 30 * 24 * 60 * 60, // 30 Days
                }),
                new workbox.cacheableResponse.CacheableResponsePlugin({
                    statuses: [0, 200]
                })
            ]
        })
    );

    // Video Cache Strategy
    workbox.routing.registerRoute(
        ({request}) => request.destination === 'video',
        new workbox.strategies.CacheFirst({
            cacheName: 'video-cache',
            plugins: [
                new workbox.expiration.ExpirationPlugin({
                    maxEntries: 10,
                    maxAgeSeconds: 60 * 24 * 60 * 60, // 60 Days
                }),
                new workbox.cacheableResponse.CacheableResponsePlugin({
                    statuses: [0, 200]
                })
            ]
        })
    );

    // Audio Cache Strategy
    workbox.routing.registerRoute(
        ({request}) => request.destination === 'audio',
        new workbox.strategies.CacheFirst({
            cacheName: 'audio-cache',
            plugins: [
                new workbox.expiration.ExpirationPlugin({
                    maxEntries: 30,
                    maxAgeSeconds: 30 * 24 * 60 * 60, // 30 Days
                }),
                new workbox.cacheableResponse.CacheableResponsePlugin({
                    statuses: [0, 200]
                })
            ]
        })
    );

    // Font Cache Strategy
    workbox.routing.registerRoute(
        ({request}) => request.destination === 'font',
        new workbox.strategies.CacheFirst({
            cacheName: 'font-cache',
            plugins: [
                new workbox.expiration.ExpirationPlugin({
                    maxEntries: 20,
                    maxAgeSeconds: 365 * 24 * 60 * 60, // 1 Year
                }),
                new workbox.cacheableResponse.CacheableResponsePlugin({
                    statuses: [0, 200]
                })
            ]
        })
    );

    // Set up message listener for when client checks if SW is ready
    self.addEventListener('message', (event) => {
        if (event.data && event.data.action === 'checkSWReady') {
            event.source.postMessage({ type: 'SW_READY', isReady: true });
        }
    });

    // Activate event
    self.addEventListener('activate', (event) => {
        event.waitUntil(clients.claim());
        // Clean up old caches
        event.waitUntil(
            caches.keys().then(cacheNames => {
                return Promise.all(
                    cacheNames.map(cacheName => {
                        // Ensure you delete the caches that are not needed anymore
                        if (!cacheName.startsWith('workbox') && !self.__precacheManifest.includes(cacheName)) {
                            return caches.delete(cacheName);
                        }
                    })
                );
            })
        );
    });
} else {
    console.log(`Workbox não carregado`);
}
