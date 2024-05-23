<?php
require 'functions.php';

$pwaContents = new pwaContents();

$title = $_POST['title'];
$type = $_POST['type'];
$imageDescription = $_POST['image_description'] ?? null;
$imageFile = $_FILES['imageFile']['name'] ?? null;
$contentFile = $_FILES['contentFile']['name'] ?? null;



try {
    $pwaContents->adicionarConteudo($title, $type, $imageDescription, $imageFile, $contentFile);
    header('Location: ../');
    exit();
} catch (Exception $e) {
    // Lidar com erro de upload de arquivo
    echo "Erro: " . $e->getMessage();
};

?>
