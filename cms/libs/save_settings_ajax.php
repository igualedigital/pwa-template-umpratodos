<?php
require 'functions.php';

// Cria a instância de pwaContents primeiro
$pwaContents = new pwaContents();

// Cria a instância de pwaSettings passando a instância de pwaContents
$pwaSettings = new pwaSettings($pwaContents);

// Recupera os dados do POST
$titulo = $_POST['titulo'];
$subtitulo = $_POST['subtitulo'];
$descricao = $_POST['descricao'];
$estado = isset($_POST['estado']) ? 1 : 0;
$autoplay_audio = isset($_POST['autoplay-audio']) ? 1 : 0;
$autoplay_video = isset($_POST['autoplay-video']) ? 1 : 0;
$auto_fullscreen = isset($_POST['auto-fullscreen']) ? 1 : 0;
$home_back_timer = $_POST['home-back-timer'];

// Atualiza as configurações do PWA
$result = $pwaSettings->updatePwa($titulo, $subtitulo, $descricao, $estado, $autoplay_audio, $autoplay_video, $auto_fullscreen, $home_back_timer);

if ($result === 'success') {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar as configurações.']);
}
?>
