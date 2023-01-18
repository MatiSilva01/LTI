<?php
require_once __DIR__ . '/../../institution/institution.php';

$wheres = [];
$q = htmlspecialchars($_REQUEST["q"]);
$distrito = htmlspecialchars($_REQUEST["distrito"]);
$concelho = htmlspecialchars($_REQUEST["concelho"]);
$dia_semana = htmlspecialchars($_REQUEST["dia_semana"]);
$horas_inicio = htmlspecialchars($_REQUEST["horas_inicio"]);
$horas_fim = htmlspecialchars($_REQUEST["horas_fim"]);

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
    $join = "INNER JOIN DisponibilidadeDoacao ON DisponibilidadeDoacao.id_instituicao = Instituicao.id";
}

if ($horas_inicio) {
    $wheres["horas_inicio <="] = $horas_inicio;
    $join = "INNER JOIN DisponibilidadeDoacao ON DisponibilidadeDoacao.id_instituicao = Instituicao.id";
}

if ($horas_fim) {
    $wheres["horas_fim >="] = $horas_fim;
    $join = "INNER JOIN DisponibilidadeDoacao ON DisponibilidadeDoacao.id_instituicao = Instituicao.id";
}

$instits = iterator_to_array(Instituicao::findAll($wheres, "nome", $join));

header("Content-Type: application/json");
echo json_encode(["instituicoes" => $instits], JSON_INVALID_UTF8_IGNORE);
