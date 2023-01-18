<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
require_once __DIR__ . '/../institution/institution.php';
$id_voluntario = htmlspecialchars($_REQUEST["id_voluntario"]);
$id_instituicao = htmlspecialchars($_REQUEST["id_instituicao"]);;

if ($id_voluntario) {
    $instits = Instituicao::pedidoRecolha($id_voluntario, $id_instituicao);
    //echo($instits);
}

header("Content-Type: application/json");
echo json_encode(["instituicoes" => $instits], JSON_INVALID_UTF8_IGNORE);
?>

