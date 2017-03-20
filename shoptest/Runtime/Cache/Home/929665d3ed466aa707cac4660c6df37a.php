<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="/shop/Public/jile.css" />
    <script type="text/javascript" src="/shop/Public/jile.js"></script>
</head>
<body>
    <h1>
        <?php if(is_array($ff)): foreach($ff as $key=>$v): echo ($v["title"]); ?><br><?php endforeach; endif; ?>
    </h1>
</body>
</html>