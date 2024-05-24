pwaFw.views = {};

pwaFw.views.texto = function() {

    this.viewInit = function() {

        console.log('View texto - loaded');

         // Adicione as faixas de texto
         const TextContent = pwaFw.conteudo; // Conteudo de TEXTO (text .html)

        const navigationBars = $('.multritrack-navigation');
        const textContainerElement = document.getElementById('component-card-text'); // Certifique-se de que o ID do contêiner de texto seja correto
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

        // Função para carregar e exibir a faixa atual
        const loadTrack = async (index) => {
            let track = TextContent.listarFaixas('text')[index];
            itemtitle.html(track.titulo);
            updateBanner(track);

            try {
                const response = await fetch(track.arquivo);
                if (response.ok) {
                    const htmlContent = await response.text();
                    textContainerElement.innerHTML = htmlContent;
                    if (TextContent.contarFaixas('text') === 1) {
                        $('article').css('max-width', 'initial');
                    }
                } else {
                    console.error('Erro ao carregar o arquivo de texto:', response.statusText);
                }
            } catch (error) {
                console.error('Erro ao carregar o arquivo de texto:', error);
            }
        };


        // Inicializar com a faixa correta
        if (TextContent.contarFaixas('text') === 1) {
            
            // Controle de navegação para recursos com item único.
            switch (pwaFw.exhibition_navigation_type) {
                case 'none':
                    // Remove barras e botões
                      $('#libras').removeClass('media-multitrack');
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

            let track = TextContent.listarFaixas('text')[0];
            itemtitle.html(track.titulo);
            updateBanner(track);
            loadTrack(0);
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
                currentTrackIndex = (currentTrackIndex + 1) % TextContent.contarFaixas('text');
                loadTrack(currentTrackIndex);
            });

            // Event listener para o botão de faixa anterior
            nav_prev.on('click', () => {
                currentTrackIndex = (currentTrackIndex - 1 + TextContent.contarFaixas('text')) % TextContent.contarFaixas('text');
                loadTrack(currentTrackIndex);
            });
        }

        console.log('Existem...', TextContent.contarFaixas('text'));
        return;
    };
};

// Boot view: Inicializador do módulo
var viewPage = new pwaFw.views.texto();
viewPage.viewInit();
