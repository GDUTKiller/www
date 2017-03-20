<?php
require('./lib/init.php');
$comment_id = $_GET['comment_id'];
//获取当前评论的art_id;
$sql = "SELECT art_id FROM comment WHERE comment_id = " . $comment_id;
$art_id = mGetOne($sql);

//删除这条评论
$sql = "DELETE FROM comment WHERE comment_id = " . $comment_id;
$rs = mQuery($sql);

//如果获取art_id成功
if($art_id) {
    $sql = "UPDATE art SET comm = comm - 1 WHERE art_id = " . $art_id;
    mQuery($sql);
}

//跳转到上一页
$ref = $_SERVER['HTTP_REFERER'];
header("Location: $ref");
?>