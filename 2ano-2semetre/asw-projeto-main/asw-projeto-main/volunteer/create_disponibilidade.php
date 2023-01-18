<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__.'/../volunteer/disponibilidade_voluntario.php';
require_once __DIR__ . '/../volunteer/volunteer.php';

session_start();

$user = unserialize($_SESSION["user"]);

$id_voluntario = current($user);

$dia_semana = ($_POST["dia"]);
$horas_inicio = ($_POST["inicio"]);
$horas_fim = ($_POST["fim"]);


$result = array_merge_recursive(
    array_combine($dia_semana, $horas_inicio),
    array_combine($dia_semana, $horas_fim),
);

foreach($result as $dia => $horas){

    $disponibilidade = Disponibilidade_Voluntario::create($id_voluntario, $dia, intval($horas[0]), intval($horas[1]));
}

header("Location: /");