qrCodeFw.views = {};

qrCodeFw.views.audiodescricao = function() {

    this.viewInit = function() {

        console.log('View audiodescrição - loaded');

        const AudioTracks =  qrCodeFw.conteudo; // Conteudo de AD (audio .mp3)

        const mediaElement = document.getElementById('audio');
        const bannerElement = $('#component-card-image');
        const bannerImageElement = $('.banner');
        const nav_next = $('#btn_next');
        const nav_prev = $('#btn_prev');
        
        const itemtitle = $('.item-title');
        itemtitle.html('Audiodescrição template');

        

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
            mediaElement.src = track.arquivo;
            updateBanner(track);

            if (qrCodeFw.audio_autoplay) {
                mediaElement.play();
            }
        };

        // Inicializar com a faixa correta
        if (AudioTracks.contarFaixas('audio') === 1) {
            $('#ad').removeClass('media-multitrack');
            $('.multritrack-navigation').remove();

            let track = AudioTracks.listarFaixas('audio')[0];
            itemtitle.html(track.titulo);
            mediaElement.src = track.arquivo;
            updateBanner(track);

            if (qrCodeFw.audio_autoplay) {
                mediaElement.play();
            }
        } else {
            // Inicializar índice atual
            let currentTrackIndex = 0;

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
