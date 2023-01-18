<?php
require_once __DIR__ . '/../../volunteer/volunteer.php';
require_once __DIR__ . '/../../institution/institution.php';


$wheres = [];
$q = htmlspecialchars($_REQUEST["q"]);
$ageMin = htmlspecialchars($_REQUEST["ageMin"]);
$ageMax = htmlspecialchars($_REQUEST["ageMax"]);
$distrito = htmlspecialchars($_REQUEST["distrito"]);
$concelho = htmlspecialchars($_REQUEST["concelho"]);
$volId = htmlspecialchars($_REQUEST["vid"]);
$instId = htmlspecialchars($_REQUEST["iid"]);

if ($q) {
    $qlower = strtolower($q);
    $wheres["LOWER(nome) LIKE"] = "%$qlower%";
}

if ($instId && $ageMin) {
    $wheres["TIMESTAMPDIFF(YEAR,data_nascimento,CURDATE()) >="] = $ageMin;
}

if ($instId && $ageMax) {
    $wheres["TIMESTAMPDIFF(YEAR,data_nascimento,CURDATE()) <="] = $ageMax;
}

if ($distrito) {
    $wheres["distrito ="] = $distrito;
}

if ($concelho) {
    $wheres["concelho ="] = $concelho;
}

$matches = [];
if ($volId) {
    $matches = iterator_to_array(Instituicao::findMatches($volId, $wheres, "nome"));
} else if ($instId) {
    $matches = iterator_to_array(Voluntario::findMatches($instId, $wheres, "nome"));
}

header("Content-Type: application/json");
echo json_encode(["matches" => $matches], JSON_INVALID_UTF8_IGNORE);
