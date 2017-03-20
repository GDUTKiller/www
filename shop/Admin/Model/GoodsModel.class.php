<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class GoodsModel extends RelationModel {
    protected $_link = array(
        'comment' => self::HAS_MANY,
    );
    //protected $insertFields = 'goods_name,goods_sn,goods_desc';
    protected $_auto = array(
        //array(完成字段1,完成规则,[完成条件,附加规则]),
        array('add_time', 'time', 3, 'function'),
    );
    protected $_validate = array(
        //array('goods_name', '1,12', '长度不对', 1, 'length', 3),
        //array('shop_price', 'pr', 'shop_price错了', 1, 'callback', 3),
    );
    public function pr() {
        return true;
    }

}