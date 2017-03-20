<?php
require('./lib/init.php');
$art_id = $_GET['art_id'];

if(!is_numeric($art_id)) {
    error("art_id不是数字");
    die();
}
$sql = "SELECT COUNT(*) FROM art WHERE art_id = " . $art_id;
if(mGetOne($sql) == 0) {
    error("文章不存在");
    die();
}

if(empty($_POST)) {
    $sql = "SELECT * FROM art WHERE art_id = $art_id";
    $art = mGetRow($sql);
    $sql = "SELECT * FROM cat";
    $cat = mGetAll($sql);
    $sql = "SELECT tag FROM tag WHERE art_id = $art_id";
    $tag = mGetAll($sql);
    $tags = '';
    foreach ($tag as $t) {
        $tags .= $t['tag'] . ',';
    }
    $tags = rtrim($tags, ',');
    include(ROOT . '/view/admin/artedit.html');
} else {
    //检测art_id是否为数字
    if(!is_numeric($art_id)) {
        error("art_id不是数字");
    }

    //检测title是否为空
    if(empty($art['title'] = trim($_POST['title']))) {
        error('标题不能为空');
    }

    //检测cat_id是否为数字
    if(!is_numeric($art['cat_id'] = $_POST['cat_id'])) {
        error('栏目不为数字');
    }

    //检测内容是否为空
    if(empty($art['content'] = trim($_POST['content']))) {
        error('内容不能为空');
    }

    //检测是否有这篇文章
    $sql = "SELECT COUNT(*) FROM art WHERE art_id = " . $art_id;
    if(!mGetOne($sql)) {
        error('没有这篇文章');
    }

    //发布时间
    $art['lastup'] = time();
    $art['arttag'] = trim($_POST['tags']);

    //发布文章
    if(!mExec('art', $art, 'update', 'art_id='.$art_id)) {
        error('文章修改失败');
    } else {
        //修改标签
        //如果没有tags,无则文章修改成功
        $tags = $_POST['tags'];
        if(empty($tags)) {
            succ('文章修改成功');
        } else {
            //删除原标签，添加新标签
            $sql = "DELETE FROM tag WHERE art_id = " . $art_id;
            mQuery($sql);

            //添加新标签
            $tags = explode(",", $tags);
            $sql = "INSERT INTO tag (art_id, tag) VALUES ";
            foreach ($tags as $v) {
                $sql .= "(" . $art_id . ",'" . $v . "'),";
            }
            $sql = rtrim($sql, ',');
            if(!mQuery($sql)) {
                error("文章修改成功，但标签修改失败");
            } else {
                succ("文章修改成功");
            }
        }
    }
}
?>