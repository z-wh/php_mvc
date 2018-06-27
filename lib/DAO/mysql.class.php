<?php

class mysql{
	/**
	 * 报错函数
	 * @param  string $error mysql返回的错误信息
	 */
	public function err($error)
	{
		die("连接失败，错误号为：".$error);
	}

	/**
	 * 连接数据库、择库、设置字符编码
	 * @param  array $config 包含数据库配置信息的数组
	 */
	public function connect($config)
	{
		$config = extract($config);
		if(!mysql_connect($dbHost, $dbUser, $dbPassword)){
			$this -> err(mysql_error());
		}
		if (!mysql_select_db($dbName)) {
			$this -> err(mysql_error());
		}

		mysql_set_charset($dbCharset);
	}

	public function query($sql)
	{
		if (!($query = mysql_query($sql))) {
			$this -> err($sql.mysql_error());
		}
		else{
			return $query;
		}
	}

	public function findAll($query)
	{
		while ($rs = mysql_fetch_array($query,MYSQL_ASSOC)) {
			$list[] = $rs;

		}

		return isset($list)?$list : "";
	}

	public function findOne($query)
	{
		return mysql_fetch_array($query, MYSQL_ASSOC);
	}

	public function finResult($query, $row = 0 , $field = 0)
	{
		return mysql_result($query, $row, $field);
	}

	public function insert($table, $array){
		// INSERT INTO $table($key1,$key2,$key3...) VALUES($value1,$value2,$value3...)
		foreach ($array as $key => $value) {
			mysql_real_escape_string($value);
			$keyArray[] = "`".$key."`";
			$valueArray[] = "'".$value."'";
		}
		$keys = implode(",", $keyArray);
		$values = implode(",", $valueArray);
		$sql = "insert into " . $table . "(".$keys.") values(".$values.")";
		$this -> query($sql);

		return mysql_insert_id();

	}

	public function update($table, $array, $where)
	{
		// UPDATE $table SET $key1=$value1, $key2=$value2, $key3=$value3... WHERE $where
		foreach ($array as $key => $value) {
			mysql_real_escape_string($value);
			$arr[] = "`".$key."`='".$value."'";
		}
		$arrs = implode(",", $arr);
		$sql = "update " .$table." set ".$arrs." where ".$where;
		$this -> query($sql);
		echo $sql;
		return mysql_affected_rows();
	}

	public function delete($table, $where)
	{
		//DELETE FROM $table WHERE $where
		$sql = "delete from ".$table." where ".$where;
		$this -> query($sql);
		return mysql_affected_rows();
	}

}