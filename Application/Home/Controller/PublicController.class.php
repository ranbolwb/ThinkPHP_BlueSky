<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {
    public function header(){
        layout(false);
        $this->display();
    }

    public function footer(){
        layout(false);
        $time = date("Y-m-d H:i:s");
        $this->assign("time",$time);
        $this->display();
    }
}