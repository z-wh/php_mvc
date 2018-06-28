<?php

class Mysql
{
    /**
     * 报错函数
     * @param  string $error mysql返回的错误信息
     */
    public function err($error)
    {
        die("连接失败，错误号为：" . $error);

    }

    /**
     * 连接数据库、择库、设置字符编码
     * @param  array $config 包含数据库配置信息的数组
     */
    public function connect($dbHost, $dbUser, $dbPassword, $dbName, $dbCharset)
    {
        if (!mysql_connect($dbHost, $dbUser, $dbPassword)) {
            $this->err(mysql_error());
        }
        if (!mysql_select_db($dbName)) {
            $this->err(mysql_error());
        }

        mysql_set_charset($dbCharset);
    }

    /**
     * 执行sql语名函数
     * @param  string $sql sql语句
     * @return resource      数据库返回的资源结果
     */
    public function query($sql)
    {
        if (!($query = mysql_query($sql))) {
            $this->err($sql . mysql_error());
        } else {
            return $query;
        }
    }

    /**
     * 查找所有数据
     * @param  resource $query 查询返回的资源结果
     * @return array        将资源逐条放入产生的数组
     */
    public function findAll($query)
    {
        while ($rs = mysql_fetch_array($query, MYSQL_ASSOC)) {
            $list[] = $rs;

        }

        return isset($list) ? $list : "";
    }

    /**
     * 查找一条数据
     * @param  resource $query 查询返加的资源结果
     * @return array        从结果集中取出的关联数组
     */
    public function findOne($query)
    {
        return mysql_fetch_array($query, MYSQL_ASSOC);
    }

    /**
     * 查找指定行指定字段数据
     * @param  resource  $query 查询返回的资源结果集
     * @param  integer $row   行
     * @param  integer $field 字段
     * @return string         结果集中一个单元的内容
     */
    public function finResult($query, $row = 0, $field = 0)
    {
        return mysql_result($query, $row, $field);
    }

    /**
     * 插入数据
     * @param  string $table 表名
     * @param  array $array 要插入的数据构成的数组
     * @return integer        insert操作产生的ID号
     */
    public function insert($table, $array)
    {
        // INSERT INTO $table($key1,$key2,$key3...) VALUES($value1,$value2,$value3...)
        foreach ($array as $key => $value) {
            mysql_real_escape_string($value);
            $keyArray[]   = "`" . $key . "`";
            $valueArray[] = "'" . $value . "'";
        }
        $keys   = implode(",", $keyArray);
        $values = implode(",", $valueArray);
        $sql    = "insert into " . $table . "(" . $keys . ") values(" . $values . ")";
        $this->query($sql);

        return mysql_insert_id();

    }

    /**
     * 更新表操作
     * @param  string $table 表名
     * @param  array $array 要更改的数据组成的数组
     * @param  strig $where 条件
     * @return integer        update操作影响的记录行数
     */
    public function update($table, $array, $where)
    {
        // UPDATE $table SET $key1=$value1, $key2=$value2, $key3=$value3... WHERE $where
        foreach ($array as $key => $value) {
            mysql_real_escape_string($value);
            $arr[] = "`" . $key . "`='" . $value . "'";
        }
        $arrs = implode(",", $arr);
        $sql  = "update " . $table . " set " . $arrs . " where " . $where;
        $this->query($sql);
        echo $sql;
        return mysql_affected_rows();
    }

    /**
     * 删除数据操作
     * @param  string $table 表名
     * @param  string $where 条件
     * @return integer        delete操作影响的记录行数
     */
    public function delete($table, $where)
    {
        //DELETE FROM $table WHERE $where
        $sql = "delete from " . $table . " where " . $where;
        $this->query($sql);
        return mysql_affected_rows();
    }

}
