<?php

function initComplexTypes($server)
{
    // Volunteer
    $server->wsdl->addComplexType(
        'Volunteer',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'id' => array('name' => 'id', 'type' => 'xsd:int'),
            'nome' => array('name' => 'nome', 'type' => 'xsd:string'),
            'email' => array('name' => 'email', 'type' => 'xsd:string'),
            'foto' => array('name' => 'foto', 'type' => 'xsd:string'),
            'telefone' => array('name' => 'telefone', 'type' => 'xsd:string'),
            'data_nascimento' => array('name' => 'data_nascimento', 'type' => 'xsd:string'),
            'genero' => array('name' => 'genero', 'type' => 'xsd:string'),
            'cartao_cidadao' => array('name' => 'cartao_cidadao', 'type' => 'xsd:int'),
            'carta_conducao' => array('name' => 'carta_conducao', 'type' => 'xsd:int'),
            'distrito' => array('name' => 'distrito', 'type' => 'xsd:string'),
            'concelho' => array('name' => 'concelho', 'type' => 'xsd:string'),
            'freguesia' => array('name' => 'freguesia', 'type' => 'xsd:string')
        )
    );
    
    // Institution
    $server->wsdl->addComplexType(
        'Institution',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'id' => array('name' => 'id', 'type' => 'xsd:int'),
            'nome' => array('name' => 'nome', 'type' => 'xsd:string'),
            'email' => array('name' => 'email', 'type' => 'xsd:string'),
            'morada' => array('name' => 'morada', 'type' => 'xsd:string'),
            'foto' => array('name' => 'foto', 'type' => 'xsd:string'),
            'telefone' => array('name' => 'telefone', 'type' => 'xsd:string'),
            'descricao' => array('name' => 'descricao', 'type' => 'xsd:string'),
            'contacto' => array('name' => 'contacto', 'type' => 'xsd:string'),
            'telefone_contacto' => array('name' => 'telefone_contacto', 'type' => 'xsd:string'),
            'tipo' => array('name' => 'tipo', 'type' => 'xsd:string'),
            'distrito' => array('name' => 'distrito', 'type' => 'xsd:string'),
            'concelho' => array('name' => 'concelho', 'type' => 'xsd:string'),
            'freguesia' => array('name' => 'freguesia', 'type' => 'xsd:string')
        )
    );

    // Institution[]
    $server->wsdl->addComplexType(
        'InstitutionArray',
        'complexType',
        'array',
        '',
        'SOAP-ENC:Array',
        array(),
        array(
            array(
                'ref' => 'SOAP-ENC:arrayType',
                'wsdl:arrayType' => 'tns:Institution[]'
            )
        )

    );

    // Donation
    $server->wsdl->addComplexType(
        'Donation',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'id_instituicao' => array('name' => 'id_instituicao', 'type' => 'xsd:int'),
            'dia_semana' => array('name' => 'dia_semana', 'type' => 'xsd:string'),
            'nome_alimento' => array('name' => 'nome_alimento', 'type' => 'xsd:string'),
            'tipo_doacao' => array('name' => 'tipo_doacao', 'type' => 'xsd:string'),
            'quantidade_expectada' => array('name' => 'quantidade_expectada', 'type' => 'xsd:int'),
        )
    );

    // Donation[]
    $server->wsdl->addComplexType(
        'DonationArray',
        'complexType',
        'array',
        '',
        'SOAP-ENC:Array',
        array(),
        array(
            array(
                'ref' => 'SOAP-ENC:arrayType',
                'wsdl:arrayType' => 'tns:Donation[]'
            )
        )

    );

    $server->wsdl->addComplexType(
        'InstitutionDonations',
        'complexType',
        'struct',
        'all',
        '',
        array(
            'institution' => array('name' => 'institution', 'type' => 'tns:Institution'),
            'donations' => array('name' => 'donation', 'type' => 'tns:DonationArray'),
        )
    );
}
