<?php
require_once __DIR__ . '/../institution/institution.php';

$values = [
    "nome" => isset($_POST["nomeInstituicao"]) ? htmlspecialchars($_POST["nomeInstituicao"]) : null,
    "email" => isset($_POST["emailInstituicao"]) ? htmlspecialchars($_POST["emailInstituicao"]) : null,
    "foto" => $_FILES["fotoInstituicao"]['tmp_name'] ? file_get_contents($_FILES["fotoInstituicao"]['tmp_name']) : null,
    "descricao" => isset($_POST["descricaoInstituicao"]) ? htmlspecialchars($_POST["descricaoInstituicao"]) : null,
    "telefone" => isset($_POST["telefoneInstituicao"]) ? htmlspecialchars($_POST["telefoneInstituicao"]) : null,
    "contacto" => isset($_POST["nomeContactoInstituicao"]) ? htmlspecialchars($_POST["nomeContactoInstituicao"]) : null,
    "telefone_contacto" => isset($_POST["telefoneContactoInstituicao"]) ? htmlspecialchars($_POST["telefoneContactoInstituicao"]) : null,
    "tipo" => isset($_POST["tipoInstituicao"]) ? htmlspecialchars($_POST["tipoInstituicao"]) : null,
    "distrito" => isset($_POST["distritoInstituicao"]) ? htmlspecialchars($_POST["distritoInstituicao"]) : null,
    "concelho" => isset($_POST["concelhoInstituicao"]) ? htmlspecialchars($_POST["concelhoInstituicao"]) : null,
    "freguesia" => isset($_POST["freguesiaInstituicao"]) ? htmlspecialchars($_POST["freguesiaInstituicao"]) : null,
    "morada" => isset($_POST["moradaInstituicao"]) ? htmlspecialchars($_POST["moradaInstituicao"]) : null,
    "latitude" => isset($_POST["latitudeInstituicao"]) ? htmlspecialchars($_POST["latitudeInstituicao"]) : null,
    "longitude" => isset($_POST["longitudeInstituicao"]) ? htmlspecialchars($_POST["longitudeInstituicao"]) : null
];

session_start();
$user = unserialize($_SESSION["user"]);
if (!($user instanceof Instituicao)) {
    header("Location: /user/profile.php");
} else {
    $user = $user->update($values);

    $_SESSION["user"] = serialize($user);
    header('Location: /user/profile.php');
}
