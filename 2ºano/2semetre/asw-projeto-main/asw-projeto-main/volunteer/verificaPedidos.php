<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

require_once __DIR__ . '/../institution/institution.php';
$id_instituicao = $_REQUEST["id_instituicao"];

if ($id_instituicao) {
   $instits = Pedidos::verificaPedido($id_instituicao);
   //echo($instits);
    
}

header("Content-Type: application/json");
echo json_encode(["aceite" => $instits], JSON_INVALID_UTF8_IGNORE);
