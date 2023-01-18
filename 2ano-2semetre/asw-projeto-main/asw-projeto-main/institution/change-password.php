<?php
require_once __DIR__.'/../institution/institution.php';

$password = htmlspecialchars($_POST["passwordInstituicao"]);
$confirmPassword = htmlspecialchars($_POST["confirmPasswordInstituicao"]);
if ($password != $confirmPassword) {
    header("Location: /user/profile.php");
}


session_start();
$user = unserialize($_SESSION["user"]);

if (!($user instanceof Instituicao)) {
    header("Location: /user/profile.php");
} else {
    $user = $user->update(["passwd" => password_hash($password, PASSWORD_BCRYPT), "lost_password" => ""]);
    
    $_SESSION["user"] = serialize($user);
    header('Location: /user/profile.php');
}