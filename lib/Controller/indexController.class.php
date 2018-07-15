<?php
class indexController
{
    public function index()
    {
        VIEW::assign(array("tittle" => "第一个smarty模板", "author" => "zwh"));
        VIEW::display("admin/test.html");
    }
}
