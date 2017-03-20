<?php
require('./lib/init.php');
$sql = "SELECT * FROM cat";
$cat = mGetAll($sql);

if(empty($_POST)) {
    include(ROOT . '/view/admin/artadd.html');
} else {
    //检测标题
    $art['title'] = trim($_POST['title']);
    if(empty($art['title'])) {
        error('标题不能为空');
    }


    print_r($_POST['cat_id']);
    //检测栏目
    $art['cat_id'] = $_POST['cat_id'];
    if(!is_numeric($art['cat_id'])) {
        error('栏目不为数字');
    }

    //检测内容
    $art['content'] = trim($_POST['content']);
    if(empty($art['content'])) {
        error('内容不能为空');
    }

    //文章发布时间
    $art['pubtime'] = time();

    //如果有上传文件且上传成功
    if(!empty($_FILES) && $_FILES['pic']['error'] == 0) {
        //相对路径
        $des = createDir() . '/' . randStr() . getExt($_FILES['pic']['name']);
        if(move_uploaded_file($_FILES['pic']['tmp_name'], ROOT.$des) ) {
            $art['pic'] = $des;
            //缩略图
            $art['thumb'] = makeThumb($des);
        }
    }

    if(!mExec('art', $art)) {
        error('文章发布失败');
    } else {
        //文章发布成功后，cat表的num+1
        $sql = "UPDATE cat SET num = num + 1 WHERE cat_id = " . $art['cat_id'];
        mQuery($sql);
        //判断如果没有tag则文章发布成功
        $tag = trim($_POST['tag']);
        if(empty($tag)) {
            succ('文章发布成功');
        } else {
            //获取文章id
            $art_id = getLastId();
            //将str tag拆成索引数组
            $tag = explode(',', $tag);
            $sql = "INSERT INTO tag (art_id, tag) VALUES";
            foreach ($tag as $v) {
                $sql .= '(' . $art_id . ',"' . $v . '"),';
            }
            $sql = rtrim($sql, ',');

            //插入tag表
            if(!mQuery($sql)) {
                $sql = "DELETE FROM art WHERE art_id = " . $art_id;
                mQuery($sql);
                error('标签插入失败');
            } else {
                succ('文章发布成功');
            }
        }
    }
}
?>