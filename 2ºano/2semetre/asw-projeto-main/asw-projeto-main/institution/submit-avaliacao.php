<?php
require_once __DIR__ . '/../institution/avaliacao.php';

$instId = htmlspecialchars($_POST['instId']);
$volId = htmlspecialchars($_POST['volId']);
$comentario = htmlspecialchars($_POST['comentario']);
$avaliacao = htmlspecialchars($_POST['avaliacao']);

AvaliacaoInstituicao::create($volId, $instId, $avaliacao, $comentario);
