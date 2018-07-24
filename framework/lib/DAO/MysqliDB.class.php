<?php

class MysqliDB
{
    private $mysqli;
    public function err($info = "", $error)
    {
        die($info . " 错误信息：" . $error);
    }

    public function connect($dbHost, $dbUser, $dbPassword, $dbName, $dbCharset)
    {
        $this->mysqli = new mysqli($dbHost, $dbUser, $dbPassword);
        if ($this->mysqli->connect_errno) {
            $this->err("连接失败", $this->mysqli->connect_error);
        }
        if (!$this->mysqli->select_db($dbName)) {
            $this->err("择库失败", $this->mysqli->error);
        }
        $this->mysqli->set_charset($dbCharset);
    }

    public function query($sql)
    {
        if (!($rs = $this->mysqli->query($sql))) {
            $this->err($sql, $this->mysqli->error);
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

    public function findResult($rs, $row, $field)
    {
        $rs->data_seek($row);
        $row = $rs->fetch_array();
        return $row[$field];
    }

    public function insert($table, $array)
    {
        foreach ($array as $key => $value) {
            $this->mysqli->real_escape_string($value);
            $keyArr[]   = "`" . $key . "`";
            $valueArr[] = "'" . $value . "'";
        }
        $keys   = implode(",", $keyArr);
        $values = implode(",", $valueArr);
        $sql    = "insert into " . $table . " (" . $keys . ") values(" . $values . ")";
        $this->query($sql);
        return $this->mysqli->insert_id;
    }

    public function update($table, $array, $where)
    {
        foreach ($array as $key => $value) {
            $this->mysqli->real_escape_string($value);
            $arr[] = "`" . $key . "`='" . $value . "'";
        }
        $arrs = implode(",", $arr);
        $sql  = "update " . $table . " set " . $arrs . " where " . $where;
        $this->query($sql);
        return $this->mysqli->affected_rows;
    }

    public function delete($table, $where)
    {
        $sql = "delete from " . $table . " where " . $where;
        $this->query($sql);
        return $this->mysqli->affected_rows;
    }
}
