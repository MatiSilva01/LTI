<?php
require_once __DIR__ . '/../i18n/index.php';
require_once __DIR__ . '/../db/controller.php';
require_once __DIR__ . '/../helpers/email.php';

class MensagemVoluntario
{
    public $mensagem;
    public $sender_volunteer;
    public $id_voluntario;
    public $id_instituicao;
    public $opened;
    public $chatid;

    public static function addChat($id_instituicao, $mensagem, $sender_volunteer, $id_voluntario, $opened)
    {
        global $db;
        $sql = $db->con->prepare("INSERT INTO Mensagem (id_instituicao, mensagem, sender_volunteer, id_voluntario, created_at, opened)
                    VALUES (?, ?, ?, ?, UNIX_TIMESTAMP(), ?)");

        $sql->bind_param("isiii", $id_instituicao, $mensagem, $sender_volunteer, $id_voluntario, $opened);
        return $sql->execute();
    }

    public static function updateOpen($opened, $chatid)
    {
        global $db;
        $sql = $db->con->prepare("UPDATE Mensagem SET opened = ? WHERE id = ?");

        $sql->bind_param("ii", $opened, $chatid);
        return $sql->execute();
    }

    public static function selectChat($id_instituicao, $id_voluntario) // ((idinst = 1, mensagem = ola, idvol = 7, created_at = 32131...),(etc...))
    {
        global $db;
        $sql = $db->con->prepare("SELECT * FROM Mensagem 
                                    WHERE (id_instituicao = ? AND id_voluntario = ?)
                                    OR (id_voluntario = ? AND id_instituicao = ?)");

        $sql->bind_param("iiii", $id_instituicao, $id_voluntario, $id_instituicao, $id_voluntario);
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
