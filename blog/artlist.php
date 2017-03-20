<?php
require('./lib/init.php');

if(!acc()) {
    header('Location:login.php');
    die();
}

$sql = "SELECT art.*, cat.catname FROM art, cat WHERE art.cat_id = cat.cat_id;";
$art = mGetAll($sql);
include(ROOT . '/view/admin/artlist.html');
?>