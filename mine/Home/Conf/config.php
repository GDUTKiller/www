<?php
return array(
	//'配置项'=>'配置值' //
    'URL_ROUTER_ON'         =>  true,
    'URL_ROUTE_RULES'       =>  array(
        // users/手机号 获取用户信息
        array('/^users\/(1(3|4|5|7|8)[0-9]\d{8})$/', 'Users/getInfo?mobile=:1', 'status=1', array('method'=>'get')),
        // users/数字 更新用户信息
        array('/^users\/([1-9]\d*)$/', 'Users/update?id=:1', 'status=1', array('method'=>'put')),
        // users 新添加用户
        array('/^users$/', 'Users/register', 'status=1', array('method'=>'post')),
    ),
);