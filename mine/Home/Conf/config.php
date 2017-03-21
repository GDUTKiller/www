<?php
return array(
	//'配置项'=>'配置值' //
    'URL_ROUTER_ON'         =>  true,
    'URL_ROUTE_RULES'       =>  array(
        // GET users/手机号 获取用户信息
        array('/^users\/1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])\d{8}$/', 'Users/getInfo?mobile=:1', 'status=1', array('method'=>'get')),
        // PUT users/数字 更新用户信息
        array('/^users\/([1-9]\d*)$/', 'Users/update?id=:1', 'status=1', array('method'=>'put')),
        // POST users 新添加用户
        array('/^users$/', 'Users/register', 'status=1', array('method'=>'post')),
        // POST session 登录
        array('/^session$/', 'Users/login', '', array('method'=>'post')),
        // DELETE session 注销
        array('/^session$/', 'Users/logout', '', array('method'=>'delete')),
    ),
);