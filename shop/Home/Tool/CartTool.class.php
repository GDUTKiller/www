<?php
namespace Home\Tool;
abstract class ACartTool {
    /**
     * 向购物车中添加一个商品
     * @param int $goods_id   [description]
     * @param string $goods_name [description]
     * @param float $shop_price [description]
     * @return  boolean
     */
    abstract public  function add($goods_id, $goods_name, $shop_price);

    /**
     * 减少购物车中一个商品的数量，如果减至0，从购物车中删除此商品
     * @param  int $goods_id [description]
     * @return [type]           [description]
     */
    abstract public function decr($goods_id);

    /**
     * 从购物车中删除某商品
     * @param  [type] $goods_id [description]
     * @return [type]           [description]
     */
    abstract public function del($goods_id);

    /**
     * 列出购物车中所有商品
     * @return array           [description]
     */
    abstract public function items();

    /**
     * 返回购物车中有几种商品
     * @return int [description]
     */
    abstract public function calcType();

    /**
     * 返回购物车中商品的个数
     * @return [type] [description]
     */
    abstract public function calcCnt();

    /**
     * 返回购物车中商品的价格
     * @return float [description]
     */
    abstract public function calcMoney();

    /**
     * 清空购物车
     * @return void [description]
     */
    abstract public function clear();
}

class CartTool extends ACartTool {
    public static $ins = null;
    public $item = array();

    final protected function __construct() {
        if(session('cart')) {
            $this->item = session('cart');
        }
    }

    public static function getIns() {
        if(self::$ins === null) {
            self::$ins = new self();
        }
        return self::$ins;
    }

    /**
     * 向购物车中添加一个商品
     * @param int $goods_id   [description]
     * @param string $goods_name [description]
     * @param float $shop_price [description]
     * @return  boolean
     */
    public  function add($goods_id, $goods_name, $shop_price) {
        if(isset($this->item[$goods_id])) {
            $this->item[$goods_id]['num'] += 1;
        } else {
            $goods = array('goods_name' => $goods_name , 'shop_price' => $shop_price, 'num' => 1 );
            $this->item[$goods_id] = $goods;
        }
    }

    /**
     * 减少购物车中一个商品的数量，如果减至0，从购物车中删除此商品
     * @param  int $goods_id [description]
     * @return [type]           [description]
     */
    public function decr($goods_id) {
        if(isset($this->item[$goods_id])) {
            $this->item[$goods_id]['num'] -= 1;
        }

        if($this->item[$goods_id]['num'] <= 0) {
            $this->del($goods_id);
        }
    }

    /**
     * 从购物车中删除某商品
     * @param  [type] $goods_id [description]
     * @return [type]           [description]
     */
    public function del($goods_id) {
        unset($this->item[$goods_id]);
    }

    /**
     * 列出购物车中所有商品
     * @return array           [description]
     */
    public function items() {
        return $this->item;
    }

    /**
     * 返回购物车中有几种商品
     * @return int [description]
     */
    public function calcType() {
        return count($this->item);
    }

    /**
     * 返回购物车中商品的个数
     * @return [type] [description]
     */
    public function calcCnt() {
        $cnt = 0;
        foreach ($this->item as $v) {
            $cnt += $v['num'];
        }

        return $cnt;
    }

    /**
     * 返回购物车中商品的价格
     * @return float [description]
     */
    public function calcMoney() {
        $money = 0;
        foreach ($this->item as $v) {
            $money += ($v['shop_price'] * $v['num']);
        }

        return $money;
    }

    /**
     * 清空购物车
     * @return void [description]
     */
    public function clear() {
        $this->item = array();
    }

    public function __destruct() {
        session('cart', $this->item);
    }

}