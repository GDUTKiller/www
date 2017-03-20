<?php
namespace Home\Controller;
use Think\Controller;

class CatController extends Controller {
    public function cat() {
        $goodsModel = D('Admin/goods');

        $count = $goodsModel->where('cat_id='.I('cat_id'))->count();
        $page = new \Think\Page($count, 2);
        $show = $page->show();
        $goodsList = $goodsModel->field('goods_id,goods_name,shop_price,thumb_img,market_price')->where('cat_id='.I('cat_id'))->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('count', $count);
        $this->assign('page', $show);
        $this->assign('goodslist',$goodsList);
        $this->display();
    }
}