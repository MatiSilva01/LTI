<?php
require_once __DIR__ . '/../i18n/index.php';
require_once __DIR__ . '/../db/controller.php';
require_once __DIR__ . '/../helpers/email.php';
require_once __DIR__ . '/doacaoAlimento.php';

$validTipos = ["Restaurante", "Café", "Refeitório", "Supermercado", "Distribuidor", "Mercado de Agricultores", "Cooperativa Agrícola", "Agricultores"];

$validTiposDoacoes = ["Bens alimentares de longa duracao", "Bens alimentares de consumo no proprio dia"];

// $validQuantidadeExpectada = ["1", "5", "10", "15", "20", "25", "30"];

class Instituicao
{
    public $id;
    public $nome;
    public $email;
    public $morada;
    public $passwd;
    public $foto;
    public $telefone;
    public $descricao;
    public $contacto;
    public $telefone_contacto;
    public $tipo;
    public $distrito;
    public $concelho;
    public $freguesia;
    public $latitude;
    public $longitude;

    public function update($values)
    {
        global $db;
        $query = "UPDATE Instituicao SET ";

        foreach ($values as $key => $value) {
            if (isset($value)) {
                $query .= "$key = '" . mysqli_real_escape_string($db->con, $value) . "', ";
            }
        }

        // Remover a última vírgula
        $query = substr($query, 0, -2);

        $query .= " WHERE id = $this->id";


        if ($db->con->query($query)) {
            return self::getOne($this->id);
        } else {
            die("Erro ao guardar alterações");
        }
    }

    public function getDonations()
    {
        return DoacaoAlimento::getAllInstitution($this->id);
    }

    public function requestPassword()
    {
        $hash = md5(uniqid($this->nome, true));

        $this->update(["lost_password" => $hash]);

        sendEmail($this->email, _('Recuperar Senha'), str_replace("{{link}}", $_SERVER["HTTP_ORIGIN"] . "/user/change-password.php?q=$hash", _('Recebemos um pedido de reposição de senha. Se não o efetuou, ignore este email.<br/><br/>Para repor a sua senha, clique aqui: {{link}}')));
    }

    public static function create($nome, $email, $passwd, $foto, $telefone, $descricao, $contacto, $telefone_contacto, $tipo, $distrito, $concelho, $freguesia, $morada, $latitude, $longitude)
    {
        global $db;
        $sql = $db->con->prepare("INSERT INTO Instituicao (nome, email, passwd, foto, telefone, descricao, contacto, telefone_contacto, distrito, concelho, freguesia, morada, tipo, latitude, longitude, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, UNIX_TIMESTAMP())");

        $sql->bind_param("sssbissiiiissdd", $nome, $email, $passwd, $foto, $telefone, $descricao, $contacto, $telefone_contacto, $tipo, $distrito, $concelho, $freguesia, $morada, $latitude, $longitude);
        return $sql->execute();
    }

    public static function getOne($id)
    {
        global $db;
        $sql = $db->con->prepare("SELECT * FROM Instituicao WHERE id = ?");
        $sql->bind_param("i", $id);
        $sql->execute();

        $res = $sql->get_result();
        $row = $res->fetch_assoc();
        if (!isset($row)) {
            return null;
        }

        return self::selfFromRow($row);
    }

    public static function findAll($wheres = null, $order = null, $joins = null)
    {
        global $db;
        $query = "SELECT * FROM Instituicao";

        if ($joins) {
            $query .= ' ' . $joins;
        }

        if ($wheres) {
            $query .= " WHERE ";

            for ($i = 0; $i < count($wheres); $i++) {
                $k = key($wheres);
                $v = current($wheres);

                if (is_int($k)) {
                    $query .= "$v ";
                } else {
                    $query .= "$k '" . mysqli_real_escape_string($db->con, $v) . "'";
                }

                next($wheres);
                if ($i < count($wheres) - 1) {
                    $query .= " AND ";
                }
            }
        }

        if ($order) {
            $query .= " ORDER BY $order";
        }

        $rs = $db->con->query($query);
        $rows = $rs->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            if (isset($row)) {
                yield self::selfFromRow($row);
            }
        }
    }

    public static function findAllOr($wheres = null, $order = null)
    {
        global $db;
        $query = "SELECT * FROM Instituicao";

        if ($wheres) {
            $query .= " WHERE ";

            for ($i = 0; $i < count($wheres); $i++) {
                $k = key($wheres);
                $v = current($wheres);

                if (is_int($k)) {
                    $query .= "$v ";
                } else {
                    $query .= "$k '" . mysqli_real_escape_string($db->con, $v) . "'";
                }

                next($wheres);
                if ($i < count($wheres) - 1) {
                    $query .= " OR ";
                }
            }
        }

        if ($order) {
            $query .= " ORDER BY $order";
        }

        #echo($query);

        $rs = $db->con->query($query);
        $rows = $rs->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            if (isset($row)) {
                yield self::selfFromRow($row);
            }
        }
    }

    public static function aceitaRecolha($id_voluntario, $id_instituicao)
    {
        global $db;
        $query = "UPDATE Instituicao SET idsRecolha = $id_voluntario WHERE id = $id_instituicao";
        ($db->con->query($query));
        $query = "UPDATE Pedidos SET Aceite = 1 WHERE Inst = $id_instituicao AND Volt = $id_voluntario";
        ($db->con->query($query));
        return $id_voluntario;
    }

    public static function pedidoRecolha($id_voluntario, $id_instituicao)
    {
        global $db;
        $query = "INSERT INTO Pedidos(Inst, Volt) VALUES ($id_instituicao,$id_voluntario)";
        ($db->con->query($query));

        //experiencia poe nome
        $query = "UPDATE Pedidos 
        SET nome=(SELECT nome FROM Voluntario WHERE Pedidos.Volt=Voluntario.id);";
        ($db->con->query($query));

        //experiencia poe foto
        $query = "UPDATE Pedidos 
        SET foto=(SELECT foto FROM Voluntario WHERE Pedidos.Volt=Voluntario.id);";
        ($db->con->query($query));

        $sql = $db->con->prepare("SELECT ID FROM `Pedidos` WHERE Volt = $id_voluntario AND Inst = $id_instituicao");

        $sql->execute();

        $res = $sql->get_result();
        $rows = $res->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }

    public static function findMatches($id_voluntario, $wheres = null, $order = null)
    {
        global $db;
        $query = "SELECT * FROM Instituicao WHERE id IN (
            SELECT Doa.id_instituicao FROM DisponibilidadeDoacao Doa, DisponibilidadeRecolha Rec
                WHERE Rec.id_voluntario = " . mysqli_real_escape_string($db->con, $id_voluntario) . "
                    AND Doa.dia_semana = Rec.dia_semana
                    AND Doa.horas_inicio BETWEEN Rec.horas_inicio AND Rec.horas_fim
                    AND Doa.horas_fim BETWEEN Rec.horas_inicio AND Rec.horas_fim)";

        if ($wheres) {
            for ($i = 0; $i < count($wheres); $i++) {
                $query .= " AND " . key($wheres) . " '" . mysqli_real_escape_string($db->con, current($wheres)) . "'";
                next($wheres);
            }
        }

        if ($order) {
            $query .= " ORDER BY $order";
        }

        $rs = $db->con->query($query);
        $rows = $rs->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            if (isset($row)) {
                yield Instituicao::selfFromRow($row);
            }
        }
    }




    public static function auth($login, $passwd)
    {
        $user = self::getByLogin($login);

        if ($user && password_verify($passwd, $user->passwd)) {
            return $user;
        } else {
            return null;
        }
    }

    public static function getByLogin($login)
    {
        global $db;
        $sql = $db->con->prepare("SELECT * FROM Instituicao WHERE nome = ? OR email = ?");

        $sql->bind_param("ss", $login, $login);
        $sql->execute();

        $res = $sql->get_result();

        $row = $res->fetch_assoc();
        if (isset($row)) {
            return self::selfFromRow($row);
        } else {
            return null;
        }
    }

    public static function getByLostPasswordHash($hash)
    {
        global $db;
        $sql = $db->con->prepare("SELECT * FROM Instituicao WHERE `lost_password` = ?");

        $sql->bind_param("s", $hash);
        $sql->execute();

        $res = $sql->get_result();

        $row = $res->fetch_assoc();
        if (isset($row)) {
            return self::selfFromRow($row);
        } else {
            return null;
        }
    }

    public static function selfFromRow($dict)
    {
        $instit = new Instituicao();

        // Variables that have the same name
        foreach ($dict as $k => $v) {
            if ($v && property_exists($instit, $k))
                $instit->$k = $v;
        }

        // Add variables that don't have the same name
        $instit->foto = base64_encode($instit->foto);

        return $instit;
    }
}

class Pedidos
{
    public $Volt;
    public $nome;
    public $foto;

    public static function mostraTodos($id)
    {
        global $db;
        $query = "SELECT * FROM Pedidos WHERE Inst = $id AND Aceite = 0";

        $rs = $db->con->query($query);
        $rows = $rs->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            if (isset($row)) {
                yield self::selfFromRowVolt($row);
            }
        }
    }


    public static function verificaPedido($id_instituicao)
    {
        global $db;
        //implode(',', $id_instituicao);


        $sql = $db->con->prepare("SELECT Inst FROM Pedidos WHERE Inst IN (" . implode(',', $id_instituicao) . ") AND Aceite = 1");

        $sql->execute();

        $res = $sql->get_result();
        $rows = $res->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }


    public static function selfFromRowVolt($dict)
    {
        $volunt = new Pedidos();

        // Variables that have the same name
        foreach ($dict as $k => $v) {
            if ($v && property_exists($volunt, $k))
                $volunt->$k = utf8_encode($v);
        }

        // Add variables that don't have the same name
        $volunt->foto = base64_encode(utf8_decode($volunt->foto));

        return $volunt;
    }
    public static function instituicoesAceites($id_voluntario)
    {
        global $db;
        //implode(',', $id_instituicao);
        $sql = $db->con->prepare("SELECT nome FROM Instituicao WHERE id in ( 
            SELECT Inst FROM Pedidos WHERE Aceite = 1 AND Volt = $id_voluntario);");
        $sql->execute();
        $res = $sql->get_result();
        $rows = $res->fetch_all(MYSQLI_ASSOC);

        return $rows;
    }
}
