<?php
header("Content-Type: text/html;charset=utf-8");
require_once __DIR__.'/../volunteer/volunteer.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$values = [
    "nome" => isset($_POST["nomeVoluntario"]) ? htmlspecialchars($_POST["nomeVoluntario"]) : null,
    "email" => isset($_POST["emailVoluntario"]) ? htmlspecialchars($_POST["emailVoluntario"]) : null,
    "foto" => $_FILES["fotoVoluntario"]['tmp_name'] ? file_get_contents($_FILES["fotoVoluntario"]['tmp_name']) : null,
    "telefone" => isset($_POST["telefoneVoluntario"]) ? htmlspecialchars($_POST["telefoneVoluntario"]) : null,
    "data_nascimento" => isset($_POST["dataNascimentoVoluntario"]) ? htmlspecialchars($_POST["dataNascimentoVoluntario"]) : null,
    "genero" => isset($_POST["generoVoluntario"]) ? htmlspecialchars($_POST["generoVoluntario"]) : null,
    "cartao_cidadao" => isset($_POST["cartaoCidadaoVoluntario"]) ? htmlspecialchars($_POST["cartaoCidadaoVoluntario"]) : null,
    "carta_conducao" => isset($_POST["cartaConducaoVoluntario"]) ? htmlspecialchars($_POST["cartaConducaoVoluntario"]) : null,
    "distrito" => isset($_POST["distritoVoluntario"]) ? htmlspecialchars($_POST["distritoVoluntario"]) : null,
    "concelho" => isset($_POST["concelhoVoluntario"]) ? htmlspecialchars($_POST["concelhoVoluntario"]) : null,
    "freguesia" => isset($_POST["freguesiaVoluntario"]) ? htmlspecialchars($_POST["freguesiaVoluntario"]) : null,
    "latitude" => isset($_POST["latitudeVoluntario"]) ? htmlspecialchars($_POST["latitudeVoluntario"]) : null,
    "longitude" => isset($_POST["longitudeVoluntario"]) ? htmlspecialchars($_POST["longitudeVoluntario"]) : null
];

session_start();
$user = unserialize($_SESSION["user"]);
if (!($user instanceof Voluntario)) {
    header("Location: /user/profile.php");
} else {
    $user = $user->update($values);

    $_SESSION["user"] = serialize($user);
    header('Location: /user/profile.php');
}


