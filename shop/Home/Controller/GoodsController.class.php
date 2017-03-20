<?php
namespace Home\Controller;
use Think\Controller;

class GoodsController extends Controller {
    public function goods() {
        if(IS_GET){
            $goods = D('Admin/Goods');
            $goodsinfo = $goods->find(I('goods_id'));

            //评论
            $comms = $goods->relationGet('comment');
            $this->assign('comment', $comms);

            $this->history($goodsinfo);
            $this->assign('goodsinfo', $goodsinfo);
            $this->assign('mbx',$this->getFamily($goodsinfo['cat_id']));
        }

        $this->display();
    }

    public function comment() {
        if(IS_POST) {
            $_POST['pubtime'] = time();
            $commentModel = D('comment');
            // if(!$commentModel->create()) {
            //     echo $commentModel->getError();
            //     exit;
            // }
            if($commentModel->add($_POST)) {
                $this->success('评论成功', '', 2);
            } else {
                $this->error('评论失败', '', 2);
            }
        }
    }

    public function history($row) {
        $history = session('history') ? session('history') : array();

        $g = array();
        $g['goods_name'] = $row['goods_name'];
        $g['goods_img'] = $row['goods_img'];
        $g['shop_price'] = $row['shop_price'];

        $history[$row['goods_id']] = $g;

        if(count($history) > 5) {
            $key = key($history);
            unset($history[$key]);
        }

        session('history', $history);
    }

    public function getFamily($cat_id) {
        $fm = array();
        $catModel = D('Admin/Cat');
        while($cat_id > 0) {
            foreach ($catModel->select() as $c) {
                if($c['cat_id'] == $cat_id) {
                    $fm[] = $c;
                    $cat_id = $c['parent_id'];
                    break;
                }
            }
        }

        return array_reverse($fm);
    }
}