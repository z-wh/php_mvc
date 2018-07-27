<?php
class AdminController
{
    /**
     * 用于保存用户信息
     * @var array
     */
    private $auth;

    /**
     * 首先检查session中是否有登陆信息。
     * 如果否，则跳转到login界面。
     * 如果是，则将用户信息存入$auth供以后页面需要使用到用户信息时读取调用。
     */
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

    /**
     * 如果没有submit动作，则跳转到login界面
     * 如果有，则开始用户名密码验证
     * @return [type] [description]
     */
    public function login()
    {
        if (empty($_POST["submit"])) {
            VIEW::display("admin/login.html");
        } else {
            $this->checkLogin();
        }
    }

    /**
     * 退出用户登陆
     * 清空session,清空auth
     * 跳转到login界面
     * @return [type] [description]
     */
    public function logout()
    {
        unset($_SESSION["auth"]);
        $this->showMessage("您已退出登陆！", "admin.php?controller=Admin&method=login");
    }

    /**
     * 如果没有提交“用户名”、“密码”则跳转到login界面重新填写
     * 如果有，则进行验证逻辑
     * 验证成功，则将用户信息存入auth并跳转到后台管理页面
     * 失败，跳转到login页面
     * @return [type] [description]
     */
    public function checkLogin()
    {
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $this->showMessage("信息未填写完整，请重新登陆", "admin.php?controller=Admin&method=login");
        } else {
            $username = daddsalashes($_POST["username"]);
            $password = daddsalashes(md5($_POST["password"]));
            $authobj  = M("Auth");
            if ($this->auth = $authobj->checkAuth($username, $password)) {
                $_SESSION["auth"] = $this->auth;
                $this->showMessage("登陆成功！", "admin.php?controller=Admin&method=index");
            } else {
                $this->showMessage("登陆失败，请重新登陆", "admin.php?controller=Admin&method=login");
            }
        }

    }

    /**
     * 调用NewsModel，查询新闻条数
     * 跳转到后台管理页面
     * @return [type] [description]
     */
    public function index()
    {
        $newsobj = M("News");
        $newsnum = $newsobj->count();
        $data    = array('newsnum' => $newsnum);
        VIEW::assign($data);
        VIEW::display("admin/index.html");
    }

    /**
     * 如果没有submit，并且有id,则先根据id查找新闻数据
     * 附值到页面，进行展示
     * 如果有submit动作，则开始添加新闻动作
     * @return [type] [description]
     */
    public function newsAdd()
    {
        if (!isset($_POST["submit"])) {
            $data = $this->getNewsInfo();
            VIEW::assign(array('data' => $data));
            VIEW::display("admin/newsadd.html");
        } else {
            $this->newsSubmit();
        }
    }

    /**
     * 添加或更新新闻操作
     * 如果没有填“标题”或“内容”，则跳转要求填写
     * 如果有id字段，则执行更新操作
     * 如果没有id字段，则执行新增操作
     * @return [type] [description]
     */
    public function newsSubmit()
    {
        extract($_POST);
        if (empty($_POST["title"]) || empty($_POST["content"])) {
            $this->showMessage("请先填写标题和内容！", "admin.php?controller=Admin&method=newsAdd");
        }
        $title   = daddsalashes($title);
        $content = daddsalashes($content);
        $author  = daddsalashes($author);
        $from    = daddsalashes($from);
        $data    = array(
            'title'    => $title,
            'content'  => $content,
            'author'   => $author,
            'from'     => $from,
            'dateline' => time());
        $newsobj = M("News");
        if ($_POST["id"] != "") {
            $newsobj->update($data, intval($_POST["id"]));
            $this->showMessage("更新成功！", "admin.php?controller=Admin&method=newsList");
        } else {
            $newsobj->insert($data);
            $this->showMessage("添加成功！", "admin.php?controller=Admin&method=newsList");
        }
    }

    /**
     * 根据id获取新闻内容数据
     * @return array 数组形式的新闻数据
     */
    public function getNewsInfo()
    {
        if (isset($_GET["id"])) {
            $newsobj     = M("News");
            return $data = $newsobj->findOneById($_GET["id"]);
        } else {
            return array();
        }

    }

    /**
     * 获取新闻数据到展示列表页
     * @return [type] [description]
     */
    public function newsList()
    {
        $data = $this->getNewsList();
        VIEW::assign(array("data" => $data));
        VIEW::display("admin/newslist.html");
    }

    /**
     * 按时间倒序排列获取所有新闻数据
     * @return array 新闻数据数组
     */
    public function getNewsList()
    {
        $newsobj = M("News");
        return $newsobj->findAllOrderByDateline();
    }

    /**
     * 删除新闻
     * @return [type] [description]
     */
    public function newsDel()
    {
        $newsobj = M("News");
        $newsobj->del($_GET["id"]);
        $this->showMessage("删除成功", "admin.php?controller=Admin&method=newsList");
    }

    /**
     * 弹窗提示信息并跳转
     * @param  String $info 提示信息文字
     * @param  String $url  要跳转到的页面url
     * @return [type]       [description]
     */
    public function showMessage($info, $url)
    {
        echo "<script>alert('$info');window.location.href='$url'</script>";
        exit;
    }

}
