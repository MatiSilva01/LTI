<?php
require_once __DIR__ . '/../volunteer/volunteer.php';
require_once __DIR__ . '/../institution/institution.php';

$usernameEmail = htmlspecialchars($_POST["usernameEmailLogin"]);
$passwd = htmlspecialchars($_POST["passwordLogin"]);

$user = Voluntario::auth($usernameEmail, $passwd) ?? Instituicao::auth($usernameEmail, $passwd);

if (!$user) {
    header("Location: /auth.php?err=Utilizador ou password incorreta");
} else {
    session_start();
    $_SESSION["user"] = serialize($user);

    header("Location: /");
}
