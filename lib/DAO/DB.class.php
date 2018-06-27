<?php
// 数据库工厂类
class DB {

	public static $db;

	/**
	 * 数据库连接、择库
	 * @param  string $dbTybe 数据库操作函数类型
	 * @param  array $config 数据库连接参数
	 */
	public static function init($dbTybe, $config)
	{
		self :: $db = new $dbTybe();
		self :: $db -> connect($config);
	}

	/**
	 * sql语名执行函数
	 * @param  string $sql sql语句
	 * @return [type]      资源标志符
	 */
	public static function query($sql)
	{
		return self::$db -> query($sql);
	}

	/**
	 * 查找全部数据
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 */
	public static function findAll($sql)
	{
		$query = self :: $db -> query($sql);
		return self :: $db -> findAll($query);
	}


	/**
	 * 查找一条数据
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 */
	public static function findOne($sql)
	{
		$query = self :: $db -> query($sql);
		return self :: $db -> findOne($query);
	}

	/**
	 * 查找指定行指定字段数据
	 * @param  [type] $query [description]
	 * @param  [type] $row   [description]
	 * @param  [type] $field [description]
	 * @return [type]        [description]
	 */
	public static function findResult($sql, $row = 0, $field = 0)
	{
		$query = self :: $db -> query($sql);
		return self :: $db -> findResult($query, $row, $field);
	}

	/**
	 * 插入数据
	 * @param  string $table 所要操作的表
	 * @param  array $array 要插入的数据的一维数组
	 * @return [type]        [description]
	 */
	public static function insert($table, $array)
	{
		return self :: $db -> insert($table, $array);
	}

	/**
	 * 更新数据
	 * @param  string $table 表名
	 * @param  array $array 要更新的数据的一维数组
	 * @return [type]        [description]
	 */
	public static function update($table, $array, $where)
	{
		return self :: $db -> update($table, $array, $where);
	}

	/**
	 * 删除数据
	 * @param  string $table 表名
	 * @param  array $where 条件一维数组
	 * @return [type]        [description]
	 */
	public static function delete($table, $where)
	{
		return self :: $db -> delete($table, $where);
	}

}