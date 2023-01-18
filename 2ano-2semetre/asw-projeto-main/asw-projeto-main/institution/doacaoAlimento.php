<?php
require_once __DIR__ . '/../i18n/index.php';
require_once __DIR__ . '/../db/controller.php';
require_once __DIR__ . '/../helpers/email.php';

class DoacaoAlimento
{
    public $id_instituicao;
    public $dia_semana;
    public $nome_alimento;
    public $tipo_doacao;
    public $quantidade_expectada;


    public function update($values)
    {
        global $db;
        $query = "UPDATE DoacaoAlimento SET ";

        foreach ($values as $key => $value) {
            if (isset($value)) {
                $query .= "$key = '" . mysqli_real_escape_string($db->con, $value) . "', ";
            }
        }

        // Remover a última vírgula
        $query = substr($query, 0, -2);

        $query .= " WHERE id = $this->id_voluntario and dia_semana = $this->dia_semana nome_alimento = $this->nome_alimento and tipo_doacao = $this->tipo_doacoes and quantidade_expectada = $this->quantidade_doacoes";


        if ($db->con->query($query)) {
            return self::getOne($this->id_voluntario, $this->dia_semana, $this->nome_alimento, $this->tipo_doacoes, $this->quantidade_doacoes);
        } else {
            die("Erro ao guardar alterações");
        }
    }


    public static function create($id_instituicao, $dia_semana, $quantidade_doacoes, $tipo_doacoes, $nome_alimento)
    {
        global $db;
        $sql = $db->con->prepare("INSERT INTO DoacaoAlimento (id_instituicao, dia_semana, quantidade_expectada, tipo_doacao, nome_alimento) 
                                  VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE nome_alimento = ?, tipo_doacao = ?, quantidade_expectada = ?");

        $sql->bind_param("isissssi", $id_instituicao, $dia_semana, $quantidade_doacoes, $tipo_doacoes, $nome_alimento, $nome_alimento, $tipo_doacoes, $quantidade_doacoes);
        return $sql->execute();
    }

    public static function getAllInstitution($id_instituicao)
    {
        global $db;
        $query = $db->con->prepare("SELECT * FROM DoacaoAlimento WHERE id_instituicao = ? ORDER BY dia_semana");

        $query->bind_param("i", $id_instituicao);
        $query->execute();

        $rs = $query->get_result();
        $rows = $rs->fetch_all(MYSQLI_ASSOC);
        foreach ($rows as $row) {
            if (isset($row)) {
                yield self::selfFromRow($row);
            }
        }
    }

    public static function getOne(int $id_voluntario, string $distrito, string $concelho, string $freguesia)
    {
        global $db;
        $sql = $db->con->prepare("SELECT * FROM DoacaoAlimento WHERE id_voluntario = ? and distrito = ? and concelho = ? and freguesia = ?");

        $sql->bind_param("isss", $id_voluntario, $distrito, $concelho, $freguesia);
        $sql->execute();

        $res = $sql->get_result();

        $row = $res->fetch_assoc();
        return self::selfFromRow($row);
    }

    public static function selfFromRow($dict)
    {
        $dis = new DoacaoAlimento();

        // Variables that have the same name
        foreach ($dict as $k => $v) {
            if ($v && property_exists($dis, $k))
                $dis->$k = $v;
        }

        // Add variables that don't have the same name

        return $dis;
    }
}
