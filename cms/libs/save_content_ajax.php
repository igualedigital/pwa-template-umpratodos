<?php
require 'functions.php';

// Cria a instância de pwaContents sem passar pwaSettings
$pwaContents = new pwaContents();

// Cria a instância de pwaSettings e passa pwaContents para ele
$pwaSettings = new pwaSettings($pwaContents);

// Define pwaSettings dentro de pwaContents
$pwaContents->setPwaSettings($pwaSettings);

$title = $_POST['title'];
$type = $_POST['type'];
$imageDescription = $_POST['imageDescription'] ?? null;
$imageFile = $_FILES['imageFile']['name'] ?? null;

$contentData = null;
if ($type === 'text' && isset($_POST['content'])) {
    $contentData = $_POST['content'];
} elseif (($type === 'audio' || $type === 'video') && isset($_FILES['contentFile']) && $_FILES['contentFile']['error'] == 0) {
    $contentData = $_FILES['contentFile'];
}

$result = $pwaContents->adicionarConteudo($title, $type, $imageDescription, $imageFile, $contentData);


if ($result['status'] === 'success') {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $result['message']]);
}


?>
