<?php
require_once __DIR__ . '/../i18n/index.php';
require_once __DIR__ . '/../db/controller.php';
require_once __DIR__ . '/../helpers/email.php';

class AvaliacaoVoluntario
{
    public $id_voluntario;
    public $id_instituicao;
    public $avaliacao;
    public $comentario;
    public $created_at;

    public static function create($id_voluntario, $id_instituicao, $avaliacao, $comentario)
    {
        global $db;
        $sql = $db->con->prepare("INSERT INTO AvaliacaoVoluntario (id_voluntario, id_instituicao, avaliacao, comentario, created_at)
                    VALUES (?, ?, ?, ?, UNIX_TIMESTAMP()) ON DUPLICATE KEY UPDATE avaliacao = ?, comentario = ?");

        $sql->bind_param("iiisis", $id_voluntario, $id_instituicao, $avaliacao, $comentario, $avaliacao, $comentario);
        return $sql->execute();
    }

    public static function getOne($id_voluntario, $id_instituicao)
    {
        global $db;
        $sql = $db->con->prepare("SELECT * FROM AvaliacaoVoluntario WHERE id_voluntario = ? AND id_instituicao = ?");
        $sql->bind_param("ii", $id_voluntario, $id_instituicao);
        $sql->execute();

        $res = $sql->get_result();
        $row = $res->fetch_assoc();
        if (!isset($row)) {
            return null;
        }

        return self::selfFromRow($row);
    }

    public static function getStatsVoluntario($id_voluntario) {
        global $db;
        $query = $db->con->prepare("SELECT AVG(avaliacao) as media, COUNT(avaliacao) as total FROM AvaliacaoVoluntario WHERE id_voluntario = ?");

        $query->bind_param("i", $id_voluntario);
        $query->execute();

        $rs = $query->get_result();
        $row = $rs->fetch_assoc();

        return $row;
    }

    public static function getAllVoluntario($id_voluntario)
    {
        global $db;
        $query = $db->con->prepare("SELECT * FROM AvaliacaoVoluntario WHERE id_voluntario = ? ORDER BY created_at DESC");

        $query->bind_param("i", $id_voluntario);
        $query->execute();

        $rs = $query->get_result();
        $rows = $rs->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            if (isset($row)) {
                yield self::selfFromRow($row);
            }
        }
    }

    public static function selfFromRow($dict)
    {
        $vol = new AvaliacaoVoluntario();

        // Variables that have the same name
        foreach ($dict as $k => $v) {
            if ($v && property_exists($vol, $k))
                $vol->$k = $v;
        }

        return $vol;
    }
}
