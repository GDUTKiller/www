<?php
namespace Home\Controller;
use Think\Controller;

class OrderController extends Controller {

    public function add() {
        $goods = D('Admin/Goods');
        if(!$goods->find(I('get.goods_id'))) {
            $this->redirect('/');
            exit;
        }

        $cart = \Home\Tool\CartTool::getIns();
        $cart->add($goods->goods_id, $goods->goods_name, $goods->shop_price);

        // var_dump($cart->items());
        // var_dump($cart->calcMoney());
        // $this->assign('items', $cart->items());
        // $this->assign('money', $cart->calcMoney());
        $this->redirect('Home/Order/checkout');
    }

    public function checkout() {
        $cart = \Home\Tool\CartTool::getIns();
        $this->assign('items', $cart->items());
        $this->assign('money', $cart->calcMoney());

        $this->display();
    }

    public function done() {
        $ordinfo = D('Home/Ordinfo');
        $ordgoods = D('Home/Ordgoods');
        $cart = \Home\Tool\CartTool::getIns();

        //写入ordinfo表
        $_POST['ord_sn'] = date('Ymd') . rand(1000, 9999);
        $_POST['user_id'] = $_COOKIE['user_id'] ? $_COOKIE['user_id'] : 0;
        $_POST['money'] = $cart->calcMoney();
        $_POST['ordtime'] = time();

        $ordinfo_id = NULL;
        $ordinfo->create() && ($ordinfo_id = $ordinfo->add());

        if(!$ordinfo_id) {
            $this->show('下单失败!', 'utf-8');
            exit;
        }

        //写入ordgoods表
        $data = array();
        foreach($cart->items() as $k=>$v) {
            $row = array();
            $row['ordinfo_id'] = $ordinfo_id;
            $row['goods_id'] = $k;
            $row['goods_name'] = $v['goods_name'];
            $row['shop_price'] = $v['shop_price'];
            $row['num'] = $v['num'];

            $data[] = $row;
        }

        if(!$ordgoods->addAll($data)) {
            $ordinfo->delete($ordinfo_id);
            $ordgoods->where(array('ordinfo_id'=>$ordinfo_id))->delete();
            $this->show('下单失败','utf-8');
            exit;
        }

        $this->assign('ord_sn', $_POST['ord_sn']);
        $this->assign('money', $cart->calcMoney());

        // $CBPay = new \Home\Pay\CBPay();
        // $CBPay->v_oid = $_POST['ord_sn'];
        // $CBPay->v_amount = $cart->calcMoney();

        // $this->assign('pay', $CBPay->form());

        //清空购物车
        $cart->clear();


        $this->display();
    }
}