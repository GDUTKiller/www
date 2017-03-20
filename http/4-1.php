<?php
$fk = fsockopen("localhost", 80, $errno, $errstr, 5);

$str = array(
    'GET /http/4.php HTTP/1.1',
    'host:localhost',
    'cookie:name=admin',
    '',
    ''
    );
$str = implode("\n", $str);
fwrite($fk , $str);
while($row = fread($fk, 32)) {
    echo $row;
}
fclose($fk);
?>