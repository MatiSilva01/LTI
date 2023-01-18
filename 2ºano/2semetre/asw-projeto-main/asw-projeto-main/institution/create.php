<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__.'/../institution/institution.php';

$passwd = htmlspecialchars($_POST["passwordInstituicao"]);
$confirmPasswd = htmlspecialchars($_POST["confirmPasswordInstituicao"]);
if ($passwd != $confirmPasswd) {
    header("Location: /auth.php");
    return;
}

$nome = htmlspecialchars($_POST["nomeInstituicao"]);
$email = htmlspecialchars($_POST["emailInstituicao"]);
$foto = file_get_contents($_FILES["fotoInstituicao"]['tmp_name']);
$telefone = htmlspecialchars($_POST["telefoneInstituicao"]);
$descricao = htmlspecialchars($_POST["descricaoInstituicao"]);
$contacto = htmlspecialchars($_POST["nomeContactoInstituicao"]);
$telefone_contacto = htmlspecialchars($_POST["telefoneContactoInstituicao"]);
$tipo = htmlspecialchars($_POST["tipoInstituicao"]);
$distrito = htmlspecialchars($_POST["distritoInstituicao"]);
$concelho = htmlspecialchars($_POST["concelhoInstituicao"]);
$freguesia = htmlspecialchars($_POST["freguesiaInstituicao"]);
$morada = htmlspecialchars($_POST["moradaInstituicao"]);
$latitude = htmlspecialchars($_POST["latitudeInstituicao"]);
$longitude = htmlspecialchars($_POST["longitudeInstituicao"]);

$instituicao = Instituicao::create($nome, $email, password_hash($passwd, PASSWORD_BCRYPT), $foto, $telefone, $descricao, $contacto, $telefone_contacto, $tipo, $distrito, $concelho, $freguesia, $morada, $latitude, $longitude);
session_start();
$_SESSION["user"] = serialize($instituicao);

header("Location: /");