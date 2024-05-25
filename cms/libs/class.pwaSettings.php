<?php

class pwaSettings {
    
    private $filePath;
    private $cmsDirectory;
    private $sizeInBytes;
    private $formattedSize;
    private $appId;
    private $pwaContents;
  

    public function __construct($pwaContents = null) {

       // Se uma instância de pwaContents for fornecida, use-a
       if ($pwaContents) {
        $this->pwaContents = $pwaContents;
        $pwaContents->setPwaSettings($this); // Defina a instância de pwaSettings em pwaContents
    } else {
        $this->pwaContents = new pwaContents($this);
    }

        $this->filePath = PWA_DIR . DIRECTORY_SEPARATOR . 'cms' . DIRECTORY_SEPARATOR .'outputs'. DIRECTORY_SEPARATOR . 'projeto-pwa.json';
        $this->cmsDirectory = PWA_CMS_DIR;
        $this->sizeInBytes = calculateDirectorySize(PWA_DIR, $this->cmsDirectory);
        $this->formattedSize = formatSizeUnits($this->sizeInBytes);
        $this->appId = generateAppId(PWA_DIR);
    }


    public function updatePwa($titulo, $subtitulo, $descricao, $estado,$autoplay_audio,$autoplay_video,$auto_fullscreen,$home_back_timer) {
        $data = array(
            'app-id' => $this->appId,
            'titulo' => $titulo,
            'sub-titulo' => $subtitulo,
            'descricao' => $descricao,
            'estado-pwa' => (int)$estado,
            'autoplay-audio' => (int)$autoplay_audio,
            'autoplay-video' => (int)$autoplay_video,
            'auto-fullscreen' => (int)$auto_fullscreen,
            'home-back-timer' => (int)$home_back_timer,
            'diretorio-base' => PWA_DIR,
            'diretorio-base-web' => PWA_WEB_BASE,
            'tamanho' => $this->formattedSize,
            'conteudos' => array()
        );

       
        $json_data = json_encode($data, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);

        if (file_put_contents($this->filePath, $json_data)) {
            $this->pwaContents->updateJSfiles();
            return 'success';
        } else {
            http_response_code(500);
            return 'error';
        }
    }

    public function getPwaInfo() {
        $jsonPath = $this->filePath;
        $cmsDirectory = __DIR__;
        $sizeInBytes = calculateDirectorySize(PWA_DIR, $cmsDirectory);
        $formattedSize = formatSizeUnits($sizeInBytes);
        $appId = generateAppId(PWA_DIR);

        // Valores padrão (fallback)
        $defaultInfo = array(
            'app-id' => $this->appId,
            'titulo' => 'Meu PWA',
            'sub-titulo' => 'Um exemplo de Progressive Web App',
            'descricao' => 'Descrição desse maravilhoso projeto PWA',
            'estado-pwa' => 0,
            'autoplay-audio' => 1,
            'autoplay-video' => 1,
            'auto-fullscreen' => 0,
            'home-back-timer' => 0,
            'diretorio-base' => PWA_DIR,
            'diretorio-base-web' => PWA_WEB_BASE,
            'tamanho' => $this->formattedSize,
            'conteudos' => array()
        );

        // Verifica se o arquivo JSON existe e não está vazio
        if (file_exists($jsonPath)) {
            $jsonContent = file_get_contents($jsonPath);
            $jsonData = json_decode($jsonContent, true);

            if ($jsonData && json_last_error() === JSON_ERROR_NONE) {
                return array_merge($defaultInfo, $jsonData);
            }
        }

        return $defaultInfo;
    }
}
?>
