<?php

// Recupera as variáveis de ambiente definidas no .htaccess
$documentRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
$appDirectory = getenv('APP_DIRECTORY');
$cmsDirectory = getenv('CMS_DIRECTORY');

// Definir o caminho absoluto combinando o document root com o caminho relativo
$pwaDirectoryAbsolute = $documentRoot .$appDirectory;
$cmsDirectoryAbsolute = $documentRoot . $cmsDirectory;

// Define as constantes com base nas variáveis de ambiente
define('PWA_WEB_ROOT', 'https://' . $_SERVER['HTTP_HOST'] . $appDirectory);
define('PWA_WEB_BASE', $appDirectory);
define('PWA_WEB_STORAGE',PWA_WEB_BASE.'storage/');
define('PWA_CMS_WEB_ROOT', 'https://' . $_SERVER['HTTP_HOST'] . $cmsDirectory);

define('PWA_CMS_DIR', $cmsDirectoryAbsolute);


define('PWA_DIR', $pwaDirectoryAbsolute);
define('PWA_ASSETS', PWA_DIR . DIRECTORY_SEPARATOR . 'assets');
define('PWA_STORAGE', PWA_DIR . DIRECTORY_SEPARATOR . 'storage');
define('PWA_STORAGE_MEDIA', PWA_DIR . DIRECTORY_SEPARATOR . 'storage'. DIRECTORY_SEPARATOR .'media');
define('PWA_STORAGE_AUDIO', PWA_STORAGE . DIRECTORY_SEPARATOR .'media'. DIRECTORY_SEPARATOR . 'audio');
define('PWA_STORAGE_VIDEO', PWA_STORAGE . DIRECTORY_SEPARATOR .'media'. DIRECTORY_SEPARATOR . 'video');
define('PWA_STORAGE_TEXT', PWA_STORAGE . DIRECTORY_SEPARATOR .'media'. DIRECTORY_SEPARATOR . 'text');
define('PWA_STORAGE_IMAGES', PWA_STORAGE . DIRECTORY_SEPARATOR .'media'. DIRECTORY_SEPARATOR . 'image');
define('SEQUENCIAL_FILE',PWA_CMS_DIR. DIRECTORY_SEPARATOR .'libs'.DIRECTORY_SEPARATOR . 'sequencial.txt');


require 'Parsedown.php';
require 'class.pwaSettings.php';
require 'class.pwaContents.php';


//define('BASE_DIR', dirname(__DIR__,2));



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

function getNextSequenceNumber($filePath) {
    if (!file_exists($filePath)) {
        file_put_contents($filePath, 1);
        return 1;
    } else {
        $currentNumber = (int)file_get_contents($filePath);
        $nextNumber = $currentNumber + 1;
        file_put_contents($filePath, $nextNumber);
        return $nextNumber;
    }
}
function getCurrentSequenceNumber($filePath) {
    if (!file_exists($filePath)) {
        return 1; // Se o arquivo não existir, retorne 1 como o valor padrão
    } else {
        return (int)file_get_contents($filePath);
    }
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
/*
function getPwaInfo() {
    $jsonPath = PWA_DIR . DIRECTORY_SEPARATOR . 'cms' . DIRECTORY_SEPARATOR . 'projeto-pwa.json';
    $cmsDirectory = __DIR__;
    $sizeInBytes = calculateDirectorySize(PWA_DIR, $cmsDirectory);
    $formattedSize = formatSizeUnits($sizeInBytes);
    $appId = generateAppId(PWA_DIR);

    // Valores padrão (fallback)
    $defaultInfo = array(
        'app-id' => $appId,
        'titulo' => 'Meu PWA',
        'sub-titulo' => 'Um exemplo de Progressive Web App',
        'descricao' => 'Descrição desse maravilhoso projeto PWA',
        'estado-pwa' => 0,
        'diretorio-base' => PWA_DIR,
        'tamanho' => $formattedSize,
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
*/
/**
 * Obtém o caminho completo para um diretório dentro da estrutura de armazenamento.
 *
 * @param string $directory O subdiretório dentro de "media".
 * @return string O caminho completo.
 */
function getStoragePath($directory) {
    return PWA_DIR . DIRECTORY_SEPARATOR . "storage" . DIRECTORY_SEPARATOR . "media" . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR;
}

/**
 * Obtém o último segmento de um caminho de diretório.
 *
 * @param string $path O caminho completo do diretório.
 * @return string O último segmento do caminho.
 */
function getLastSegment($path) {
    return basename($path);
}
?>
