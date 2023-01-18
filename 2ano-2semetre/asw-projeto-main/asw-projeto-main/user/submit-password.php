<?php
require_once "../i18n/index.php";
require_once __DIR__ . '/../volunteer/volunteer.php';
require_once __DIR__ . '/../institution/institution.php';

$hash = htmlspecialchars($_POST["hash"]);
if (!isset($hash)) {
    header('Location: /');
}

$user = Voluntario::getByLostPasswordHash($hash) ?? Instituicao::getByLostPasswordHash($hash);
if (!isset($user)) {
    header('Location: /');
}

$password = htmlspecialchars($_POST["password"]);
$confirmPassword = htmlspecialchars($_POST["confirmPassword"]);
if ($password != $confirmPassword) {
    header("Location: change-password.php?q=$hash");
}

$user->update(["passwd" => password_hash($password, PASSWORD_BCRYPT), "lost_password" => ""]);
session_start();
$_SESSION["user"] = serialize($user);
header('Location: /');
?>