<?php
// 数据库工厂类
class DB
{

    public static $db;

    /**
     * 数据库连接、择库
     * @param  string $dbTybe 数据库操作函数类型
     * @param  array $configs 数据库连接参数
     */
    public static function init($configs)
    {
        extract($configs);
        self::$db = new $dbType();
        self::$db->connect($dbHost, $dbUser, $dbPassword, $dbName, $dbCharset);
    }

    /**
     * sql语名执行函数
     * @param  string $sql sql语句
     * @return [type]      资源标志符
     */
    public static function query($sql)
    {
        return self::$db->query($sql);
    }

    /**
     * 查找全部数据
     * @param  [type] $rs [description]
     * @return [type]        [description]
     */
    public static function findAll($sql)
    {
        $rs = self::$db->query($sql);
        return self::$db->findAll($rs);
    }

    /**
     * 查找一条数据
     * @param  [type] $rs [description]
     * @return [type]        [description]
     */
    public static function findOne($sql)
    {
        $rs = self::$db->query($sql);
        return self::$db->findOne($rs);
    }

    /**
     * 查找指定行指定字段数据
     * @param  [type] $rs [description]
     * @param  [type] $row   [description]
     * @param  [type] $field [description]
     * @return [type]        [description]
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
     * @return [type]        [description]
     */
    public static function insert($table, $array)
    {
        return self::$db->insert($table, $array);
    }

    /**
     * 更新数据
     * @param  string $table 表名
     * @param  array $array 要更新的数据的一维数组
     * @return [type]        [description]
     */
    public static function update($table, $array, $where)
    {
        return self::$db->update($table, $array, $where);
    }

    /**
     * 删除数据
     * @param  string $table 表名
     * @param  array $where 条件一维数组
     * @return [type]        [description]
     */
    public static function delete($table, $where)
    {
        return self::$db->delete($table, $where);
    }

}
