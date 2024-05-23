<?php
require 'functions.php';

/**
 * Salva os dados do formulário enviados.
 */
function saveContent() {
    // Dados do formulário
    $title = $_POST['title'];
    $type = $_POST['type'];
    $imageDescription = isset($_POST['image_description']) ? $_POST['image_description'] : null;
    $contentFile = null;
    $imageFile = null;

    // Processar upload de imagem
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageFile = saveFile($_FILES['image'], 'image');
    }

    // Processar upload de conteúdo
    if ($type === 'text' && isset($_POST['content'])) {
        $content = $_POST['content'];
        $parsedown = new Parsedown();
        $htmlContent = $parsedown->text($content);
        $uuid = generateUUID();
        $markdownFileName = $uuid . ".md";
        $htmlFileName = $uuid . ".html";
        file_put_contents(getStoragePath('text').$markdownFileName, $content);
        file_put_contents(getStoragePath('text').$htmlFileName, $htmlContent);
        $contentFile = $htmlFileName;
    } elseif ($type === 'audio' && isset($_FILES['audio']) && $_FILES['audio']['error'] == 0) {
        $contentFile = saveFile($_FILES['audio'], 'audio');
    } elseif ($type === 'video' && isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $contentFile = saveFile($_FILES['video'], 'video');
    }

    // Atualizar o arquivo conteudo.js
    $conteudoJsPath = BASE_DIR . DIRECTORY_SEPARATOR . 'cms' . DIRECTORY_SEPARATOR . 'outputs' . DIRECTORY_SEPARATOR . 'conteudo.js';


    // Verifica se o arquivo conteudo.js existe, se não, cria com conteúdo inicial
    if (!file_exists($conteudoJsPath)) {
    $conteudoJs = "pwaFw.conteudo = pwaFw.conteudo || {};\n\n";
    $conteudoJs .= "pwaFw.conteudo = new ColecaoFaixas();\n\n";
    } else {
    $conteudoJs = file_get_contents($conteudoJsPath);
    }

    $newContent = "pwaFw.conteudo.adicionarFaixa('$title', " . ($imageFile ? "'$imageFile'" : "null") . ", " . ($imageDescription ? "'$imageDescription'" : "null") . ", '$contentFile', '$type');\n";
    $conteudoJs .= $newContent;


    file_put_contents($conteudoJsPath, $conteudoJs);

    // Redirecionar de volta para a página principal
    header('Location: index.php');
    exit;
}

function saveFile($file, $directory) {
    $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $uuid = generateUUID();
    $newFileName = $uuid . '.' . $extension;
    $targetDir = getStoragePath($directory);
    $targetFile = $targetDir . $newFileName;
    move_uploaded_file($file["tmp_name"], $targetFile);
    return $newFileName;
}

// Gera um UUID v4
function generateUUID() {
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // versão 4
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // variante 10xx
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

// Executa a função de salvamento
saveContent();
?>
