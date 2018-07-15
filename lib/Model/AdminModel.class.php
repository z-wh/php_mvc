<?php
// 查找admin数据模型
class AdminModel
{
    private $table = "admin";

    public function find_user_by_username($username)
    {
        $sql = 'select * from ' . $this->table . ' where username = "'. $username.'"';
        return DB::findOne($sql);
    }
}
