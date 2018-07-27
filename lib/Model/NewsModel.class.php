<?php
class NewsModel
{
    private $_table = 'news';

    public function count()
    {
        $sql = 'select count(*) from ' . $this->_table;
        return DB::findResult($sql);
    }

    public function findOneById($id)
    {
        $sql = 'select * from ' . $this->_table . ' where id = ' . $id;
        return DB::findOne($sql);
    }

    public function insert($data)
    {
        return DB::insert($this->_table, $data);
    }

    public function update($data, $id)
    {
        return DB::update($this->_table, $data, 'id = ' . $id);
    }

    public function findAllOrderByDateline()
    {
        $sql = 'select * from ' . $this->_table . ' order by dateline desc';
        return DB::findAll($sql);
    }

    public function del($id)
    {
    	return DB::delete($this->_table, "id = " . $id);
    }
}
