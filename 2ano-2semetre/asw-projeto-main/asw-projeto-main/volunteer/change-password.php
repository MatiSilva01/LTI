<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__.'/../volunteer/volunteer.php';

$password = htmlspecialchars($_POST["passwordVoluntario"]);
$confirmPassword = htmlspecialchars($_POST["confirmPasswordVoluntario"]);
if ($password != $confirmPassword) {
    header("Location: /user/profile.php");
}


session_start();
$user = unserialize($_SESSION["user"]);

if (!($user instanceof Voluntario)) {
    header("Location: /user/profile.php");
} else {
    $user = $user->update(["passwd" => password_hash($password, PASSWORD_BCRYPT), "lost_password" => ""]);
    
    $_SESSION["user"] = serialize($user);
    header('Location: /user/profile.php');
}