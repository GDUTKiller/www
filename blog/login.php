<?php
require('./lib/init.php');
if(empty($_POST)) {
    include(ROOT . '/view/front/login.html');
} else {
    $name = trim($_POST['name']);
    if(empty($name)) {
        error('请输入用户名');
    }
    $password = trim($_POST['password']);
    if(empty($password)) {
        error('请输入密码');
    }
    $password= trim($_POST['password']);
    $sql = "SELECT  * FROM user WHERE name = '" . $name . "' AND password = '" . $password . "'";
    $rs = mGetRow($sql);
    print_r($rs);
    if(!$rs) {
        error('密码或用户名错误'. $rs);
    } else {
        setcookie('name', $rs['name']);
        header("Location:artlist.php");
    }
}
?>