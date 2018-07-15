<?php
header("Content-type:text/html;charset=utf-8");
require_once "configs.php";
require_once "framework/MVC.php";
MVC::run($configs);