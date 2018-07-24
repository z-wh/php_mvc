<?php
class AdminController
{
    private $auth;

    public function __construct()
    {
        session_start();
        //如果session中没有auth存在，并且不是在登陆，则跳转到登陆界面
        if (!isset($_SESSION["auth"]) && MVC::$method != "login") {
            $this->showMessage("没有登陆,请先登陆", "admin.php?controller=Admin&method=login");
        } else {
            $this->auth = isset($_SESSION["auth"]) ? $_SESSION["auth"] : array();
        }
    }

    public function login()
    {
        if (empty($_POST["submit"])) {
            VIEW::display("admin/login.html");
        } else {
            $this->checkLogin();
        }
    }

    public function checkLogin()
    {
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $this->showMessage("信息未填写完整，请重新登陆", "admin.php?controller=Admin&method=login");
        } else {
            $username = daddsalashes($_POST["username"]);
            $password = daddsalashes(md5($_POST["password"]));
            $authobj = M("Auth");
            if($this->auth = $authobj->checkAuth($username, $password)){
                $_SESSION["auth"] = $this->auth;
                $this->showMessage("登陆成功！","admin.php?controller=Admin&method=index");
            }else{
                $this->showMessage("登陆失败，请重新登陆", "admin.php?controller=Admin&method=login");
            }
        }

    }

    public function index()
    {
        $newsobj = M("News");
        $newsnum = $newsobj->count();
        $data = array('newsnum' => $newsnum, );
        VIEW::assign($data);
        VIEW::display("admin/index.html");
    }

    public function showMessage($info, $url)
    {
        echo "<script>alert('$info');window.location.href='$url'</script>";
        exit;
    }
}
