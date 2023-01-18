<?php
require_once __DIR__ . '/../volunteer/avaliacao.php';

$instId = htmlspecialchars($_POST['instId']);
$volId = htmlspecialchars($_POST['volId']);
$comentario = htmlspecialchars($_POST['comentario']);
$avaliacao = htmlspecialchars($_POST['avaliacao']);

AvaliacaoVoluntario::create($volId, $instId, $avaliacao, $comentario);
