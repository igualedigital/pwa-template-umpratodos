// Determine o título, subtítulo e descrição do webapp
qrCodeFw.title = "TEMPLATE - PWA BANCADAS ACESSÍVEIS";
qrCodeFw.subtitle = "Projeto Exemplo";
qrCodeFw.description = "Template para projetos QRCode PWA - Bancadas acessíveis - UMPRATODOS.";

// Determine abaixo o caminho relativo do webapp;
qrCodeFw.base_dir = '/projetos/dev/template-pwa-bancada/';
qrCodeFw.appId = btoa(qrCodeFw.base_dir);
qrCodeFw.version = '1.5.3';

// Configurações padrão e fallBack
// Determine na variável abaixo: 1 para ativar o pwa | 0 = para não ativar o pwa.
qrCodeFw.pwa_ready = 1;

// Determine o autoplay em arquivos de audio.
qrCodeFw.audio_autoplay = 1;

// Determine o autoplay em arquivos de vídeo.
qrCodeFw.video_autoplay = 1;

// Determine se a execução de vídeo será realizada automaticamente em modo fullscreen.
qrCodeFw.videos_autofullscreen = 0;

// Determine se a home deve ser carregada em caso de inativadade. Defina o tempo em milesegundos.
// Para não disparar o evento deixe o valor em 0; ex: defina 300000 para 5 minutos., 15000 para 15 segundos, etc...
/**
 * 10 segundos = 10000;
 * 30 segundos = 30000;
 * 1 minuto = 60000;
 * 5 minutos = 300000;
 * 10 minutos = 600000;
 * 30 minutos = 1800000;
 */

//qrCodeFw.inactive_home_back_timer = 300000; // 5 minutos.
qrCodeFw.inactive_home_back_timer = 0; // inativo -> padrão

// Carrega as configurações do usuário do localStorage
const user_audio_autoplay = localStorage.getItem(qrCodeFw.appId + '_audio_autoplay');
const user_video_autoplay = localStorage.getItem(qrCodeFw.appId + '_video_autoplay');
const user_videos_autofullscreen = localStorage.getItem(qrCodeFw.appId + '_video_fullscreen');
const user_inactive_home_back_timer = localStorage.getItem(qrCodeFw.appId + '_inactive_home_back_timer');

// Sobrescreve as configurações padrão com as configurações do usuário, se existirem
if (user_audio_autoplay !== null) {
    qrCodeFw.audio_autoplay = parseInt(user_audio_autoplay, 10);
}

if (user_video_autoplay !== null) {
    qrCodeFw.video_autoplay = parseInt(user_video_autoplay, 10);
}

if (user_videos_autofullscreen !== null) {
    qrCodeFw.videos_autofullscreen = parseInt(user_videos_autofullscreen, 10);
}

if (user_inactive_home_back_timer !== null) {
    qrCodeFw.inactive_home_back_timer = parseInt(user_inactive_home_back_timer, 10);
}


// INICIALIZAÇÃO

qrCodeFw.initializer = function() {
    let deferredPrompt;
    

    this.appStart = function() {

      
        $('title').text(qrCodeFw.title);
        $('meta[name="description"]').attr('content', qrCodeFw.description);
        $('meta[name="apple-mobile-web-app-title"]').attr('content', qrCodeFw.description);

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            console.log('beforeinstallprompt Event fired');

            // Guarda o evento para uso posterior
            window.deferredPrompt = e;

            if (qrCodeFw.pwa_ready == "1") {
                // Show install button if preloader has finished loading
                if ($('.progress-bar').width() >= 98 + '%') {
                    showInstallPromotion();
                }
            }
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
                qrCodeFw.isIPhone = /iPhone/.test(navigator.userAgent) && !window.MSStream;
                return qrCodeFw.isIPhone;
            }
        

            if ((qrCodeFw.pwa_ready == "1" && !localStorage.getItem(qrCodeFw.appId)) && !isIPhone()) {
                qrCodeFw.viewLoader('preloader');
               // $("#content-placeholder").attr("data-content-loaded", "preloader");
                //qrCodeFw.viewLoader('preloader');
        
                qrCodeFw.pwaReady().then(() => {
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
                $("#header-placeholder").load(qrCodeFw.base_dir + "includes/appHeader.html");
                $("#footer-placeholder").load(qrCodeFw.base_dir + "includes/appFooter.html", function() {
                    // Verifica se o recurso acessível tem conteúdo, caso contrário remove o elemento.
                    
                    if(qrCodeFw.conteudo.contarFaixas('audio') === 0){
                        $('.fgrid-ad').remove();
                    }
                    if(qrCodeFw.conteudo.contarFaixas('video') === 0){
                        $('.fgrid-libras').remove();
                    }
                    if(qrCodeFw.conteudo.contarFaixas('text') === 0){
                        $('.fgrid-text').remove();
                    }
                    
                    $("#footer-placeholder").show();
                    qrCodeFw.viewLoader('home');
                    $('body').show();
           

                });
            };
        })();


        (function() {
            let inactivityTimeout;
            let lastActivityTime = Date.now();
        
            // Função para resetar o timer de inatividade
            function resetInactivityTimeout() {
                if (qrCodeFw.inactive_home_back_timer === 0) {
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
                    }, qrCodeFw.inactive_home_back_timer);
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
                qrCodeFw.viewLoader('home');
                $('body').show();
            }
        
            // Eventos que resetam o timer de inatividade
            ['mousemove', 'keydown', 'click', 'touchstart'].forEach(event => {
                document.addEventListener(event, resetInactivityTimeout, false);
            });
        
            // Inicializa o timer de inatividade
            if (qrCodeFw.inactive_home_back_timer !== 0) {
                resetInactivityTimeout();
            }
        })();
        

        

    };

   
qrCodeFw.pwaReady = function() {
    return new Promise((resolve, reject) => {
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register(qrCodeFw.base_dir + 'sw.js', { scope: qrCodeFw.base_dir })
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
        qrCodeFw.viewLoader(_resource);

    });

    // [+] view loader
    qrCodeFw.viewLoader = function(viewName) {
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
                        const workboxCacheName = cacheNames.find(name => name.includes(qrCodeFw.appId));
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
    qrCodeFw.enterFullScreen = function(video_element){
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

  
    qrCodeFw.exitFullScreen = function(){
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