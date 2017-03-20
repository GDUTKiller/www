<?php

require('./lib/init.php');

if(empty($_POST)) {
    include(ROOT . '/view/admin/catadd.html');
} else {
    $cat['catname'] = trim($_POST['catname']);
    if(empty($cat['catname'])) {
        error('栏目不能为空');
        exit();
    }

    $sql = "SELECT COUNT(*) FROM cat WHERE catname = '$cat[catname]'";
    //$rs = mQuery($sql);
    if(mGetOne($sql) != 0) {
        error('栏目已经存在');
        exit();
    }
    if(!mExec('cat' , $cat)) {
        //echo '栏目插入失败';
        echo mConn()->error;
    } else {
        //echo '栏目插入成功';
        succ('栏目插入成功');
    }
}

?>