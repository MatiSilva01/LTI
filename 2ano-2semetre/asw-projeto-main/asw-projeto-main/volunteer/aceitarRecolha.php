
<?php
require_once __DIR__ . '/../institution/institution.php';
$id_voluntario = htmlspecialchars($_REQUEST["id_voluntario"]);
$id_instituicao = htmlspecialchars($_REQUEST["id_instituicao"]);;

if ($id_voluntario) {
    $instits = Instituicao::aceitaRecolha($id_voluntario, $id_instituicao);
    //echo($instits);
}

header("Content-Type: application/json");
echo json_encode(["instituicoes" => $instits], JSON_INVALID_UTF8_IGNORE);
?>



