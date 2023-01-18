<?php
require_once __DIR__ . '/../../volunteer/volunteer.php';


$wheres = [];
$q = htmlspecialchars($_REQUEST["q"]);
$ageMin = htmlspecialchars($_REQUEST["ageMin"]);
$ageMax = htmlspecialchars($_REQUEST["ageMax"]);
$distrito = htmlspecialchars($_REQUEST["distrito"]);
$concelho = htmlspecialchars($_REQUEST["concelho"]);
$dia_semana = htmlspecialchars($_REQUEST["diaSemana"]);
$horas_inicio = htmlspecialchars($_REQUEST["horas_inicio"]);
$horas_fim = htmlspecialchars($_REQUEST["horas_fim"]);


if ($q) {
    $qlower = strtolower($q);
    $wheres["LOWER(nome) LIKE"] = "%$qlower%";
}

if ($ageMin) {
    $wheres["TIMESTAMPDIFF(YEAR,data_nascimento,CURDATE()) >="] = $ageMin;
}

if ($ageMax) {
    $wheres["TIMESTAMPDIFF(YEAR,data_nascimento,CURDATE()) <="] = $ageMax;
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

$vols = iterator_to_array(Voluntario::findAll($wheres, "nome", $join));

header("Content-Type: application/json");
echo json_encode(["voluntarios" => $vols], JSON_INVALID_UTF8_IGNORE);
