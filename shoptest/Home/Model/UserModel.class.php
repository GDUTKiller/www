<?php
namespace Home\Model;
use  Think\Model;

class UserModel extends Model {
    public function papa() {
        $arr = array('name' => 'yjl1', 'nick'  => 'yjl1' );
        $this->add($arr);
    }
}