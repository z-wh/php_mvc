<?php


	require_once("configs.php");
	require_once("lib/DAO/DB.class.php");
	require_once("lib/DAO/mysql.class.php");


	DB::init("mysql", $config["dbConfig"]);

	// $sql = "select * from imooc_user";
	// $list = DB::findAll($sql);

	// foreach ($list as  $value) {
	// 	var_dump($value);
	// }

	// $array = array(
	// 	'username' => 'zhowh',
	// 	'password' => '123',
	// 	'sex' => '女',
	// 	'email' => 'zhouwh@zhouwh.com',
	// 	'face' => '1.jpg',
	// 	'regTime' => time(),
	// 	'activeFlag' => '1',
	// );

	// $table = 'imooc_user';

	// DB :: insert($table, $array);
	
	// $array = array(
	// 	'username' => 'zhouwh',
	// 	'password' => md5('123'),
	// 	'sex' => '男',
	// 	'email' => 'zhouwh@163.com',
	// 	'face' => 'zhouwh.jpg',
	// 	'regTime' => time(),
	// 	'activeFlag' => '0',
	// );

	// $table = 'imooc_user';
	// $where = " username = 'zhowh'";

	// DB :: update($table, $array, $where);

	// $table = 'imooc_user';
	// $where = " username = 'zhouwh'";
	// DB :: delete($table, $where);

	$sql = "select * from imooc_user where id=3";
	$rs = DB::findOne($sql);
	var_dump($rs);

?>