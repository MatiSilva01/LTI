<?php
require_once __DIR__.'/../volunteer/volunteer.php';

$values = [
    "horas_inicio" => isset($_POST["inicio"]) ? htmlspecialchars($_POST["inicio"]) : null,
    "horas_fim" => isset($_POST["fim"]) ? htmlspecialchars($_POST["fim"]) : null,
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
