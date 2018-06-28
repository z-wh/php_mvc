<?php

/**
 * 控制器调用函数
 * @param string $name   控制器名
 * @param string $method 方法名
 */
function C($name, $method)
{
    require_once 'lib/Controller/' . $name . 'Controller.class.php';
    $controller = $name . "Controller";
    $obj        = new $controller();
    $obj->$method();
}

/**
 * 模型调用函数
 * @param string $name   Model名
 * @param string $method 方法名
 */
function M($name)
{
    require_once 'lib/Model/' . $name . 'Model.class.php';
    $model = $name . "Model";
    return new $model();
}

/**
 * 第三方类库实例化函数
 * @param string $path   类库路径
 * @param string $name   类库名称
 * @param array  $params 类库参数构成的数组
 */
function ORG($path, $name, $params = array())
{
    require_once 'lib/ORG/' . $path . $name . 'class.php';
    $org = $name . 'class.php';
    $obj = new $org();
    if (!empty($params)) {
        foreach ($params as $key => $value) {
            $obj->$key = $value;
        }
    }

    return $obj;
}

/**
 * 为了安全，对接收到的字符串进行转义
 * 首先判断魔法符号是否打开（打开会自动进行转义)，如果没打开就对字符串进行转义
 * @param  string $str [description]
 * @return [type]         [description]
 */
function daddsalashes($str)
{
    return (!get_magic_quotes_gpc()) ? addslashes($str) : $str;
}
