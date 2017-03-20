<?php
namespace Home\Controller;
use  Think\Controller;

class UserController extends Controller {
    //登录
    public function login() {
        if(IS_POST) {
            $cond = array('username' => I('post.username'));
            $user = D('Home/User');

            $code = I('post.yzm');
            $verify = new \Think\Verify();
            if(!$verify->check($code)) {
                $this->error('验证码错误', U('Home/User/login', 3));
            }
            if(!$user->where($cond)->find()) {
                $this->error('用户名不存在', U('Home/User/login', 3));
            }

            else if(!$user->checkPass(I('post.password'))) {
                $this->error('密码错误', U('Home/User/login', 3));
            }
            else {
                $user->auth();
                $this->success('登录成功', '/', 3);
            }
        } else {
            $this->display();
        }
    }

    public function msg() {
        $this->display();
    }

    //验证码
    public function yzm() {
        $Verify = new  \Think\Verify();
        $Verify->fontSize = 20;
        $Verify->length = 3;
        $Verify->imageH = 0;
        $Verify->imageW = 0;
        $Verify->entry();
    }

    public function logout() {
        D('User')->revoke();
        $this->redirect('/');
    }

    //注册
    public function reg() {
        if(IS_POST) {
            $userModel = D('User');
            if(!$userModel->create()) {
                $this->error($userModel->getError(),U('Home/User/reg'),3);
            }
            if($user_id = $userModel->reg()) {
                $userModel->find($user_id);
                $userModel->auth();
                $this->success('注册成功', U('Home/Index/index'), 3);
            } else {
                $this->error('注册失败\n'.$userModel->getError(),U('Home/User/reg'),3);
            }

        } else {
            $this->display();
        }
    }
}