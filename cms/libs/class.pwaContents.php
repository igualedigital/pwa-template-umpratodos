<?php

class pwaContents {
    private $conteudoJsPath;
    
    public function __construct() {
        $this->conteudoJsPath = PWA_DIR . DIRECTORY_SEPARATOR . 'cms' . DIRECTORY_SEPARATOR . 'outputs' . DIRECTORY_SEPARATOR . 'conteudo.js';

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

    public function adicionarConteudo($title, $type, $imageDescription, $imageFile, $contentFile) {
        // Renomear arquivos para nomes únicos
        $imageFileName = $imageFile ? uniqid() . '-' . basename($imageFile) : null;

        // Processar upload de arquivos de imagem
        if ($imageFile && isset($_FILES['imageFile']) && $_FILES['imageFile']['error'] == 0) {
            $imageFilePath = PWA_STORAGE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $imageFileName;
            if (!move_uploaded_file($_FILES['imageFile']['tmp_name'], $imageFilePath)) {
                throw new Exception('Falha ao mover o arquivo de imagem.');
            }
        } else {
            $imageFileName = null;
        }

        // Processar upload de arquivos de conteúdo
        if ($contentFile && isset($_FILES['contentFile']) && $_FILES['contentFile']['error'] == 0) {
            $contentFileName = uniqid() . '-' . basename($contentFile);
            $contentFilePath = '';
            switch ($type) {
                case 'audio':
                    $contentFilePath = PWA_STORAGE_AUDIO . DIRECTORY_SEPARATOR . $contentFileName;
                    break;
                case 'video':
                    $contentFilePath = PWA_STORAGE_VIDEO . DIRECTORY_SEPARATOR . $contentFileName;
                    break;
                case 'text':
                    $contentFilePath = PWA_STORAGE_TEXT . DIRECTORY_SEPARATOR . $contentFileName;
                    break;
                default:
                    throw new Exception('Tipo de conteúdo inválido.');
            }
            if (!move_uploaded_file($_FILES['contentFile']['tmp_name'], $contentFilePath)) {
                throw new Exception('Falha ao mover o arquivo de conteúdo.');
            }
        } elseif ($type === 'text') {
            // Caso especial para tipo texto, onde $contentFile já é o nome do arquivo HTML gerado anteriormente
            $contentFileName = $contentFile;
        } else {
            $contentFileName = null;
        }

        // Atualizar o arquivo conteudo.js
        $conteudoJs = file_get_contents($this->conteudoJsPath);
        $newContent = "pwaFw.conteudo.adicionarFaixa('$title', " . ($imageFileName ? "'$imageFileName'" : "null") . ", " . ($imageDescription ? "'$imageDescription'" : "null") . ", '$contentFileName', '$type');\n";
        $conteudoJs .= $newContent;
        file_put_contents($this->conteudoJsPath, $conteudoJs);
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

    public function removerConteudo($arquivo) {
        if (!file_exists($this->conteudoJsPath)) {
            return false;
        }

        $conteudoJs = file_get_contents($this->conteudoJsPath);
        $pattern = "/pwaFw.conteudo.adicionarFaixa\('([^']*)',\s*([^,]*),\s*([^,]*),\s*'$arquivo',\s*'([^']*)'\);\n/";
        $conteudoJs = preg_replace($pattern, '', $conteudoJs);
        file_put_contents($this->conteudoJsPath, $conteudoJs);

        return true;
    }
}
?>
