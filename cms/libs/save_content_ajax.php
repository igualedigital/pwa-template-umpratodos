<?php
require 'functions.php';

$pwaContents = new pwaContents();

$title = $_POST['title'];
$type = $_POST['type'];
$imageDescription = $_POST['imageDescription'] ?? null;
$imageFile = $_FILES['imageFile']['name'] ?? null;

$contentFile = null;

if ($type === 'text' && isset($_POST['content'])) {
    $content = $_POST['content'];
    $parsedown = new Parsedown();
    $htmlContent = $parsedown->text($content);
    $uuid = generateUUID();
    $markdownFileName = $uuid . ".md";
    $htmlFileName = $uuid . ".html";
    file_put_contents(PWA_STORAGE_TEXT . DIRECTORY_SEPARATOR . $markdownFileName, $content);
    file_put_contents(PWA_STORAGE_TEXT . DIRECTORY_SEPARATOR . $htmlFileName, $htmlContent);
    $contentFile = $htmlFileName;
} elseif ($type === 'audio' && isset($_FILES['contentFile']) && $_FILES['contentFile']['error'] == 0) {
    $contentFile = saveFile($_FILES['contentFile'], 'audio');
} elseif ($type === 'video' && isset($_FILES['contentFile']) && $_FILES['contentFile']['error'] == 0) {
    $contentFile = saveFile($_FILES['contentFile'], 'video');
}

if ($imageFile) {
    $imageFileName = uniqid() . '-' . basename($imageFile);
    $imageFilePath = PWA_STORAGE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $imageFileName;
    if (!move_uploaded_file($_FILES['imageFile']['tmp_name'], $imageFilePath)) {
        echo json_encode(['status' => 'error', 'message' => 'Falha ao mover o arquivo de imagem.']);
        exit();
    }
} else {
    $imageFileName = null;
}

try {
    $pwaContents->adicionarConteudo($title, $type, $imageDescription, $imageFileName, $contentFile);
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

function saveFile($file, $type) {
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

    return $fileName;
}

function generateUUID() {
    return bin2hex(random_bytes(16));
}
?>
