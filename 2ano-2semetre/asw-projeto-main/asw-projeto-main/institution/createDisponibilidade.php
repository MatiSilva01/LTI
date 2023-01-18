<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__.'/../institution/disponibilidadeDoacao.php';
require_once __DIR__.'/../institution/doacaoAlimento.php';
require_once __DIR__.'/../institution/institution.php';

$dia_semana = htmlspecialchars($_POST["dia"]); //string
$horas_inicio = $_POST["inicio"]; //array
$horas_fim = $_POST["fim"]; //array
$tipo_doacoes = htmlspecialchars($_POST["tipoDoacoes"]); //string
$nomes_alimento = $_POST["nomes"];
$quantidade_doacoes = $_POST["quantidades"];

session_start();
$user = unserialize($_SESSION["user"]);
$id_instituicao = $user->id;



// $instituicao = Instituicao::create($nome, $email, password_hash($passwd, PASSWORD_BCRYPT), $foto, $telefone, $descricao, $contacto, $telefone_contacto, $tipo, $distrito, $concelho, $freguesia, $morada);
// session_start();
// $_SESSION["user"] = serialize($instituicao);
// if(isset($diasSemana, $horas_inicio, $horas_inicio)) {
//     $disponibilidade = array_merge_recursive(
//         array_combine($diasSemana, $horas_inicio),
//         array_combine($diasSemana, $horas_fim),
//     );
// }
if(isset($nomes_alimento, $quantidade_doacoes)) {
    $alimentos = array_merge_recursive(
        array_combine($nomes_alimento, $quantidade_doacoes)
    );
}

// if(isset($disponibilidade)) {
//     foreach($disponibilidade as $dia => $horas) {
//         // $alimentos -> array com nome do alimento ($nome) = quantidade desse alimento ($qnt)
//         //var_dump($disponibilidade);
//         echo ' Dia:    '.$dia;
//         echo ' Horas inicio:    '.$horas[0];
//         echo ' Horas Fim:    '.$horas[1];
//         //insert($dia, intval($horas[0]), intval($horas[1]));
//     }
// }

// echo 'ID:'.$id_instituicao;
// echo 'DIA:'.$dia_semana;
// echo 'HORAS INICIO:'.$horas_inicio[0];
// echo 'HORAS FIM:'.$horas_fim[0];

$disponibilidade = DisponibilidadeDoacao::create($id_instituicao, $dia_semana, $horas_inicio[0], $horas_fim[0]);

if(isset($alimentos)) {
    foreach($alimentos as $nome => $qnt) {
        // $alimentos -> array com nome do alimento ($nome) = quantidade desse alimento ($qnt)
        $alimento = Alimento::create($id_instituicao, $dia_semana, $qnt, $tipo_doacoes, $nome);
    }
}

header("Location: /");

