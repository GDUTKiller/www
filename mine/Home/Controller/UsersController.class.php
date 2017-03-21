<?php
namespace Home\Controller;
use Think\Controller\RestController;

class UsersController extends RestController {
    /**
     * 获取用户信息
     * GET host/users/mobile
     * @return $_GET['mobile'] 手机号码
     */
    public function getInfo() {
        $Users = D('Users');
        if(!$Users->acc()) {
            $this->response(array('success'=>false, 'info'=>'you are not login'), 'json');
        }
        echo 'true';
    }

    /**
     * 更新用户信息
     * @param  PUT请求 host/users
     * @return [type] [description]
     */
    public function update() {
        echo 'update';
        echo I('id');
        echo I('name');
        // parse_str(file_get_contents('php://input'), $_PUT);
        // var_dump($_PUT);
    }

    /**
     * 注册用户
     * POST请求 host/users
     * @return json
     */
    public function register() {
        $Users = D('Users');
        if(!$Users->create()) {
            $this->response(array('success'=>true,'info'=>$Users->getError()), 'json');
        }
        if($Users->reg()) {
            $this->response(array('success'=>true), 'json');
        } else {
            $this->response(array('success'=>false), 'json');
        }
    }

    /**
     * 用户登录
     * POST请求 host/session
     * @return json
     */
    public function login() {
        $Users = D("Users"); // 实例化User对象
        if (!$Users->create($_POST, 4)){ // 登录验证数据
            // 验证没有通过 输出错误提示信息
            $this->response(array('success'=>false, 'info'=>$Users->getError()), 'json');
        }else{
            $Users->where(array('mobile'=>I('mobile') ) )->find();
            $Users->auth();
            $this->response(array('success'=>true), 'json');
        }
    }

    /**
     * 用户注销
     * DELETE请求 host/session
     * @return [type] [description]
     */
    public function logout() {
        D('Users')->revoke();
        $this->response(array('success'=>true), 'json');
    }
}