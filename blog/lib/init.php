<?php
/**
*author 杨己乐 2017/1/13
*
*/

header('Content-type:text/html;charset=utf8');
define('ROOT', dirname(__DIR__));

require(ROOT . '\lib\mysql.php');
require(ROOT . '\lib\func.php');
require(ROOT . '\lib\Mysql.class.php');

//过滤非法字符
$_GET = _addslashes($_GET);
$_POST = _addslashes($_POST);
$_COOKIE = _addslashes($_COOKIE);

?>