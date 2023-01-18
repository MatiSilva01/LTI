<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
//echo ('ola mostrar');
require_once __DIR__ . '/../institution/institution.php';
$id_instituicao = htmlspecialchars($_REQUEST["id_instituicao"]);
//echo $id_instituicao;

if ($id_instituicao) {
    $instits = iterator_to_array(Pedidos::mostraTodos($id_instituicao));
    //echo($instits);
}

header("Content-Type: application/json");
echo json_encode(["pedidos" => $instits], JSON_INVALID_UTF8_IGNORE);

?>

