<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__.'/../volunteer/volunteer.php';

$passwd = htmlspecialchars($_POST["passwordVoluntario"]);
$confirmPasswd = htmlspecialchars($_POST["confirmPasswordVoluntario"]);
if ($passwd != $confirmPasswd) {
    header("Location: /auth.php");
    return;
}

$nome = htmlspecialchars($_POST["nomeVoluntario"]);
$email = htmlspecialchars($_POST["emailVoluntario"]);
$foto = file_get_contents($_FILES["fotoVoluntario"]['tmp_name']);
$telefone = htmlspecialchars($_POST["telefoneVoluntario"]);
$data_nascimento = htmlspecialchars($_POST["dataNascimentoVoluntario"]);
$genero = htmlspecialchars($_POST["generoVoluntario"]);
$cartao_cidadao = htmlspecialchars($_POST["cartaoCidadaoVoluntario"]);
$carta_conducao = htmlspecialchars($_POST["cartaConducaoVoluntario"]);
$distrito = htmlspecialchars($_POST["distritoVoluntario"]);
$concelho = htmlspecialchars($_POST["concelhoVoluntario"]);
$freguesia = htmlspecialchars($_POST["freguesiaVoluntario"]);
$latitude = htmlspecialchars($_POST["latitudeVoluntario"]);
$longitude = htmlspecialchars($_POST["longitudeVoluntario"]);

$voluntario = Voluntario::create($nome, $email, password_hash($passwd, PASSWORD_BCRYPT), $foto, $telefone, $data_nascimento, $genero, $cartao_cidadao, $carta_conducao, $distrito, $concelho, $freguesia, $latitude, $longitude);

session_start();
$_SESSION["user"] = serialize($voluntario);

header("Location: /");