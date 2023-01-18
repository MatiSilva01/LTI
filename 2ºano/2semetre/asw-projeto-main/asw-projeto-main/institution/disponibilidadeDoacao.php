<?php
require_once __DIR__.'/../i18n/index.php';
require_once __DIR__.'/../db/controller.php';
require_once __DIR__.'/../helpers/email.php';

class DisponibilidadeDoacao{
    public $id_instituicao;
    public $dia_semana;
    public $horas_inicio;
    public $horas_fim;

    
    public function update($values) {
        global $db;
        $query = "UPDATE DisponibilidadeDoacao SET ";

        foreach ($values as $key => $value) {
            if (isset($value)) {
                $query .= "$key = '" . mysqli_real_escape_string($db->con, $value) . "', ";
            }
        }
        
        // Remover a última vírgula
        $query = substr($query, 0, -2);

        $query .= " WHERE dia_semana = $this->dia_semana and id = $this->id_voluntario and horas_inicio = $this->horas_inicio and horas_fim = $this->horas_fim ";


        if ($db->con->query($query)) {
            return self::getOne($this->dia_semana, $this->id_voluntario, $this->horas_inicio, $this->horas_fim);
        } else {
            die("Erro ao guardar alterações");
        }
    }


    public static function create($id_instituicao, $dia_semana, $horas_inicio, $horas_fim) {
        global $db;
        
        $sql = $db->con->prepare("INSERT INTO DisponibilidadeDoacao (id_instituicao, dia_semana,  horas_inicio, horas_fim)
                    VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE horas_inicio = ?, horas_fim = ?;");

        $sql->bind_param("isiiii", $id_instituicao, $dia_semana, $horas_inicio, $horas_fim, $horas_inicio, $horas_fim);
        return $sql->execute();
    }


    public static function getOne(int $id_instituicao, string $dia_semana) {
        global $db;
        $sql = $db->con->prepare("SELECT * FROM DisponibilidadeDoacao WHERE id_instituicao = ? and dia_semana = ?");

        $sql->bind_param("is", $id_instituicao, $dia_semana);
        $sql->execute();

        $res = $sql->get_result();
        $row = $res->fetch_assoc();

        return self::selfFromRow($row);
    }

    public static function getMatch($id_instituicao){
        global $db;
        $sql = $db->con->prepare("SELECT V.nome, V.foto, V.telefone, V.distrito, V.concelho, V.freguesia, DR.dia_semana, DR.horas_inicio, DR.horas_fim
                                FROM Voluntario as V, DisponibilidadeDoacao as DD, DisponibilidadeRecolha as DR
                                WHERE DD.id_instituicao = ? AND V.id = DR.id_voluntario AND DR.dia_semana = DD.dia_semana AND DR.horas_inicio BETWEEN DD.horas_inicio AND DD.horas_fim AND DR.horas_fim BETWEEN DD.horas_inicio AND DD.horas_fim;");

        $sql->bind_param("i", $id_instituicao);
        $sql->execute();

        $res = $sql->get_result();

        $rows = $res->fetch_all(MYSQLI_ASSOC);
        return $rows;
    } 

    public static function selfFromRow($dict) {
        $dis = new DisponibilidadeDoacao();

        // Variables that have the same name
        foreach ($dict as $k=>$v) {
            if ($v && property_exists($dis, $k))
                $dis->$k = $v;
        }

        // Add variables that don't have the same name

        return $dis;
    }

}