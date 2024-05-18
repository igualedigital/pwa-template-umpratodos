qrCodeFw.views = qrCodeFw.views || {};
qrCodeFw.views.preloader = function() {
    this.viewInit = function() {
        const progressBar = $('.progress-bar');
        const installButtonContainer = $('.install_button');
        const installButton = $('#btn_install');
        const loaderText = $('.loader-text');
        const textLoaderInfo = $('.text-loader-info'); 
        const loaderBar = $('.loader');
    

        let simulatedProgress = 0;
        let simulateLoadingInterval;

        $('.title_elm').html(qrCodeFw.title+'<br>'+qrCodeFw.subtitle);

        $('#btn_follow_app').on('click', function() {
            console.log('Botão clicado, a página será recarregada.');
    
            // Recarrega a página
            window.location.reload();
        });

        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            // Gera um número inteiro aleatório entre min (inclusivo) e max (exclusivo)
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        // Função para iniciar a simulação de progresso
        const simulateLoading = () => {
            simulateLoadingInterval = setInterval(() => {
                if (simulatedProgress < 98) {
                    simulatedProgress += 1;
                    progressBar.width(`${simulatedProgress}%`);
                    loaderText.text(`${simulatedProgress}%`);
                } else {
                    clearInterval(simulateLoadingInterval);
                }
            }, getRandomInt(160, 480));
        };
        simulateLoading();

        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register(qrCodeFw.base_dir + 'sw.js').then(function(registration) {
                console.log('Service Worker Registered');

                navigator.serviceWorker.addEventListener('message', function(event) {
                    if (event.data && event.data.type === 'SW_READY') {
                        console.log('Service Worker is ready for offline use');

                        // Parar a simulação quando o Service Worker estiver pronto
                        clearInterval(simulateLoadingInterval);

                        progressBar.width('100%');
                        loaderText.html('<strong>Concluído!</strong><br>Pronto para instalação e uso offline.');
                        textLoaderInfo.remove();
                        //loaderBar.hide();

                        installButtonContainer.show();
                        localStorage.setItem(qrCodeFw.appId, 'true');
                    }
                });

                // Periódico para verificar se o SW está pronto
                let checkSWReadyInterval = setInterval(() => {
                    if (navigator.serviceWorker.controller) {
                        navigator.serviceWorker.controller.postMessage({ action: 'checkSWReady' });
                    }
                }, 1000);

                // Parar verificações quando o SW estiver pronto
                navigator.serviceWorker.addEventListener('message', function(event) {
                    if (event.data && event.data.type === 'SW_READY') {
                        clearInterval(checkSWReadyInterval);
                    }
                });

            }).catch(function(error) {
                console.log('Registration failed with ' + error);
            });

            installButton.on('click', function() {
                if (window.deferredPrompt) {
                    const promptEvent = window.deferredPrompt;
                    promptEvent.prompt();
                    promptEvent.userChoice.then((choiceResult) => {

                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the A2HS prompt');
                            installButtonContainer.hide();
                            window.location.reload();
                        } else {
                            console.log('User dismissed the A2HS prompt');
                            window.location.reload();
                        }
                        window.deferredPrompt = null;
                        
                    });
                } else {
                    console.log('Deferred prompt is not available.');
                }
            });
        }
    }
};

// Initialize the view
var viewPage = new qrCodeFw.views.preloader();
viewPage.viewInit();
