<?php 
class NewsModel
{
	private $_table = 'news';

	public function count()
	{
		$sql = 'select count(*) from '. $this->_table;
		return DB::findResult($sql);
	}
}