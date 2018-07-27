<?php
// 数据库工厂类
class DB
{

    public static $db;

    /**
     * 数据库连接、择库
     * @param  string $dbTybe 数据库操作函数类型
     * @param  array $configs 数据库连接参数构成的数组
     */
    public static function init($configs)
    {
        extract($configs);
        self::$db = new $dbType();
        self::$db->connect($dbHost, $dbUser, $dbPassword, $dbName, $dbCharset);
    }

    /**
     * 执行sql语句
     * @param  string $sql sql语句
     * @return resource result      资源结果集
     */
    public static function query($sql)
    {
        return self::$db->query($sql);
    }

    /**
     * 查找所有数据
     * @param  resource result $rs sql查询返回的资源结果集
     * @return array     资源结果集放入形成的数组
     */
    public static function findAll($sql)
    {
        $rs = self::$db->query($sql);
        return self::$db->findAll($rs);
    }

    /**
     * 查找一条数据
     * @param  resource result $rs 资源结果集
     * @return array     关联数组
     */
    public static function findOne($sql)
    {
        $rs = self::$db->query($sql);
        return self::$db->findOne($rs);
    }

    /**
     * 查找指定字段的数据，多用于查找记录条数
     * @param  resource result $rs    资源结果集
     * @param  string $row   数据表的 行
     * @param  string $field 数据表的 字段
     * @return string        指定字段取出为字符串
     */
    public static function findResult($sql, $row = 0, $field = 0)
    {
        $rs = self::$db->query($sql);
        return self::$db->findResult($rs, $row, $field);
    }

    /**
     * 插入数据
     * @param  string $table 所要操作的表
     * @param  array $array 要插入的数据的一维数组
     * @return int        最近一条插入成功的数据的id
     */
    public static function insert($table, $array)
    {
        return self::$db->insert($table, $array);
    }

    /**
     * 更新数据
     * @param  string $table 表名
     * @param  array $array 数组形式的数据
     * @param  string $where 条件语句字符串
     * @return int        影响行数
     */
    public static function update($table, $array, $where)
    {
        return self::$db->update($table, $array, $where);
    }

    /**
     * 删除数据
     * @param  string $table 表名
     * @param  string $where 条件语句字符串
     * @return int        影响行数
     */
    public static function delete($table, $where)
    {
        return self::$db->delete($table, $where);
    }

}
