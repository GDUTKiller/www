<?php
namespace Home\Model;
use Think\Model;
class CaptchasModel extends Model {
    protected $_validate = array(
        array('mobile', '/^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\d{8}$/', 'mobile format is wrong', 1, 'regex', 3),
    );

    public function randStr($length = 6) {
        $str = '01234567890123456789';
        return substr(str_shuffle($str), 0, $length);
    }
}