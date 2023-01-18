<?php
class Stats
{
    public static function getStatsVoluntarios()
    {
        global $db;
        $query = "SELECT COUNT(id) as count,
            MONTH(FROM_UNIXTIME(created_at)) as created_at_month,
            YEAR(FROM_UNIXTIME(created_at)) as created_at_year
            FROM Voluntario
            GROUP BY created_at_year, created_at_month
            ORDER BY created_at_year, created_at_month";

        $rs = $db->con->query($query);
        $rows = $rs->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }

    public static function getStatsInstituicoes()
    {
        global $db;
        $query = "SELECT COUNT(id) as count,
            MONTH(FROM_UNIXTIME(created_at)) as created_at_month,
            YEAR(FROM_UNIXTIME(created_at)) as created_at_year
            FROM Instituicao
            GROUP BY created_at_year, created_at_month
            ORDER BY created_at_year, created_at_month";

        $rs = $db->con->query($query);
        $rows = $rs->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }

    public static function getStatsMensagens()
    {
        global $db;
        $query = "SELECT COUNT(id) as count,
            DAY(FROM_UNIXTIME(created_at)) as created_at_day,
            MONTH(FROM_UNIXTIME(created_at)) as created_at_month,
            YEAR(FROM_UNIXTIME(created_at)) as created_at_year
            FROM Mensagem
            GROUP BY created_at_year, created_at_month, created_at_day
            ORDER BY created_at_year, created_at_month, created_at_day";

        $rs = $db->con->query($query);
        $rows = $rs->fetch_all(MYSQLI_ASSOC);
        return $rows;
    }
}
