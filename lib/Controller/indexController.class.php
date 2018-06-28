<?php
class indexController
{
    public function index()
    {
        $sql = "select * from imooc_user";
        // $rs  = DB::findAll($sql);
        // foreach ($rs as $value) {
        //     foreach ($value as $k => $v) {
        //     	echo $k." = ".$v." ";
        //     }
        //     echo "<br/>";
        // }
    }
}
