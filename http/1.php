<?php
echo move_uploaded_file($_FILES['intro']['tmp_name'], './'.$_FILES['intro']['name']) ? 1 : 0;
/**
文件上传
POST /http/1.php HTTP/1.1
host:localhost
Content-type:multipart/form-data,boundary=AaB03X
Content-length:140

--AaB03X
Content-Disposition: form-data; name="intro"; filename="a.txt"
Content-Type: text/plain

ni hao my intro
--AaB03X--
**/
?>