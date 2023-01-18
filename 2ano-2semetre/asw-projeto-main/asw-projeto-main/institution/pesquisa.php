<?php
require_once __DIR__ . '/../volunteer/volunteer.php';

$wheres = [];
$q = htmlspecialchars($_REQUEST["q"]);
$distrito = htmlspecialchars($_REQUEST["distrito"]);
$concelho = htmlspecialchars($_REQUEST["concelho"]);
$dia_semana = in_array("dia_semana", $_REQUEST) ? htmlspecialchars($_REQUEST["dia_semana"]) : null;
$horas_inicio = in_array("horas_inicio", $_REQUEST) ? htmlspecialchars($_REQUEST["horas_inicio"]) : null;
$horas_fim = in_array("horas_fim", $_REQUEST) ? htmlspecialchars($_REQUEST["horas_fim"]) : null;
$id_instituicao = htmlspecialchars($_REQUEST["id_instituicao"]);


if ($q) {
    $qlower = strtolower($q);
    $wheres = ["LOWER(nome) LIKE" => "%$qlower%"];
}

if ($distrito) {
    $wheres["distrito ="] = $distrito;
}

if ($concelho) {
    $wheres["concelho ="] = $concelho;
}

$join = null;
if ($dia_semana) {
    $wheres["dia_semana ="] = $dia_semana;
    $join = "INNER JOIN DisponibilidadeRecolha ON DisponibilidadeRecolha.id_voluntario = Voluntario.id";
}

if ($horas_inicio) {
    $wheres["horas_inicio <="] = $horas_inicio;
    $join = "INNER JOIN DisponibilidadeRecolha ON DisponibilidadeRecolha.id_voluntario = Voluntario.id";
}

if ($horas_fim) {
    $wheres["horas_fim >="] = $horas_fim;
    $join = "INNER JOIN DisponibilidadeRecolha ON DisponibilidadeRecolha.id_voluntario = Voluntario.id";
}

if ($id_instituicao) {
    $instits = iterator_to_array(Voluntario::findMatches($id_instituicao, $wheres, "nome", $join));
}
header("Content-Type: application/json");
echo json_encode(["voluntarios" => $instits], JSON_INVALID_UTF8_IGNORE);

?>