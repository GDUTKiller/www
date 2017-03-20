<?php
namespace Home\Model;
use Think\Model;
class CommentModel extends Model {
   protected $_validate = array(
        //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        array('email', 'email', 'email格式不正确', 1, '', 3),
        array('content','3,200','长度在3到200之间', 1, 'length', 3),
    );
}