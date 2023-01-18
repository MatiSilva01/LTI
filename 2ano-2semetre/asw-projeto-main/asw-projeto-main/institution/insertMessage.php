<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../institution/institution.php';
require_once __DIR__ . '/../volunteer/volunteer.php';
require_once __DIR__ . '/../volunteer/mensagemVolu.php';

session_start();

$user = unserialize($_SESSION["user"]);

date_default_timezone_set("Europe/Lisbon");

if (isset($_POST["mensagem"]) &&
    isset($_POST["idVol"]))

    $msg = $_POST["mensagem"]; //txt de mensagem
    $idVol = $_POST["idVol"];
    $idInst = $user->id;
    $volCheck = 0; //se foi o voluntario a mandar mensagem
    $aberto = 0; //todas as mensagens q sao criadas ainda n foram abertas

$newmsg = MensagemVoluntario::addChat($idInst, $msg, $volCheck, $idVol, $aberto);

// echo(date("d-M-Y, H:i",$time)); Timestamps

// header("Location: /");
