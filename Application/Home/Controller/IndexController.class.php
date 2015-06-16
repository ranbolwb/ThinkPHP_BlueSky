<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();
    }

    public function login(){
        layout(false);
        $this->display();
    }

    /*
     * 登录
     */
    public function doLogin()
    {
        $user = M("user");
        $where["nickname"] = ":name";
        $where["email"] = ":name";
        $where["mobile"] = ":name";
        $where["_logic"] = "OR";
        $map["password"] = ":password";
        $map['_complex'] = $where;
        $bind[':name'] = I("post.name");
        $bind[':password'] = I("post.password");
        $list = $user->where($map)->bind($bind)->select();
        if (count($list) == 1) {
            $currentUser = current($list);
            $currentUser["lasttime"] = date('Y-m-d H:i:s', time());
            session("user", $currentUser);
            //保存最后登录时间
            $user->field('lasttime,id')->save($currentUser);
            //保存登录日志
            $ul = M("user_login");
            $log["uid"] = $currentUser["id"];
            $log["ip"] = get_client_ip();
            $log["logintime"] = $currentUser["lasttime"];
            $ul->add($log);

            $this->redirect("index");
        } else {

            $this->redirect("index");
        }
    }
    /*
     * 注销
     */
    public function loginOut()
    {
        //session("user",null);
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        // 最后彻底销毁session.
        session_destroy();
        //$this->display("index");
        $this->redirect("index");
    }
}