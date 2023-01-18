<?php
require_once __DIR__ . '/../institution/institution.php';

$wheres = [];
$q = htmlspecialchars($_REQUEST["q"]);
$distrito = htmlspecialchars($_REQUEST["distrito"]);
$concelho = htmlspecialchars($_REQUEST["concelho"]);
$dia_semana = in_array("dia_semana", $_REQUEST) ? htmlspecialchars($_REQUEST["dia_semana"]) : null;
$horas_inicio = in_array("horas_inicio", $_REQUEST) ? htmlspecialchars($_REQUEST["horas_inicio"]) : null;
$horas_fim = in_array("horas_fim", $_REQUEST) ? htmlspecialchars($_REQUEST["horas_fim"]) : null;
$id_voluntario = htmlspecialchars($_REQUEST["id_voluntario"]);
$tipo_instituicao = htmlspecialchars($_REQUEST['tipo_instituicao']);
$tipo_doacao = htmlspecialchars(($_REQUEST['tipo_doacao']));


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

if ($tipo_instituicao) {
    $wheres["tipo ="] = $tipo_instituicao;
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

if ($tipo_doacao) {
    $wheres["tipo_doacao ="] = $tipo_doacao;
    $join = "INNER JOIN DoacaoAlimento ON DoacaoAlimento.id_instituicao = Instituicao.id";
}

if ($id_voluntario) {
    $instits = iterator_to_array(Instituicao::findMatches($id_voluntario, $wheres, "nome", $join));
}

header("Content-Type: application/json");
echo json_encode(["instituicoes" => $instits], JSON_INVALID_UTF8_IGNORE);
