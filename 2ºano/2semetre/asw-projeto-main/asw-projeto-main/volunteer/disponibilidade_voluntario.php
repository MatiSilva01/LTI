<?php

require_once __DIR__.'/../db/controller.php';
require_once __DIR__.'/../i18n/index.php';
require_once __DIR__.'/../helpers/email.php';
require_once __DIR__.'/../institution/institution.php';


class Disponibilidade_Voluntario{
    public $id_voluntario;
    public $dia_semana;
    public $horas_inicio;
    public $horas_fim;

    public static function create($id_voluntario, $dia_semana, $horas_inicio, $horas_fim) {
        global $db;
        $sql = $db->con->prepare("INSERT INTO DisponibilidadeRecolha (id_voluntario, dia_semana, horas_inicio, horas_fim)
                    VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE horas_inicio = ?, horas_fim = ?;");

        $sql->bind_param("isiiii", $id_voluntario, $dia_semana, $horas_inicio, $horas_fim, $horas_inicio, $horas_fim);
        return $sql->execute();
    }


    public static function getOne($id_voluntario){
        global $db;
        $sql = $db->con->prepare("SELECT dia_semana, horas_inicio, horas_fim 
                                    FROM DisponibilidadeRecolha 
                                    WHERE id_voluntario = ?");

        $sql->bind_param("i", $id_voluntario);
        $sql->execute();

        $res = $sql->get_result();

        $rows = $res->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            if (isset($row)) {
                yield self::selfFromRow($row);
            }
        }
    }


    public static function getMatch($id_voluntario, $filtros = null){
        global $db;
        $sql = $db->con->prepare("SELECT I.nome, I.foto, I.distrito, I.concelho, DD.dia_semana, DD.horas_inicio, DD.horas_fim
                                FROM Instituicao as I, DisponibilidadeDoacao as DD, DisponibilidadeRecolha as DR
                                WHERE DR.id_voluntario = ? AND I.id = DD.id_instituicao AND DD.dia_semana = DR.dia_semana AND DR.horas_inicio BETWEEN DD.horas_inicio AND DD.horas_fim AND DR.horas_fim BETWEEN DD.horas_inicio AND DD.horas_fim;");

        $sql->bind_param("i", $id_voluntario);
        $sql->execute();

        $res = $sql->get_result();

        $rows = $res->fetch_all(MYSQLI_ASSOC);

        return $rows;
    } 
    

    public static function selfFromRow($dict) {
        $dis = new Disponibilidade_voluntario();

        // Variables that have the same name
        foreach ($dict as $k=>$v) {
            if ($v && property_exists($dis, $k))
                $dis->$k = $v;
        }

        // Add variables that don't have the same name

        return $dis;
    }

}














    // header("Location: /volunteer/profile.php");
