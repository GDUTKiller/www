<?php
require('./lib/init.php');
$art_id = $_GET['art_id'];
$sql = "DELETE FROM art WHERE art_id = $art_id";
if(!mQuery($sql)) {
    error('删除失败');
} else {
    //succ('删除成功');
    header("Location:artlist.php");
}
?>