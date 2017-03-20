<?php
// $fp = fsockopen("localhost", 80, $errno, $errstr, 30);
// if (!$fp) {
//     echo "$errstr ($errno)<br />\n";
// } else {
//     $out = "GET /http/3.html HTTP/1.1\n";
//     $out .= "Host: localhost\n";
//     $out .= "Connection: Close\n\n";
//     fwrite($fp, $out);
//     while (!feof($fp)) {
//         echo fgets($fp, 128);
//     }
//     fclose($fp);
// }





$fk = fsockopen('localhost', 80, $errno, $errstr, 30);

if(!$fk) {
    echo "$errstr ($errno)<br />\n";
}

$s = array(
    'GET /http/3.html HTTP/1.1',
    'host: localhost',
    'Conection: Close',
    '',
    ''
    );


$str = implode("\n", $s);
echo $str;
fwrite($fk, $str);

while($row = fread($fk, 32) ) {
    echo $row;
}
fclose($fk);
?>