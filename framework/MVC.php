<?php
$currentdir = dirname(__file__);
require_once $currentdir . '\inculde.list.php';
foreach ($paths as $path) {
    require_once $currentdir . '/' . $path;
}

class MVC
{
    public static $controller;
    public static $method;
    private static $configs;

    /**
     * 初始化连接数据库
     * @return [type] 无返回值
     */
    private static function init_db()
    {
        DB::init(self::$configs['dbConfig']);
    }

    /**
     * 实例化视图引擎
     * @return [type] 无返回值
     */
    private static function init_view()
    {
        VIEW::init("Smarty", self::$configs['viewConfig']);
    }

    /**
     * 初始化controller
     * 如果用户传了controller,则将其转义后接收
     * 如果用户没传，则使用index
     */
    private static function init_controller()
    {
        self::$controller = isset($_GET["controller"]) ? daddsalashes($_GET["controller"]) : "index";
    }

    /**
     * 初始化method
     * 如果用户传了method,则将其转义后接收
     * 如果用户没传，则使用index
     */
    private static function init_method()
    {
        self::$method = isset($_GET["method"]) ? daddsalashes($_GET["method"]) : "index";
    }

    public static function run($configs)
    {
        self::$configs = $configs;
        MVC::init_db();
        MVC::init_view();
        MVC::init_controller();
        MVC::init_method();
        C(self::$controller, self::$method);
    }
}
