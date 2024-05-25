<?php

class pwaContents {
    private $conteudoJsPath;
    private $pwaSettings;

    public function __construct($pwaSettings = null) {
        $this->conteudoJsPath = PWA_CMS_DIR . DIRECTORY_SEPARATOR . 'outputs' . DIRECTORY_SEPARATOR . 'conteudo.js';
        
        if ($pwaSettings) {
            $this->pwaSettings = $pwaSettings;
        }

        $outputDir = dirname($this->conteudoJsPath);
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        if (!file_exists($this->conteudoJsPath)) {
            $conteudoJs = "pwaFw.conteudo = pwaFw.conteudo || {};\n";
            $conteudoJs .= "pwaFw.conteudo = new ColecaoFaixas();\n\n";
            file_put_contents($this->conteudoJsPath, $conteudoJs);
        }
    }

    public function setPwaSettings($pwaSettings) {
        $this->pwaSettings = $pwaSettings;
    }

    private function saveTextContent($content) {
        $parsedown = new Parsedown();
        $htmlContent = $parsedown->text($content);
        $uuid = $this->generateUUID();
        $markdownFileName = $uuid . ".md";
        $htmlFileName = $uuid . ".html";
        file_put_contents(PWA_STORAGE_TEXT . DIRECTORY_SEPARATOR . $markdownFileName, $content);
        file_put_contents(PWA_STORAGE_TEXT . DIRECTORY_SEPARATOR . $htmlFileName, $htmlContent);
        return PWA_STORAGE_TEXT . DIRECTORY_SEPARATOR . $htmlFileName;
    }

    private function saveFile($file, $type) {
        $fileName = uniqid() . '-' . basename($file['name']);
        $directory = '';

        switch ($type) {
            case 'audio':
                $directory = PWA_STORAGE_AUDIO;
                break;
            case 'video':
                $directory = PWA_STORAGE_VIDEO;
                break;
        }

        $filePath = $directory . DIRECTORY_SEPARATOR . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception('Falha ao mover o arquivo de ' . $type);
        }

        return $filePath;
    }

    private function generateUUID() {
        return bin2hex(random_bytes(16));
    }

    public function adicionarConteudo($title, $type, $imageDescription, $imageFile, $contentData) {
        try {
            $imageFileName = $imageFile ? uniqid() . '-' . basename($imageFile) : null;
            $contentFilePath = '';

            switch ($type) {
                case 'text':
                    $contentFilePath = $this->saveTextContent($contentData);
                    break;
                case 'audio':
                case 'video':
                    $contentFilePath = $this->saveFile($contentData, $type);
                    break;
                default:
                    throw new Exception('Tipo de conteúdo não suportado.');
            }

            if ($imageFile) {
                $imageFilePath = PWA_STORAGE_IMAGES . DIRECTORY_SEPARATOR . $imageFileName;
                if (!move_uploaded_file($_FILES['imageFile']['tmp_name'], $imageFilePath)) {
                    throw new Exception('Falha ao mover o arquivo de imagem.');
                }
            }

            if (!file_exists($this->conteudoJsPath)) {
                throw new Exception('O arquivo conteudo.js não existe: ' . $this->conteudoJsPath);
            }

            if (!is_readable($this->conteudoJsPath)) {
                throw new Exception('O arquivo conteudo.js não é legível: ' . $this->conteudoJsPath);
            }

            $conteudoJs = file_get_contents($this->conteudoJsPath);
            if ($conteudoJs === false) {
                throw new Exception('Falha ao ler o arquivo conteudo.js: ' . $this->conteudoJsPath);
            }

            $newContent = "pwaFw.conteudo.adicionarFaixa('$title', " . ($imageFileName ? "'$imageFileName'" : "null") . ", " . ($imageDescription ? "'$imageDescription'" : "null") . ", '" . basename($contentFilePath) . "', '$type');\n";
            $conteudoJs .= $newContent;
            file_put_contents($this->conteudoJsPath, $conteudoJs);

            $this->updateJSfiles();
            return ['status' => 'success'];
        } catch (Exception $e) {
            error_log('Erro ao adicionar conteúdo: ' . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateJSfiles() {
        
        if (!$this->pwaSettings) {
            throw new Exception('pwaSettings não está definido.');
        }

        $pwaInfo = $this->pwaSettings->getPwaInfo();
        $templateDir = PWA_CMS_DIR . DIRECTORY_SEPARATOR . 'pwa-script-templates';
        $outputDir = PWA_CMS_DIR . DIRECTORY_SEPARATOR . 'outputs';

        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }

        $templateFiles = ['settings.js', 'manifest.json', 'sw.js','conteudo.js'];
        $cacheVersion = getNextSequenceNumber(SEQUENCIAL_FILE);

        foreach ($templateFiles as $file) {
            $templatePath = $templateDir . DIRECTORY_SEPARATOR . $file;
            $outputPath = $outputDir . DIRECTORY_SEPARATOR . $file;

            if (file_exists($templatePath)) {
                $content = file_get_contents($templatePath);

                $content = str_replace('@title', $pwaInfo['titulo'], $content);
                $content = str_replace('@subtitle', $pwaInfo['sub-titulo'], $content);
                $content = str_replace('@description', $pwaInfo['descricao'], $content);
                $content = str_replace('@web_base_dir', $pwaInfo['diretorio-base-web'], $content);
                $content = str_replace('@app-id', $pwaInfo['app-id'], $content);
                $content = str_replace('@app-prefix', $pwaInfo['app-id'].'_', $content);
                $content = str_replace('@cacheversion', $cacheVersion, $content);
                $content = str_replace('@pwa_ready', $pwaInfo['estado-pwa'], $content);
                $content = str_replace('@autoplay_audio', $pwaInfo['autoplay-audio'], $content);
                $content = str_replace('@autoplay_video', $pwaInfo['autoplay-video'], $content);
                $content = str_replace('@auto_fullscreen', $pwaInfo['auto-fullscreen'], $content);
                $content = str_replace('@home_back_timer', $pwaInfo['home-back-timer'], $content);
                

                if ($file === 'sw.js') {
                    $conteudoLines = $this->generateContentLines();
                    $content = str_replace('// @conteudos', implode("\n", $conteudoLines), $content);
                }

                file_put_contents($outputPath, $content);
            }
        }
       // Copiar arquivos para outros lugares na aplicação
    $destinations = [
        'settings.js' => PWA_DIR.'/assets/js',
        'conteudo.js' => PWA_DIR.'/assets/js',
        'manifest.json' => PWA_DIR,
        'sw.js' => PWA_DIR
    ];

    foreach ($templateFiles as $file) {
        $outputPath = $outputDir . DIRECTORY_SEPARATOR . $file;
        if (file_exists($outputPath)) {
            if (isset($destinations[$file])) {
                $destinationPath = $destinations[$file] . DIRECTORY_SEPARATOR . $file;
                if (!copy($outputPath, $destinationPath)) {
                    throw new Exception("Falha ao copiar $file para $destinationPath");
                }
            }
        }
    }

    return true;
    }

    public function listarConteudo($type = 'todos') {
        if (!file_exists($this->conteudoJsPath)) {
            return array();
        }

        $conteudoJs = file_get_contents($this->conteudoJsPath);
        $conteudos = array();

        $pattern = "/pwaFw.conteudo.adicionarFaixa\('([^']*)',\s*([^,]*),\s*([^,]*),\s*'([^']*)',\s*'([^']*)'\);/";
        preg_match_all($pattern, $conteudoJs, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $conteudo = array(
                'titulo' => $match[1],
                'imagem' => $match[2] !== 'null' ? trim($match[2], "'") : null,
                'descricao-da-imagem' => $match[3] !== 'null' ? trim($match[3], "'") : null,
                'arquivo' => $match[4],
                'tipo' => $match[5]
            );

            if ($type === 'todos' || $type === $conteudo['tipo']) {
                $conteudos[] = $conteudo;
            }
        }

        return $conteudos;
    }

    public function contarConteudo() {
        $conteudos = $this->listarConteudo();
        return count($conteudos);
    }

    private function generateContentLines() {
        $conteudos = $this->listarConteudo();
        $lines = []; 
        $revision = getCurrentSequenceNumber(SEQUENCIAL_FILE);
        foreach ($conteudos as $conteudo) {
            $filePath = 'storage/media/' . $conteudo['tipo'] . '/' . $conteudo['arquivo'];
            $line = "{ url: base_dir + '$filePath', revision: '" . $revision . "' },";
            $lines[] = $line;
        }

        return $lines;
    }

    public function removerConteudo($arquivo) {
        if (!file_exists($this->conteudoJsPath)) {
            return false;
        }

        $conteudoJs = file_get_contents($this->conteudoJsPath);
        $pattern = "/pwaFw\.conteudo\.adicionarFaixa\('([^']*)',\s*([^,]*),\s*([^,]*),\s*'$arquivo',\s*'([^']*)'\);/";
        $conteudoJs = preg_replace($pattern, '', $conteudoJs);

        if (file_put_contents($this->conteudoJsPath, $conteudoJs) === false) {
            return false;
        }

        $this->updateJSfiles();
        return true;
    }
}
?>
