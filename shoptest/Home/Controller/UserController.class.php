<?php
namespace Home\Controller;
use Think\Controller;

class UserController extends Controller {
    public function add() {
        $a = 123;
        $this->assign('a', $a);
        $this->display();
    }

    public function ff() {
        $a = I('id');
        echo $a;
        exit;
        $a = new \Home\Model\UserModel();
        //$a->papa();
        //面向过程风格
        //$a->add(['name'=>'yjl', 'nick'=>'yjl']);
        //面向对象风格
        $a->name = 'yasuo';
        $a->nick = 'tuoersuo';
        var_dump($a->add());
    }

    public function cha() {
        $userModel = new \Home\Model\UserModel();
        var_dump($userModel->limit(1, 2)->order('nick desc')->field('name')->where('user_id<6')->select());
    }
}
