<?php
require('./lib/init.php');

//如果选择了栏目id，查询数据库时加上该条件
if(isset($_GET['cat_id'])) {
    $where = ' and art.cat_id = ' . $_GET['cat_id'];
} else {
    $where = '';
}

//计算分页代码
$sql = "SELECT COUNT(*) FROM art WHERE 1" . $where;
$num = mGetOne($sql);
$cnt = 1;//每页显示文章数1
$curr = isset($_GET['page']) ? $_GET['page'] : 1;//当前页码
$pagers = cPager($num, $cnt, $curr);



$sql = "SELECT art_id, art.cat_id, user_id, nick, pubtime, title, content, cat.catname, comm, arttag, thumb FROM art LEFT JOIN cat ON art.cat_id = cat.cat_id WHERE 1 " . $where . " ORDER BY art_id DESC LIMIT " .
    ($curr - 1)*$cnt . "," . $cnt;
$art = mGetAll($sql);

$sql = "SELECT * FROM cat";
$cat = mGetAll($sql);

require(ROOT . '/view/front/index.html');

?>