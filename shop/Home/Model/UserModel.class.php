<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model {
    //自动验证
    protected $_validate = array(
        array('username', '/\w{6,16}/', '用户名6-16位，数字字母下划线组成', 1, 'regex', 3),
        array('email', 'email', 'email`s format is wrong', 1, '', 3),
        array('password', '6,16', '密码在6-16位', 1, 'length', 3),
        array('repwd', 'password', 'two password is the same', 1, 'confirm', 3),
        array('username', '', '用户名已经存在了', 1, 'unique', 3)
    );

    public function reg() {
        $this->encPass();
        return $this->add();
    }

    /**
    * 对明文密码加盐md5
    * @return 加密后的md5密码
    */
    protected function encPass() {
        $this->salt();
        return $this->password = md5($this->password . $this->salt);
    }

    /**
    * 创建用户的盐
    * @return 盐
    */
    public function salt() {
        if(!$this->salt) {
            $this->salt = $this->randStr();
        }
        return $this->salt;
    }

    /**
    * @return 一个混乱的字符串
    */
    protected function randStr($length = 8) {
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        return substr(str_shuffle($str), 0, $length);
    }

    /**
    * 判断密码是否正确
    * @return bool
    */
    public function checkPass($password) {
        //原本的密码
        $selfpass = $this->password;
        //将密码改为传进来的密码
        $this->password = $password;
        //检测原来的密码和加密后的密码是否相同
        if($selfpass === $this->encPass()) {
            return true;
        } else {
            //将密码改回原来的密码
            $this->password = $selfpass;
            return false;
        }
    }

    /**
    * 登录
    */
    public function auth() {
        cookie('user_id', $this->user_id);
        cookie('username', $this->username);
        cookie('ccode', encCookie($this->user_id, $this->username));
        return true;
    }

    /**
    * 退出登录
    */
    public function revoke() {
        cookie('user_id', null);
        cookie('username', null);
    }

    /**
    * 加密cookie
    */
    function encCookie($user_id, $username) {
        return md5($user_id . '|' . $username . '|' . C('COO_KEY'));
    }
}