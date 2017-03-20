<?php
namespace Admin\Controller;
use Think\Controller;
class CatController extends Controller {
    public function cateadd() {
        if(IS_POST) {
            $catModel = D('Cat');
            if($catModel->add($_POST)) {
                $this->redirect('admin/cat/catelist');
            }
        }
        $this->display();

    }

    public function catelist() {

        $cats = S('cats');
        if(!$cats) {
            echo 'from sql';
            $cats = D('Cat')->gettree();
            S('cats', $cats, 300);
        }
        $this->assign('catlist', $cats);
        $this->display();
    }

    public function cateedit() {
        $catModel = D('Cat');
        if(IS_POST) {
            $cat_id = I('cat_id');
            if($catModel->where('cat_id='.$cat_id)->save($_POST)) {
                $this->redirect('admin/cat/catelist');
            }
        }

        $this->assign('gettree',$catModel->gettree());
        $this->assign('catinfo',$catModel->find(I('cat_id')));
        $this->display();
    }

    public function catedel() {
        $catModel = D('Cat');
        $catModel->delete(I('get.cat_id'));
        $this->redirect('admin/cat/catelist');
    }
}