<?php
// 查找admin数据模型
class AdminModel
{
    private $_table = "admin";

    /**
     * 查找用户是否存在
     * @param  string $username 用户名
     * @return array           数组形式的用户信息
     */
    public function find_user_by_username($username)
    {
        $sql = 'select * from ' . $this->_table . ' where username = "'. $username.'"';
        return DB::findOne($sql);
    }
}
