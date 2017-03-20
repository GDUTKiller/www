<?php
require('./lib/init.php');

$sql = "select * from cat";
$rs = mConn()->query($sql);
$cat = array();
while($row = $rs->fetch_assoc()) {
    $cat[] = $row;
}
require('./view/admin/catlist.html');
?>