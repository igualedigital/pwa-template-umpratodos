<?php

define('BASE_DIR', dirname(__DIR__));

require 'libs/Parsedown.php';

/**
 * Calcula o tamanho de um diretório, excluindo um subdiretório específico.
 *
 * @param string $directory O caminho do diretório.
 * @param string $excludeDirectory O subdiretório a ser excluído.
 * @return int O tamanho do diretório em bytes.
 */
function calculateDirectorySize($directory, $excludeDirectory) {
    $size = 0;
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS));

    foreach ($files as $file) {
        if (strpos($file->getPathname(), $excludeDirectory) === false) {
            $size += $file->getSize();
        }
    }

    return $size;
}

/**
 * Formata o tamanho de bytes para uma string legível.
 *
 * @param int $bytes O tamanho em bytes.
 * @return string O tamanho formatado em KB, MB ou GB.
 */
function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) {
        $size = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $size = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $size = number_format($bytes / 1024, 2) . ' KB';
    } else {
        $size = $bytes . ' bytes';
    }

    return $size;
}

/**
 * Gera um hash baseado na string do diretório base.
 *
 * @param string $directory O caminho do diretório.
 * @return string O hash gerado.
 */
function generateAppId($directory) {
    return md5($directory);
}

/**
 * Obtém informações principais do PWA.
 *
 * @return array As informações do PWA.
 */
function getPwaInfo() {
    $jsonPath = BASE_DIR . DIRECTORY_SEPARATOR . 'cms' . DIRECTORY_SEPARATOR . 'projeto-pwa.json';
    $cmsDirectory = __DIR__;
    $sizeInBytes = calculateDirectorySize(BASE_DIR, $cmsDirectory);
    $formattedSize = formatSizeUnits($sizeInBytes);
    $appId = generateAppId(BASE_DIR);

    // Valores padrão (fallback)
    $defaultInfo = array(
        'app-id' => $appId,
        'titulo' => 'Novo PWA',
        'sub-titulo' => 'Este é um novo projeto',
        'descricao' => 'Clique em configurações e ajuste as informações',
        'estado-pwa' => 0,
        'diretorio-base' => BASE_DIR,
        'tamanho' => $formattedSize,
        'conteudo' => array()
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
/**
 * Obtém o caminho completo para um diretório dentro da estrutura de armazenamento.
 *
 * @param string $directory O subdiretório dentro de "media".
 * @return string O caminho completo.
 */
function getStoragePath($directory) {
    return BASE_DIR . DIRECTORY_SEPARATOR . "storage" . DIRECTORY_SEPARATOR . "media" . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR;
};

/**
 * Obtém o último segmento de um caminho de diretório.
 *
 * @param string $path O caminho completo do diretório.
 * @return string O último segmento do caminho.
 */
function getLastSegment($path) {
    return basename($path);
};

/**
 * Lê o conteúdo do arquivo conteudo.js e retorna um array com os conteúdos.
 *
 * @param string $type O tipo de conteúdo a ser filtrado (todos, video, audio, text).
 * @return array A lista de conteúdos.
 */
function lerConteudo($type = 'todos') {
    $conteudoJsPath = BASE_DIR . DIRECTORY_SEPARATOR . 'cms' . DIRECTORY_SEPARATOR . 'outputs' . DIRECTORY_SEPARATOR . 'conteudo.js';
    
    if (!file_exists($conteudoJsPath)) {
        return array();
    }

    $conteudoJs = file_get_contents($conteudoJsPath);
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
};

?>
