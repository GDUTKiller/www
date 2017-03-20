<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $catModel = D('Admin/Cat');
        $this->assign('cattree', $catModel->gettree());

        $this->assign('hot', D('Admin/goods')->where('is_hot=1')->limit('0,4')->order('goods_id desc')->select());
        $this->assign('his', array_reverse(session('history'), true));
        $this->display();
    }
}