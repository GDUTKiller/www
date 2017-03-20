<?php
// if(!isset($_COOKIE['num123'])) {
//     $num = 1;
//     setcookie('num123', $num);
// } else {
//     $num = $_COOKIE['num123'] + 1;
//     setcookie('num123', $num);
// }
// echo $num, '<br>';
// print_r($_COOKIE);



setcookie('sec', '!!!', time()+60);
setcookie('test', '888');
setcookie('test2', '666', time()+60, '/');
?>