<meta charset="utf8">
<?php
require('./lib/init.php');

$cat_id = $_GET['cat_id'];

//连接数据库
$conn = mConn();


//检测 栏目id 是否为数字
//var_dump($cat_id);
if(!is_numeric($cat_id)) {
    echo '栏目不合法';
    exit();
}

//检测 栏目是否存在
$sql = "SELECT COUNT(*) FROM cat WHERE cat_id = $cat_id";
$rs = $conn->query($sql);
if($rs->fetch_row()[0] == 0) {
    echo '栏目不存在';
    exit();
}

if(empty($_POST)){
    $sql = "SELECT catname FROM cat WHERE cat_id = $cat_id";
    $cat = mGetRow($sql);
    require('./view/admin/catedit.html');
} else {
    $sql = "UPDATE cat SET catname = '$_POST[catname]' WHERE cat_id = $cat_id";
    if(!$conn->query($sql)){
        echo '栏目修改失败';
    } else {
        echo '栏目修改成功';
    }
}


?>