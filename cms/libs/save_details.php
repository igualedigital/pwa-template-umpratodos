<?php
require 'functions.php';

$pwaSettings = new pwaSettings();

$titulo = $_POST['titulo'];
$subtitulo = $_POST['subtitulo'];
$descricao = $_POST['descricao'];
$estado = $_POST['estado'];

echo $pwaSettings->updatePwa($titulo, $subtitulo, $descricao, $estado);
?>
