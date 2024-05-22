<?php

require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $subtitulo = $_POST['subtitulo'];
    $descricao = $_POST['descricao'];
    $estado = $_POST['estado'];

    $cmsDirectory = __DIR__;
    $sizeInBytes = calculateDirectorySize(BASE_DIR, $cmsDirectory);
    $formattedSize = formatSizeUnits($sizeInBytes);
    $appId = generateAppId(BASE_DIR);

    $data = array(
        'app-id' => $appId,
        'titulo' => $titulo,
        'subt-titulo' => $subtitulo,
        'descricao' => $descricao,
        'estado-pwa' => $estado,
        'diretorio-base' => BASE_DIR,
        'tamanho' => $formattedSize,
        'conteudo' => array(
            array( )
        )
    );

    $json_data = json_encode($data, JSON_PRETTY_PRINT | JSON_NUMERIC_CHECK);
    

    $file_path = __DIR__ . DIRECTORY_SEPARATOR . 'outputs'.DIRECTORY_SEPARATOR.'projeto-pwa.json';

    if (file_put_contents($file_path, $json_data)) {
        echo 'success';
    } else {
        http_response_code(500);
        echo 'error';
    }
} else {
    http_response_code(405);
    echo 'Método não permitido';
}
?>
