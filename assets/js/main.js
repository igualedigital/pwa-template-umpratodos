// INICIALIZAÇÃO

pwaFw.initializer = function() {
    let deferredPrompt;
    

    this.appStart = function() {

      
        $('title').text(pwaFw.title);
        $('meta[name="description"]').attr('content', pwaFw.description);
        $('meta[name="apple-mobile-web-app-title"]').attr('content', pwaFw.description);

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            console.log('beforeinstallprompt Event fired');

            // Guarda o evento para uso posterior
            window.deferredPrompt = e;

            if (pwaFw.pwa_ready == 1) {
                // Show install button if preloader has finished loading
                if ($('.progress-bar').width() >= 98 + '%') {
                    showInstallPromotion();
                }
            };
            //else{
               // $('link[rel="manifest"]').remove();
            //}
        });

        function showInstallPromotion() {
            console.log('Pode mostrar UI de instalação do PWA');
            const installButtonContainer = $('.install_button');
            if (installButtonContainer) {
                installButtonContainer.show();
            }
        }

   
        (function main() {

            // Função para detectar se o dispositivo é um iPhone
            function isIPhone() {
                pwaFw.isIPhone = /iPhone/.test(navigator.userAgent) && !window.MSStream;
                return pwaFw.isIPhone;
            }
        

            if ((pwaFw.pwa_ready == "1" && !localStorage.getItem(pwaFw.appId)) && !isIPhone()) {
                pwaFw.viewLoader('preloader');
               // $("#content-placeholder").attr("data-content-loaded", "preloader");
                //pwaFw.viewLoader('preloader');
        
                pwaFw.pwaReady().then(() => {
                    console.log('PWA Ready!');
                    // Mostra a promoção de instalação somente após o SW estar pronto
                    if (deferredPrompt) {
                        showInstallPromotion();
                    }
                }).catch((error) => {
                    console.error('PWA Setup Failed:', error);
                });
            } else {
                $("#footer-placeholder").hide();
                $("#header-placeholder").load(pwaFw.base_dir + "includes/appHeader.html");
                $("#footer-placeholder").load(pwaFw.base_dir + "includes/appFooter.html", function() {
                    // Verifica se o recurso acessível tem conteúdo, caso contrário remove o elemento.
                    
                    if(pwaFw.conteudo.contarFaixas('audio') === 0){
                        $('.fgrid-ad').remove();
                    }
                    if(pwaFw.conteudo.contarFaixas('video') === 0){
                        $('.fgrid-libras').remove();
                    }
                    if(pwaFw.conteudo.contarFaixas('text') === 0){
                        $('.fgrid-text').remove();
                    }
                    
                    $("#footer-placeholder").show();
                    pwaFw.viewLoader('home');
                    $('body').show();
           

                });
            };
        })();


        (function() {
            let inactivityTimeout;
            let lastActivityTime = Date.now();
        
            // Função para resetar o timer de inatividade
            function resetInactivityTimeout() {
                if (pwaFw.inactive_home_back_timer === 0) {
                    return; // Não ativar o timer se for 0
                }
        
                if (inactivityTimeout) {
                    clearTimeout(inactivityTimeout);
                }
        
                if (!isMediaPlaying()) {
                    inactivityTimeout = setTimeout(() => {
                        if ($("#content-placeholder").attr("data-content-loaded") !== "home") {
                            loadHomeView();
                        }
                    }, pwaFw.inactive_home_back_timer);
                }
        
                lastActivityTime = Date.now();
            }
        
            // Função para verificar se há algum áudio ou vídeo em execução
            function isMediaPlaying() {
                const mediaElements = document.querySelectorAll('audio, video');
                for (let element of mediaElements) {
                    if (!element.paused && !element.ended) {
                        return true;
                    }
                }
                return false;
            }
        
            // Função para carregar a view da home
            function loadHomeView() {
                pwaFw.viewLoader('home');
                $('body').show();
            }
        
            // Eventos que resetam o timer de inatividade
            ['mousemove', 'keydown', 'click', 'touchstart'].forEach(event => {
                document.addEventListener(event, resetInactivityTimeout, false);
            });
        
            // Inicializa o timer de inatividade
            if (pwaFw.inactive_home_back_timer !== 0) {
                resetInactivityTimeout();
            }
        })();
        

        

    };

   
pwaFw.pwaReady = function() {
    return new Promise((resolve, reject) => {
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register(pwaFw.base_dir + 'sw.js', { scope: pwaFw.base_dir })
                .then((registration) => {
                    console.log('[PWA]: Service Worker Registered', registration.scope);

                    if (navigator.serviceWorker.controller) {
                        console.log('Service Worker in webapp control.');
                        resolve();
                    } else {
                        navigator.serviceWorker.oncontrollerchange = function() {
                            console.log('Service Worker has taken control of the webapp.');
                            resolve();
                        };
                    }

                    navigator.serviceWorker.addEventListener('message', (event) => {
                        if (event.data.type === 'SW_READY') {
                            console.log('Service Worker reports ready for offline use.');
                            resolve();
                        }
                    });

                }).catch((err) => {
                    console.log('ServiceWorker registration failed:', err);
                    reject(err);
                });
            });
        } else {
            console.log('Service Worker is not supported in this browser.');
            reject('Service Worker is not supported in this browser.');
        }
    });

};
};


    // BOTÕES DE RECURSOS ACESSÍVEIS (event delegation)

    $(document).on('click', '.btn_resource_a11y', function() {
        let _resource = $(this).data('a11y-resource');  // Usando .data() para acessar o atributo data
        console.log(_resource + ' => LOADED!');
        pwaFw.viewLoader(_resource);

    });

    // [+] view loader
    pwaFw.viewLoader = function(viewName) {
        const basePath = 'views/';
        const elementSelector = '#content-placeholder';
        const htmlPath = `${basePath}${viewName}.html`;
        const jsPath = `${basePath}${viewName}.js`;
    
        if ($(elementSelector).attr("data-content-loaded") !== viewName) {
            $(elementSelector).load(htmlPath, function() {
                if (navigator.onLine) {
                    $.getScript(jsPath)
                        .done(function(script, textStatus) {
                            console.log('[viewloader] Script carregado com sucesso online.');
                        })
                        .fail(function(jqxhr, settings, exception) {
                            console.error('[viewloader] Erro ao carregar o script online:', exception);
                        });
                } else {
                    // Procura no cache o arquivo com postfix do Workbox
                    caches.keys().then(cacheNames => {
                        // Encontre o nome do cache que corresponde ao cache do Workbox
                        const workboxCacheName = cacheNames.find(name => name.includes(pwaFw.appId));
                        if (workboxCacheName) {
                            caches.open(workboxCacheName).then(cache => {
                                cache.keys().then(keys => {
                                    // Encontra a chave que inclui o jsPath (mesmo que com o postfix)
                                    const cacheKey = keys.find(request => request.url.includes(jsPath));
                                    if (cacheKey) {
                                        caches.match(cacheKey).then(response => {
                                            if (!response) {
                                                throw new Error('[viewloader] Script não encontrado no cache.');
                                            }
                                            return response.text();
                                        })
                                        .then(scriptText => {
                                            const scriptElement = document.createElement('script');
                                            scriptElement.text = scriptText;
                                            document.head.appendChild(scriptElement);
                                            console.log('[viewloader] Script carregado com sucesso offline.');
                                        })
                                        .catch(error => {
                                            console.error('[viewloader] Erro ao carregar o script offline:', error);
                                        });
                                    } else {
                                        console.error(`[viewloader] Script ${jsPath} não encontrado no cache.`);
                                    }
                                });
                            });
                        } else {
                            console.error('[viewloader] Cache do Workbox não encontrado.');
                        }
                    });
                }
            });
        }
    };
    

    // [+] fullscreen
    pwaFw.enterFullScreen = function(video_element){
        if (!document.fullscreenElement) {
            if (video_element.requestFullscreen) {
                video_element.requestFullscreen();
            } else if (video_element.mozRequestFullScreen) { // Firefox
                video_element.mozRequestFullScreen();
            } else if (video_element.webkitRequestFullscreen) { // Chrome, Safari and Opera
                video_element.webkitRequestFullscreen();
            } else if (video_element.msRequestFullscreen) { // IE/Edge
                video_element.msRequestFullscreen();
            }
        }
    };

  
    pwaFw.exitFullScreen = function(){
        console.log('check!');
        if (document.fullscreenElement) {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) { // Firefox
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) { // Chrome, Safari and Opera
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { // IE/Edge
                document.msExitFullscreen();
            }
        }
    };

    // [-] fullscreen


// [-] MediaClass

    // Desabilita o log no console.
    function disableDebug() {
        var console = {};
        console.log = function() {};
    }

// End of file