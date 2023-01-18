<?php
require_once __DIR__ . '/../i18n/index.php';
require_once __DIR__ . '/../db/controller.php';
require_once __DIR__ . '/../helpers/email.php';

$validGeneros = ["Masculino", "Feminino", "Outro"];

class Voluntario
{
    public $id;
    public $nome;
    public $email;
    public $passwd;
    public $foto;
    public $telefone;
    public $data_nascimento;
    public $genero;
    public $cartao_cidadao;
    public $carta_conducao;
    public $distrito;
    public $concelho;
    public $freguesia;
    public $latitude;
    public $longitude;

    public function update($values)
    {
        global $db;
        $query = "UPDATE Voluntario SET ";

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

    public function requestPassword()
    {
        $hash = md5(uniqid($this->nome, true));

        $this->update(["lost_password" => $hash]);

        sendEmail($this->email, _('Recuperar Senha'), str_replace("{{link}}", $_SERVER["HTTP_ORIGIN"] . "/user/change-password.php?q=$hash", _('Recebemos um pedido de reposição de senha. Se não o efetuou, ignore este email.<br/><br/>Para repor a sua senha, clique aqui: {{link}}')));
    }

    public static function create($nome, $email, $passwd, $foto, $telefone, $data_nascimento, $genero, $cartao_cidadao, $carta_conducao, $distrito, $concelho, $freguesia, $latitude, $longitude)
    {
        global $db;
        $sql = $db->con->prepare("INSERT INTO Voluntario (nome, email, passwd, foto, telefone, data_nascimento, genero, cartao_cidadao, carta_conducao, distrito, concelho, freguesia, latitude, longitude, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, UNIX_TIMESTAMP())");

        $sql->bind_param("sssbissiisssdd", $nome, $email, $passwd, $foto, $telefone, $data_nascimento, $genero, $cartao_cidadao, $carta_conducao, $distrito, $concelho, $freguesia, $latitude, $longitude);
        return $sql->execute();
    }

    public static function getOne(int $id)
    {
        global $db;
        $sql = $db->con->prepare("SELECT * FROM Voluntario WHERE id = ?");

        $sql->bind_param("i", $id);
        $sql->execute();

        $res = $sql->get_result();
        $row = $res->fetch_assoc();
        if (!isset($row)) {
            return null;
        }

        return self::selfFromRow($row);
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
        $sql = $db->con->prepare("SELECT * FROM Voluntario WHERE nome = ? OR email = ?");

        $sql->bind_param("ss", $login, $login);
        $sql->execute();

        $res = $sql->get_result();

        $row = $res->fetch_assoc();
        if (!isset($row)) {
            return null;
        }

        return self::selfFromRow($row);
    }

    public static function getByLostPasswordHash($hash)
    {
        global $db;
        $sql = $db->con->prepare("SELECT * FROM Voluntario WHERE `lost_password` = ?");

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

    public static function findAll($wheres = null, $order = null, $joins = null)
    {
        global $db;
        $query = "SELECT * FROM Voluntario";
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

    public static function findAllDisp($wheres = null, $order = null)
    {
        global $db;
        $query = "SELECT * FROM DisponibilidadeRecolha";

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
        $query = "SELECT * FROM Voluntario";

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

    public static function findMatches($id_instituicao, $wheres = null, $order = null)
    {
        global $db;
        
                    $query = "SELECT * FROM Voluntario WHERE id IN (
                        SELECT Rec.id_voluntario FROM DisponibilidadeDoacao Doa, DisponibilidadeRecolha Rec
                            WHERE Doa.id_instituicao = " . mysqli_real_escape_string($db->con, $id_instituicao) . "
                                AND Rec.dia_semana = Doa.dia_semana
                                AND Rec.horas_inicio BETWEEN Doa.horas_inicio AND Doa.horas_fim
                                AND Rec.horas_fim BETWEEN Doa.horas_inicio AND Doa.horas_fim)";
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
                yield Voluntario::selfFromRow($row);
            }
        }
    }

    public static function selfFromRow($dict)
    {
        $vol = new Voluntario();

        // Variables that have the same name
        foreach ($dict as $k => $v) {
            if ($v && property_exists($vol, $k))
                $vol->$k = $v;
        }

        // Add variables that don't have the same name
        $vol->foto = base64_encode($vol->foto);

        return $vol;
    }
}
