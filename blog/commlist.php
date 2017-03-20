<?php
require('./lib/init.php');
$sql = "SELECT * FROM comment ORDER BY comment_id DESC";
$comm = mGetAll($sql);
include(ROOT . '/view/admin/commlist.html');
?>