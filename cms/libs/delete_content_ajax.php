<?php
require 'functions.php';

// Cria a instância de pwaContents sem passar pwaSettings
$pwaContents = new pwaContents();

// Cria a instância de pwaSettings e passa pwaContents para ele
$pwaSettings = new pwaSettings($pwaContents);

// Define pwaSettings dentro de pwaContents
$pwaContents->setPwaSettings($pwaSettings);

$arquivo = $_POST['arquivo'] ?? '';

if (empty($arquivo)) {
    echo json_encode(['status' => 'error', 'message' => 'Arquivo não especificado.']);
    exit();
}

try {
    $result = $pwaContents->removerConteudo($arquivo);
    if ($result) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao remover conteúdo.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erro: ' . $e->getMessage()]);
}
?>