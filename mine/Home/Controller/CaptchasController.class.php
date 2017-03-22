<?php
namespace Home\Controller;
use Think\Controller\RestController;

class CaptchasController extends RestController {
    public function send() {
        $Captchas = D('Captchas');
        if(!$Captchas->create()) {
            $this->response(array('code'=>-1, 'info'=>$Captchas->getError(), 'data'=>null),'json');
        } else {
            $code = $Captchas->randStr();
            $Sms = new \Home\Tool\SmsTool();
            $Sms->send($code, '18826136974');
        }
    }
}