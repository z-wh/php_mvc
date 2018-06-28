<?php
class VIEW
{
    public static $view;

    public static function init($viewType, $configs)
    {
        // 实例化视图引擎
        self::$view = new $viewType();
        // 设置参数
        foreach ($configs as $key => $value) {
            self::$view->$key = $value;
        }
    }

    public static function assign($data)
    {
        foreach ($data as $key => $value) {
            self::$view->assign($key, $value);
        }
    }

    public static function display($template)
    {
        self::$view->display($template);
    }
}
