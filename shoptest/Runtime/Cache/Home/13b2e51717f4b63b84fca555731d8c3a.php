<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <h1><?php echo ($a); ?></h1>
    <form action="<?php echo U('Home/User/ff');?>" method="post">
        <input type="text" name="id" value="">
        <input type="submit" value="Click Me!!!">
    </form>

</body>
</html>