<?php

class MysqliDB
{
    private static $mysqli;
    public function err($error)
    {
        die("出现错误，错误信息：" . $error);
    }

    public function connect($dbHost, $dbUser, $dbPassword, $dbName, $dbCharset)
    {
        self::$mysqli = new mysqli($dbHost, $dbUser, $dbPassword);
        if (self::$mysqli->connect_errno) {
            $this->err(self::$mysqli->connect_error);
        }
        if (!self::$mysqli->select_db($dbName)) {
            $this->err(self::$mysqli->error);
        }
        self::$mysqli->set_charset($dbCharset);
    }

    public function query($sql)
    {
        if (!($rs = self::$mysqli->query($sql))) {
            $this->err(self::$mysqli->error);
        } else {
            return $rs;
        }
    }

    public function findAll($rs)
    {
        $rs->fetch_array(MYSQLI_ASSOC);
        foreach ($rs as $row) {
            $list[] = $row;
        }
        return isset($list) ? $list : "";
    }

    public function findOne($rs)
    {
        return $rs->fetch_array(MYSQLI_ASSOC);
    }

    public function insert($table, $array)
    {
        foreach ($array as $key => $value) {
            self::$mysqli->real_escape_string($value);
            $keyArr[]   = "`" . $key . "`";
            $valueArr[] = "'" . $value . "'";
        }
        $keys   = implode(",", $keyArr);
        $values = implode(",", $valueArr);
        $sql    = "insert into " . $table . " (" . $keys . ") values(" . $values . ")";
        $this->query($sql);
        return self::$mysqli->insert_id;
    }

    public function update($table, $array, $where)
    {
        foreach ($array as $key => $value) {
            self::$mysqli->real_escape_string($value);
            $arr[] = "`" . $key . "`='" . $value . "'";
        }
        $arrs = implode(",", $arr);
        $sql  = "update " . $table . " set " . $arrs . " where " . $where;
        $this->query($sql);
        return self::$mysqli->affected_rows;
    }

    public function delete($table, $where)
    {
        $sql = "delete from " . $table . " where " . $where;
        $this->query($sql);
        return self::$mysqli->affected_rows;
    }
}
