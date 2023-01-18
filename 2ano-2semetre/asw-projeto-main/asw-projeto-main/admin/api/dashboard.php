<?php
require_once __DIR__ . '/../../volunteer/volunteer.php';
require_once __DIR__ . '/../../institution/institution.php';

$wheres = [];
$pesquisa = htmlspecialchars($_REQUEST["pesquisa"]);

if ($pesquisa) {
    $pesquisaLwr = strtolower($pesquisa);
    # Procurar nome
    $wheres["LOWER(nome) LIKE"] = "%$pesquisaLwr%";
    # Distrito
    $wheres["distrito ="] = $pesquisaLwr;
    # Concelho
    $wheres["concelho ="] = $pesquisaLwr;
    # Freguesia
    $wheres["freguesia ="] = $pesquisaLwr;
    # E-Mail
    $wheres['LOWER(email) LIKE'] = "%$pesquisaLwr%";


    if (is_numeric($pesquisa)) {
        # Telefone
        $wheres["telefone LIKE"] = "%$pesquisaLwr%";
    }

    # --Parte específica Volunt--.
    $wheresVolunt = $wheres;

    if (is_numeric($pesquisa)) {
        # Idade
        $wheresVolunt["TIMESTAMPDIFF(YEAR,data_nascimento,CURDATE()) ="] = $pesquisaLwr;
        # cartao_cidadao
        $wheresVolunt["cartao_cidadao LIKE"] = "%$pesquisaLwr%";
        # carta_conducao
        $wheresVolunt["carta_conducao LIKE"] = "%$pesquisaLwr%";
    }
    # Genero
    $wheresVolunt['genero ='] = $pesquisaLwr;

    # --Parte específica Inst.--
    $wheresInst = $wheres;

    # Descrição
    $wheresInst['LOWER(descricao) LIKE'] = "%$pesquisaLwr%";
    # Contacto
    $wheresInst['LOWER(contacto) LIKE'] = "%$pesquisaLwr%";
    # Morada
    $wheresInst['LOWER(morada) LIKE'] = "%$pesquisaLwr%";
    # Tipo
    $wheresInst['LOWER(tipo) LIKE'] = "%$pesquisaLwr%";
}

#var_dump($wheres);
# Procurar em Voluntario e organizar por nome
$vols = iterator_to_array(Voluntario::findAllOr($wheresVolunt, "nome"));
# Porucar em Instituição e organizar por nome
$inst = iterator_to_array(Instituicao::findAllOr($wheresInst, "nome"));

header("Content-Type: application/json");
echo json_encode(["voluntarios" => $vols, "instituicoes" => $inst], JSON_INVALID_UTF8_IGNORE);
