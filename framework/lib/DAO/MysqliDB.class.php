<?php
/**
 * 使用msqli方式连接数据库
 */
class MysqliDB
{
    private $mysqli;

    /**
     * 报错停止函数
     * @param  string $info  错误描述文字
     * @param  string $error msqli.error返回的错误字符串
     * @return string        报错信息
     */
    public function err($info = "", $error)
    {
        die($info . " 错误信息：" . $error);
    }

    /**
     * 连接数据库
     * @param  string $dbHost     数据库连接地址
     * @param  string $dbUser     数据库用户名
     * @param  string $dbPassword 数据库密码
     * @param  string $dbName     库名
     * @param  string $dbCharset  字符编码集
     * @return obj             mysqli object
     */
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

    /**
     * 执行sql语句
     * @param  string $sql sql语句
     * @return resource result      资源结果集
     */
    public function query($sql)
    {
        if (!($rs = $this->mysqli->query($sql))) {
            $this->err($sql, $this->mysqli->error);
        } else {
            return $rs;
        }
    }

    /**
     * 查找所有数据
     * @param  resource result $rs sql查询返回的资源结果集
     * @return array     资源结果集放入形成的数组
     */
    public function findAll($rs)
    {
        $rs->fetch_array(MYSQLI_ASSOC);
        foreach ($rs as $row) {
            $list[] = $row;
        }
        return isset($list) ? $list : "";
    }

    /**
     * 查找一条数据
     * @param  resource result $rs 资源结果集
     * @return array     关联数组
     */
    public function findOne($rs)
    {
        return $rs->fetch_array(MYSQLI_ASSOC);
    }

    /**
     * 查找指定字段的数据，多用于查找记录条数
     * @param  resource result $rs    资源结果集
     * @param  string $row   数据表的 行
     * @param  string $field 数据表的 字段
     * @return string        指定字段取出为字符串
     */
    public function findResult($rs, $row, $field)
    {
        $rs->data_seek($row);
        $row = $rs->fetch_array(MYSQLI_NUM);
        return $row[$field];
    }

    /**
     * 插入数据
     * @param  string $table 表名
     * @param  array $array 数组形式的数据
     * @return int        最近一条插入成功的数据的id
     */
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

    /**
     * 更新数据
     * @param  string $table 表名
     * @param  array $array 数组形式的数据
     * @param  string $where 条件语句字符串
     * @return int        影响行数
     */
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

    /**
     * 删除数据
     * @param  string $table 表名
     * @param  string $where 条件语句字符串
     * @return int        影响行数
     */
    public function delete($table, $where)
    {
        $sql = "delete from " . $table . " where " . $where;
        $this->query($sql);
        return $this->mysqli->affected_rows;
    }
}
