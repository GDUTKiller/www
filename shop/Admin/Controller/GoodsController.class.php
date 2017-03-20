<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends Controller {
    public $gm = null;
    public function __construct() {
        parent::__construct();
        $this->gm = D('goods');
    }
    public function goodsadd() {
        //var_dump($_POST);
        if(IS_POST) {
            if(!$this->gm->create($_POST)) {
                echo $this->gm->getError();
                exit;
            }


            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     './Public/Upload/Source/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功
                $img_path= './Public/Upload/Source/'.$info['goods_img']['savepath'].$info['goods_img']['savename'];
                $this->gm->goods_img = $img_path;

                $image = new \Think\Image();
                $image->open($img_path);
                // 生成一个固定大小为150*150的缩略图并保存
                $image_thumb_path = './Public/Upload/Thumb/' . $info['goods_img']['savepath'];

                //如果不存在该目录，则创建
                if (!file_exists($image_thumb_path)){
                    mkdir ($image_thumb_path);
                }
                $image->thumb(230, 230,\Think\Image::IMAGE_THUMB_FIXED)->save($image_thumb_path. $info['goods_img']['savename']);

                $this->gm->thumb_img = $image_thumb_path . $info['goods_img']['savename'];
            }

            $this->gm->add();
        }

        $this->display();
    }

    public function goodslist() {

        $p = I('p') ? I('p') : 1;
        // 进行分页数据查询 注意page方法的参数的前面部分是当前的页数使用 $_GET[p]获取
        $list = $this->gm->order('goods_id')->page($p.',3')->select();
        $this->assign('list',$list);// 赋值数据集
        $count      = $this->gm->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->display(); // 输出模板

        //$this->assign('list', $this->gm->select());
        //$this->display();
    }

    public function del() {
        $this->gm->delete(I('get.goods_id'));
        $this->redirect('admin/goods/goodslist');


    }
}