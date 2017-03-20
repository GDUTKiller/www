<?php
require('./lib/init.php');

$cat_id = $_GET['cat_id'];
$conn = mConn();

if(!is_numeric($cat_id)) {
    echo "栏目不合法";
    die();
}

$sql = "SELECT COUNT(*) FROM cat WHERE cat_id = $cat_id";
$rs = $conn->query($sql);
//检测栏目是否存在
if($rs->fetch_row()[0] == 0) {
    echo "栏目不存在";
    die();
}

//检测栏目下是否有文章
$sql = "SELECT COUNT(*) FROM art WHERE cat_id = $cat_id";
$rs = $conn->query($sql);
if($rs->fetch_row()[0] != 0) {
    echo "栏目下还有文章，不能删除！";
    die();
}

//检测完毕,删除栏目
$sql = "DELETE FROM cat WHERE cat_id = $cat_id";
if(!$conn->query($sql)) {
    echo '栏目删除失败';
} else {
    echo '栏目删除成功';
}
?>