<?php
require_once __DIR__ . '/../volunteer/volunteer.php';
require_once __DIR__ . '/../institution/institution.php';

$login = htmlspecialchars($_POST["usernameEmailRecover"]);
if (!isset($login)) {
    header('Location: /auth.php');
}

$user = Voluntario::getByLogin($login) ?? Instituicao::getByLogin($login);
echo 'Se existir um utilizador com esse nome/email, terá recebido um email com um link de reposição de senha';

if (isset($user)) {
    $user->requestPassword();
}