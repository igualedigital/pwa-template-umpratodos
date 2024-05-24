<?php

    // Métodos e propriedades existentes
    class pwaContents {
        private $conteudoJsPath;
        private $pwaSettings;
    
        public function __construct() {
            $this->conteudoJsPath = PWA_DIR . DIRECTORY_SEPARATOR . 'cms' . DIRECTORY_SEPARATOR . 'outputs' . DIRECTORY_SEPARATOR . 'conteudo.js';
            $this->pwaSettings = new pwaSettings();
    
            // Verifica se o diretório 'outputs' existe, se não, cria o diretório
            $outputDir = dirname($this->conteudoJsPath);
            if (!is_dir($outputDir)) {
                mkdir($outputDir, 0755, true);
            }
    
            // Verifica se o arquivo conteudo.js existe, se não, cria com conteúdo inicial
            if (!file_exists($this->conteudoJsPath)) {
                $conteudoJs = "pwaFw.conteudo = pwaFw.conteudo || {};\n\n";
                $conteudoJs .= "pwaFw.conteudo = new ColecaoFaixas();\n\n";
                file_put_contents($this->conteudoJsPath, $conteudoJs);
            }
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
    
                // Verificar se o arquivo conteudo.js existe antes de tentar lê-lo
                if (!file_exists($this->conteudoJsPath)) {
                    throw new Exception('O arquivo conteudo.js não existe: ' . $this->conteudoJsPath);
                }
    
                // Verificar se o caminho é legível
                if (!is_readable($this->conteudoJsPath)) {
                    throw new Exception('O arquivo conteudo.js não é legível: ' . $this->conteudoJsPath);
                }
    
                // Ler o conteúdo do arquivo conteudo.js
                $conteudoJs = file_get_contents($this->conteudoJsPath);
                if ($conteudoJs === false) {
                    throw new Exception('Falha ao ler o arquivo conteudo.js: ' . $this->conteudoJsPath);
                }
    
                $newContent = "pwaFw.conteudo.adicionarFaixa('$title', " . ($imageFileName ? "'$imageFileName'" : "null") . ", " . ($imageDescription ? "'$imageDescription'" : "null") . ", '" . basename($contentFilePath) . "', '$type');\n";
                $conteudoJs .= $newContent;
                file_put_contents($this->conteudoJsPath, $conteudoJs);
    
                return ['status' => 'success'];
            } catch (Exception $e) {
                error_log('Erro ao adicionar conteúdo: ' . $e->getMessage());
                return ['status' => 'error', 'message' => $e->getMessage()];
            }
        }
    
        // Outros métodos da classe pwaContents...
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
        
    }
    


?>
