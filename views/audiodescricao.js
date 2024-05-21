qrCodeFw.views = {};

qrCodeFw.views.audiodescricao = function() {

    this.viewInit = function() {
        console.log('View audiodescrição - loaded');

        const AudioTracks = qrCodeFw.conteudo; // Conteudo de AD (audio .mp3)

        const navigationBars = $('.multritrack-navigation');
        const mediaElement = document.getElementById('audio');
        const bannerElement = $('#component-card-image');
        const bannerImageElement = $('.banner');
        const nav_next = $('#btn_next');
        const nav_prev = $('#btn_prev');
        const itemtitle = $('.item-title');

        itemtitle.html('Audiodescrição template');
        navigationBars.hide();

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
            let track = AudioTracks.listarFaixas('audio')[index];
            itemtitle.html(track.titulo);
            console.log('this track:',track);
            // Pausar e redefinir o mediaElement antes de carregar um novo
            mediaElement.pause();
            mediaElement.removeAttribute('src'); // Remove a fonte
            mediaElement.load(); // Carrega o estado vazio para redefinir o elemento

            // Define a nova fonte e carrega-a
            mediaElement.src = track.arquivo;
            mediaElement.load(); // Inicia o carregamento da nova fonte

            // Adiciona um ouvinte para quando o media estiver pronto para ser reproduzido
            mediaElement.oncanplay = () => {
                if (qrCodeFw.audio_autoplay) {
                    const playPromise = mediaElement.play();
                    if (playPromise !== undefined) {
                        playPromise.then(() => {
                            // Autoplay começou com sucesso
                            console.log('Autoplay começou');
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
        if (AudioTracks.contarFaixas('audio') === 1) {
           
          
            // Controle de navegação para recursos com item único.
            switch (qrCodeFw.exhibition_navigation_type) {
                case 'none':
                    // Remove barras e botões
                      $('#ad').removeClass('media-multitrack');
                      navigationBars.remove();
                      console.log('case none:','Remove barras e botões');
                    break;
                case 'all':
                    // Exibe barras e botões
                    navigationBars.addClass('black-bg-important');
                    console.log('case all:','Exibe barras e botões');
                    navigationBars.show();
                    nav_next.show();
                    nav_prev.show();
                    break;
                case 'onlyBars':
                    // Exibe somente as barras de navegação sem os botões
                    navigationBars.addClass('black-bg-important');
                    navigationBars.show();
                    nav_next.hide();
                    nav_prev.hide();
                    console.log('case onlyBars:','Exibe somente as barras de navegação sem os botões');
                    break;
                case 'onlyButtons':
                   // Exibe somente os botões de navegação e oculta as barras
                   //$('.multritrack-navigation').css('background','transparent!important');
                   navigationBars.addClass('transparent-bg-important');
                   navigationBars.show();
                   nav_next.show();
                   nav_prev.show();
                   

                   console.log('case onlyButtons:','Exibe somente os botões de navegação e oculta as barras');
                   break; 
            };

            

            let track = AudioTracks.listarFaixas('audio')[0];
            itemtitle.html(track.titulo);
            mediaElement.src = track.arquivo;
            updateBanner(track);

            if (qrCodeFw.audio_autoplay) {
                mediaElement.play().catch((error) => {
                    console.error('Erro durante a reprodução do media:', error);
                });
            }
        } else {
            // Inicializar índice atual
            let currentTrackIndex = 0;

            navigationBars.addClass('black-bg-important');
            navigationBars.show();
            nav_next.show();
            nav_prev.show();

            // Carregar a primeira faixa inicialmente
            loadTrack(currentTrackIndex);

            
            // Event listener para o botão de próxima faixa
            nav_next.on('click', () => {
                currentTrackIndex = (currentTrackIndex + 1) % AudioTracks.contarFaixas('audio');
                loadTrack(currentTrackIndex);
            });

            // Event listener para o botão de faixa anterior
            nav_prev.on('click', () => {
                currentTrackIndex = (currentTrackIndex - 1 + AudioTracks.contarFaixas('audio')) % AudioTracks.contarFaixas('audio');
                loadTrack(currentTrackIndex);
            });
        }

        console.log('Existem...', AudioTracks.contarFaixas('audio'));
        return;
    };
};

// Boot view: Inicializador do módulo
var viewPage = new qrCodeFw.views.audiodescricao();
viewPage.viewInit();
