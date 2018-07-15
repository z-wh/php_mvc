<?php

$configs = array(

    "dbConfig"   => array(
        "dbType"     => "MysqliDB",
        "dbHost"     => "localhost",
        "dbUser"     => "root",
        "dbPassword" => "root123",
        "dbName"     => "newsreport",
        "dbCharset"  => "utf8"),
    "viewConfig" => array(
        "left_delimiter"  => "{",
        "right_delimiter" => "}",
        "template_dir"    => "tpl",
        "compile_dir"     => "data/tpl_c",
    ),
);
