qrCodeFw.views = {};
qrCodeFw.views.configuracao = function(){

    this.viewInit = function() {
        const setting_webappid = $('.setting_webappid');
        const setting_webapp_title = $('.setting_webapp_title');
        const setting_webapp_basedir = $('.setting_webapp_basedir');
        const setting_webapp_version = $('.setting_webapp_version');
    
        const setting_autoplay_audio = $('.cfg-list-flex.us_audio_autoplay .setting_status');
        const setting_autoplay_video = $('.cfg-list-flex.us_video_autoplay .setting_status');
        const setting_fullscreen_video = $('.cfg-list-flex.us_videos_autofullscreen .setting_status');
        const setting_appsaver = $('.cfg-list-flex.us_inactive_home_back_timer .setting_status');
    
        console.log('%cwebapp->[Configuração]:', 'background: #F8FF09;color: #292922', 'success');
    
        setting_webapp_title.html('<strong>' + qrCodeFw.title + ' • ' + qrCodeFw.subtitle + '</strong>');
        setting_webappid.html('<strong>' + qrCodeFw.appId + '</strong>');
        setting_webapp_basedir.html('<strong>' + qrCodeFw.base_dir + '</strong>');
        setting_webapp_version.html('<strong>' + qrCodeFw.version + '</strong>');
    
        // Configurações padrão
        const defaultSettings = {
            audio_autoplay: qrCodeFw.audio_autoplay,
            video_autoplay: qrCodeFw.video_autoplay,
            videos_autofullscreen: qrCodeFw.videos_autofullscreen,
            inactive_home_back_timer: qrCodeFw.inactive_home_back_timer
        };
    
        // Função para carregar configuração ou definir padrão
        function loadSetting(key, defaultValue) {
            const value = localStorage.getItem(key);
            if (value === null) {
                localStorage.setItem(key, defaultValue);
                return defaultValue;
            }
            return parseInt(value, 10);
        }
    
        // Carrega as configurações do localStorage ou define os valores padrão
        const us_audio_autoplay = loadSetting(qrCodeFw.appId + '_audio_autoplay', defaultSettings.audio_autoplay);
        const us_video_autoplay = loadSetting(qrCodeFw.appId + '_video_autoplay', defaultSettings.video_autoplay);
        const us_videos_autofullscreen = loadSetting(qrCodeFw.appId + '_video_fullscreen', defaultSettings.videos_autofullscreen);
        const us_inactive_home_back_timer = loadSetting(qrCodeFw.appId + '_inactive_home_back_timer', defaultSettings.inactive_home_back_timer);
    
        // Atualiza a UI com as configurações carregadas
        function updateSettingUI(selector, value, activeText, inactiveText) {
            const element = $(selector);
            if (element.attr('type') === 'checkbox') {
                element.prop('checked', value !== 0);
                element.closest('.cfg-list-flex').find('.setting_status').html(value !== 0 ? activeText : inactiveText);
            } else if (element.attr('type') === 'radio') {
                element.filter('[value="' + value + '"]').prop('checked', true);
            }
        }
    
        updateSettingUI('#chb_us_audio_autoplay', us_audio_autoplay, 'Ativo', 'Inativo');
        updateSettingUI('#chb_us_video_autoplay', us_video_autoplay, 'Ativo', 'Inativo');
        updateSettingUI('#chb_us_videos_autofullscreen', us_videos_autofullscreen, 'Ativo', 'Inativo');
        updateSettingUI('.cfg-list-flex.us_inactive_home_back_timer .radio-group input[type="radio"]', us_inactive_home_back_timer);
    
        if (us_inactive_home_back_timer === 0) {
            setting_appsaver.html('Inativo');
        } else {
            setting_appsaver.html('Ativo');
        }
    
        // Evento para alterar configuração de audio autoplay
        $('.us_audio_autoplay').on('click', function() {
            var checkbox = $('#chb_us_audio_autoplay');
            var storageKey = qrCodeFw.appId + '_audio_autoplay';
            var isChecked = !checkbox.prop('checked');
    
            checkbox.prop('checked', isChecked);
            if (isChecked) {
                localStorage.setItem(storageKey, '1');
                setting_autoplay_audio.html('Ativo');
            } else {
                localStorage.setItem(storageKey, '0');
                setting_autoplay_audio.html('Inativo');
            }
        });
    
        // Evento para alterar configuração de video autoplay
        $('.us_video_autoplay').on('click', function() {
            var checkbox = $('#chb_us_video_autoplay');
            var storageKey = qrCodeFw.appId + '_video_autoplay';
            var isChecked = !checkbox.prop('checked');
    
            checkbox.prop('checked', isChecked);
            if (isChecked) {
                localStorage.setItem(storageKey, '1');
                setting_autoplay_video.html('Ativo');
            } else {
                localStorage.setItem(storageKey, '0');
                setting_autoplay_video.html('Inativo');
            }
        });
    
        // Evento para alterar configuração de video fullscreen
        $('.us_videos_autofullscreen').on('click', function() {
            var checkbox = $('#chb_us_videos_autofullscreen');
            var storageKey = qrCodeFw.appId + '_video_fullscreen';
            var isChecked = !checkbox.prop('checked');
    
            checkbox.prop('checked', isChecked);
            if (isChecked) {
                localStorage.setItem(storageKey, '1');
                setting_fullscreen_video.html('Ativo');
            } else {
                localStorage.setItem(storageKey, '0');
                setting_fullscreen_video.html('Inativo');
            }
        });
    
        // Evento para alterar configuração de inactive home back timer
        $('.cfg-list-flex.us_inactive_home_back_timer .radio-group input[type="radio"]').on('change', function() {
            var selectedValue = $(this).val();
            var storageKey = qrCodeFw.appId + '_inactive_home_back_timer';
    
            if (selectedValue === '0') {
                localStorage.setItem(storageKey, '0');
                setting_appsaver.html('Inativo');
            } else {
                localStorage.setItem(storageKey, selectedValue);
                setting_appsaver.html('Ativo');
            }
        });

         // Evento para atualizar a página ao clicar no botão
    $('#btn_update').on('click', function() {
        qrCodeFw.viewLoader('home');
    });

    }; // eof; init
    
    
    
    
    
    

};

    // boot view
    var viewPage = new qrCodeFw.views.configuracao();
    viewPage.viewInit();