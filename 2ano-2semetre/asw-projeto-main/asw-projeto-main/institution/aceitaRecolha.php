<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//echo ('ola!!!!!');
require_once __DIR__ . '/../institution/institution.php';
$id_voluntario = htmlspecialchars($_REQUEST["id_voluntario"]);
$id_instituicao = htmlspecialchars($_REQUEST["id_instituicao"]);
//echo $id_instituicao;
//echo $id_voluntario;
if ($id_voluntario) {
    $instits = Instituicao::aceitaRecolha($id_voluntario, $id_instituicao);
}

header("Content-Type: application/json");
echo json_encode(["pedidos" => $instits], JSON_INVALID_UTF8_IGNORE);

?>

