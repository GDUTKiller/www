<?php
require('./lib/init.php');

//如果cat_id不是数字，跳转到首页
if(!is_numeric($_GET['art_id'])) {
    header('Location:index.php');
    die();
}

    $art_id = $_GET['art_id'];
    $sql = "SELECT title, content, pubtime, catname, comm, pic, thumb FROM art LEFT JOIN cat ON art.cat_id = cat.cat_id WHERE art_id = " . $art_id;
$art = mGetRow($sql);

if(empty($art)) {
    header('Location:index.php');
    die();
}

$sql = "SELECT * FROM cat";
$cat = mGetAll($sql);

//如果post非空，有评论
if(!empty($_POST)) {
    $comm = array();
    $comm['art_id'] = $art_id;
    $comm['nick'] = $_POST['nick'];
    $comm['content'] = $_POST['content'];
    $comm['email'] = $_POST['email'];
    $comm['pubtime'] = time();

    //来访者ip
    $comm['ip'] = sprintf('%u', ip2long(getIp()));

    //插入的评论返回结果
    $rs = mExec('comment', $comm);

    //每增加一条评论，art表的comm字段+1
    $sql = "UPDATE art SET comm = comm + 1 WHERE art_id = " . $art_id;
    mQuery($sql);
    //返回到上一页
    $ref = $_SERVER['HTTP_REFERER'];
    header("Location:" . $ref);
}

//取出所有评论
$sql = "SELECT * FROM comment WHERE art_id = " . $art_id;
$comment = mGetAll($sql);

include(ROOT . '/view/front/art.html');
?>