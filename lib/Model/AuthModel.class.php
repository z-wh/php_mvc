<?php
// 认证用户是否正确存在业务逻辑模型
class AuthModel
{

    public function checkAuth($username, $password)
    {
        $adminobj = M("Admin");
        $auth     = $adminobj->find_user_by_username($username);
        // 如果用户存在并且密码正确，就返回查到的用户，否则返回失败
        if (!empty($auth) && $auth["password"] == $password) {
            return $auth;
        } else {
            return false;
        }
    }
}
