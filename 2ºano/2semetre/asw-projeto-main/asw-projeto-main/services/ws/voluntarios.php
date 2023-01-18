<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "nusoap.php";
require_once __DIR__ . '/../../volunteer/volunteer.php';
require_once __DIR__ . '/../../institution/institution.php';

$server = new soap_server();
$server->configureWSDL('Refood_Fcul_Voluntarios', 'urn:Refood_Fcul_Voluntarios');

$server->register(
    "pedeRecolhaDoacao", // nome metodo
    array('login' => 'xsd:string', 'password' => 'xsd:string', 'idInstit' => 'xsd:int', 'diaSemana' => 'xsd:string', 'nomeAlimento' => 'xsd:string'), // input
    array('return' => 'xsd:int'), // output
    'uri:Refood_Fcul_Voluntarios', // namespace
    'urn:Refood_Fcul_Voluntarios#getInstituicoes', // SOAPAction
    'rpc', // estilo
    'encoded' // uso
);

function pedeRecolhaDoacao($login, $password, $idInstit, $diaSemana, $nomeAlimento)
{
    $vol = Voluntario::auth($login, $password);
    if (!$vol) die('Não Aceite. Login ou password inválidos');

    $instit = Instituicao::getOne($idInstit);
    if (!$instit) die('Não Aceite. Instituição não encontrada');

    try {
        $pedidos = $instit->pedidoRecolha($vol->id, $instit->id);
        return 'Aceite.';
    } catch (Exception $e) {
        die('Não Aceite. Pedido já existente');
    }
}



if (!isset($HTTP_RAW_POST_DATA)) $HTTP_RAW_POST_DATA = file_get_contents('php://input');
@$server->service($HTTP_RAW_POST_DATA);
