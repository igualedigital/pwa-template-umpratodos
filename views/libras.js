qrCodeFw.views = {};

qrCodeFw.views.libras = function() {
    this.viewInit = function() {
        console.log('View LIBRAS - loaded');

        // Adicione as faixas de vídeo
        const VideoTracks = qrCodeFw.conteudo; // Conteúdo de LIBRAS (vídeo .mp4)

        const mediaElement = document.getElementById('videoElm');
        const bannerElement = $('#component-card-image');
        const bannerImageElement = $('.banner');
        const nav_next = $('#btn_next');
        const nav_prev = $('#btn_prev');
        
        const itemtitle = $('.item-title');
        itemtitle.html('Audiodescrição template');

        // Função para configurar eventos de tela cheia
        const setupFullscreenEvents = () => {
            if (qrCodeFw.videos_autofullscreen === 1 && !qrCodeFw.isIPhone) {
                let isSeeking = false; // Flag para detectar interação com a barra de progresso
                let seekTimeout; // Timeout para diferenciar entre pausa intencional e pausa causada por seek
                
                mediaElement.addEventListener('play', () => qrCodeFw.enterFullScreen(mediaElement));
                mediaElement.addEventListener('pause', () => {
                    seekTimeout = setTimeout(() => {
                        if (!isSeeking) {
                            qrCodeFw.exitFullScreen();
                        }
                    }, 100); // Pequeno atraso antes de sair do modo de tela cheia
                });
                mediaElement.addEventListener('seeking', () => {
                    isSeeking = true;
                    clearTimeout(seekTimeout); // Cancela o timeout ao iniciar o seek
                });
                mediaElement.addEventListener('seeked', () => {
                    isSeeking = false;
                    setTimeout(() => {
                        if (!mediaElement.paused) {
                            qrCodeFw.enterFullScreen(mediaElement);
                        }
                    }, 100); // Pequeno atraso para garantir que estamos fora do evento seek
                });
                mediaElement.addEventListener('ended', qrCodeFw.exitFullScreen);
            }
        };

        // Função para atualizar o banner
        const updateBanner = (track) => {
            if (!track.imagem) {
                bannerElement.hide();
            } else {
                bannerImageElement.attr('src', track.imagem);
                bannerImageElement.attr('alt', track.descricao_da_imagem);
                bannerImageElement.attr('title', track.descricao_da_imagem);
                bannerElement.show();
            }
        };

        // Função para carregar e tocar a faixa atual
        const loadTrack = (index) => {
            let track = VideoTracks.listarFaixas('video')[index];
            itemtitle.html(track.titulo);

            // Pausar e redefinir o mediaElement antes de carregar um novo
            mediaElement.pause();
            mediaElement.removeAttribute('src'); // Remove a fonte
            mediaElement.load(); // Carrega o estado vazio para redefinir o elemento

            // Define a nova fonte e carrega-a
            mediaElement.src = track.arquivo;
            mediaElement.load(); // Inicia o carregamento da nova fonte

            // Adiciona um ouvinte para quando o media estiver pronto para ser reproduzido
            mediaElement.oncanplay = () => {
                if (qrCodeFw.video_autoplay) {
                    const playPromise = mediaElement.play();
                    if (playPromise !== undefined) {
                        playPromise.then(() => {
                            // Reprodução automática começou com sucesso
                            console.log('Reprodução automática começou');
                        }).catch((error) => {
                            // Lida com erros se a solicitação de reprodução foi interrompida ou falhou
                            console.error('Erro durante a reprodução do media:', error);
                        });
                    }
                }
            };

            updateBanner(track);
        };

        // Inicializar com a faixa correta
        if (VideoTracks.contarFaixas('video') === 1) {
            $('#libras').removeClass('media-multitrack');
            $('.multritrack-navigation').remove();

            let track = VideoTracks.listarFaixas('video')[0];
            itemtitle.html(track.titulo);
            mediaElement.src = track.arquivo;
            updateBanner(track);

            setupFullscreenEvents();

            if (qrCodeFw.video_autoplay) {
                mediaElement.play().catch((error) => {
                    console.error('Erro durante a reprodução do media:', error);
                });
            }
        } else {
            // Inicializar índice atual
            let currentTrackIndex = 0;

            // Carregar a primeira faixa inicialmente
            loadTrack(currentTrackIndex);

            // Event listener para o botão de próxima faixa
            nav_next.on('click', () => {
                currentTrackIndex = (currentTrackIndex + 1) % VideoTracks.contarFaixas('video');
                loadTrack(currentTrackIndex);
            });

            // Event listener para o botão de faixa anterior
            nav_prev.on('click', () => {
                currentTrackIndex = (currentTrackIndex - 1 + VideoTracks.contarFaixas('video')) % VideoTracks.contarFaixas('video');
                loadTrack(currentTrackIndex);
            });

            setupFullscreenEvents();
        }

        console.log('Existem (videos):', VideoTracks.contarFaixas('video'));
        return;
    }
};

// Boot view
var viewPage = new qrCodeFw.views.libras();
viewPage.viewInit();
