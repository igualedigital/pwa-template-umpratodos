// Determine o título, subtítulo e descrição do webapp
pwaFw.title = "TEMPLATE - PWA BANCADAS ACESSÍVEIS";
pwaFw.subtitle = "Projeto Exemplo";
pwaFw.description = "Template para projetos QRCode PWA - Bancadas acessíveis - UMPRATODOS.";

// Determine abaixo o caminho relativo do webapp;
pwaFw.base_dir = '/dev/pwa/';
pwaFw.appId = btoa(pwaFw.base_dir);
pwaFw.version = '1.6.1';

// Configurações padrão e fallBack
// Determine na variável abaixo: 1 para ativar o pwa | 0 = para não ativar o pwa.
pwaFw.pwa_ready = 0;

// Determine o autoplay em arquivos de audio.
pwaFw.audio_autoplay = 1;

// Determine o autoplay em arquivos de vídeo.
pwaFw.video_autoplay = 1;

// Determine se a execução de vídeo será realizada automaticamente em modo fullscreen.
pwaFw.videos_autofullscreen = 0;

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

//pwaFw.inactive_home_back_timer = 300000; // 5 minutos.
pwaFw.inactive_home_back_timer = 0; // inativo -> padrão

/**
 * Determina o tipo de exibição dos controles de navegação quando existe somente de 1 item por recurso
 * none => Não exibe as barras nem os botões.
 * all => exibe tanto a barra quanto os botões.
 * onlyBars = exibe somente as barras sem os botões.
 * onlyButtons = exibe somente os botões sem as barras.
 */

pwaFw.exhibition_navigation_type = 'onlyBars'; //(default)


// Carrega as configurações do usuário do localStorage
const user_audio_autoplay = localStorage.getItem(pwaFw.appId + '_audio_autoplay');
const user_video_autoplay = localStorage.getItem(pwaFw.appId + '_video_autoplay');
const user_videos_autofullscreen = localStorage.getItem(pwaFw.appId + '_video_fullscreen');
const user_inactive_home_back_timer = localStorage.getItem(pwaFw.appId + '_inactive_home_back_timer');
const user_exhibition_navigation_type = localStorage.getItem(pwaFw.appId + '_exhibition_navigation_type');

// Sobrescreve as configurações padrão com as configurações do usuário, se existirem
if (user_audio_autoplay !== null) {
    pwaFw.audio_autoplay = parseInt(user_audio_autoplay, 10);
};

if (user_video_autoplay !== null) {
    pwaFw.video_autoplay = parseInt(user_video_autoplay, 10);
};

if (user_videos_autofullscreen !== null) {
    pwaFw.videos_autofullscreen = parseInt(user_videos_autofullscreen, 10);
};

if (user_inactive_home_back_timer !== null) {
    pwaFw.inactive_home_back_timer = parseInt(user_inactive_home_back_timer, 10);
};
if (user_exhibition_navigation_type !== null) {
    pwaFw.exhibition_navigation_type  = user_exhibition_navigation_type;
};
// End of file