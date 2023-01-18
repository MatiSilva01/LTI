<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "nusoap.php";
require_once __DIR__ . '/../../institution/institution.php';
require_once __DIR__ . '/../../volunteer/volunteer.php';
require_once __DIR__ . '/../../services/complexTypes.php';

$server = new soap_server();
$server->configureWSDL('Refood_Fcul_Instituicoes', 'urn:Refood_Fcul_Instituicoes');

initComplexTypes($server);

$server->register(
    "getInfoInstDoacoes", // nome metodo
    array('id' => 'xsd:int'), // input
    array('return' => 'tns:InstitutionDonations'), // output
    'uri:Refood_Fcul_Instituicoes', // namespace
    'urn:Refood_Fcul_Instituicoes#getInfoInstDoacoes', // SOAPAction
    'rpc', // estilo
    'encoded' // uso
);

function getInfoInstDoacoes($id)
{
    $instit = Instituicao::getOne($id);
    if (!$instit) die('Instituição não encontrada');
    $doacoes = iterator_to_array($instit->getDonations());
    return ["institution" => $instit, "donations" => $doacoes];
}

$server->register(
    "getInstituicoes", // nome metodo
    array('nome' => 'xsd:string'), // input
    array('return' => 'tns:InstitutionArray'), // output
    'uri:Refood_Fcul_Instituicoes', // namespace
    'urn:Refood_Fcul_Instituicoes#getInstituicoes', // SOAPAction
    'rpc', // estilo
    'encoded' // uso
);

function getInstituicoes($nome = null)
{
    $where = [];

    if ($nome) {
        $where["LOWER(nome) LIKE"] = "%$nome%";
    }

    $instits = iterator_to_array(Instituicao::findAll($where, 'nome'));
    return $instits;
}

if (!isset($HTTP_RAW_POST_DATA)) $HTTP_RAW_POST_DATA = file_get_contents('php://input');
@$server->service($HTTP_RAW_POST_DATA);
