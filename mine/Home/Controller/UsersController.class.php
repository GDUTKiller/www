<?php
namespace Home\Controller;
use Think\Controller\RestController;

class UsersController extends RestController {
    //获取用户信息，
    //@param $_GET['mobile'] 用户手机号
    public function getInfo() {
        echo 'get' . I('mobile'). I('status');
    }

    /**
     * 更新用户信息
     * @param  put参数 [description]
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
     * @return $_POST [description]
     */
    public function register() {
        echo 'post';
        echo I('id');
    }
}