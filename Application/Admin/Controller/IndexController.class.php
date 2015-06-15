<?php
namespace Admin\Controller;

use Admin\Model\UserModel;
use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover,{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
        $this->display();
    }

    public function  main()
    {
        $user = session("user");
        if ($user == null) {
            $this->display("index");
        } else {
            $this->assign('user', $user);
            $this->display();
        }
    }

    public function menu()
    {
        $user = session("user");
        //是否超级管理员
        $dao = M();
        $sql = "select 1 from think_user_role a,think_role b where a.roleid=b.id and b.super=1 and a.userid=%d";
        $list = $dao->query($sql,$user["id"]);
        if ($list != null) {
            $sql = "select * from think_menu order by code";
            $list = $dao->query($sql);
        } else {
            $sql = "select c.* from think_user_role a,think_role_menu b,think_menu c where a.roleid=b.roleid and b.menuid=c.id and a.userid=%d order by c.code";
            $list = $dao->query($sql,$user["id"]);
        }
        if ($list != null) {
            $menu = array();
            foreach ($list as $item) {
                if (strlen($item["code"]) == 2) {
                    $menu[] = $item;
                }
            }
            $this->assign('menu', $menu);
            $this->assign('menuJson', $this->menuTree($list));
        }
        $this->display();
    }

    private function menuTree($list)
    {
        $menu = array();
        foreach ($list as $item) {
            if (strlen($item["code"]) == 2) {
                $d = array("id" => $item["id"], "text" => $item["title"], "children" => $this->getMenuChild($item["code"], $list));
                $menu[] = $d;
            }
        }
        if (count($menu) > 0) {
            $j = json_encode($menu);
            //exit($j);
            return $j;
        } else {
            //exit("");
            return "";
        }
    }

    public function getMenuChild($code, $list)
    {
        $menu = array();
        foreach ($list as $item) {
            if (strlen($item["code"]) == strlen($code) + 2 && substr($item["code"], 0, strlen($code)) == $code) {
                $d = array("id" => $item["id"], "text" => $item["title"], "attributes" => array("url" => $item["url"]), "children" => $this->getMenuChild($item["code"], $list));
                $menu[] = $d;
            }
        }
        if (count($menu) > 0) {
            return $menu;
        } else {
            return "";
        }
    }

    public function  changePassword()
    {
        $this->display();
    }

    public function doChangePassword()
    {
        $data = session("user");
        //校验原密码
        if ($data["password"] == I("post.oldpwd")) {
            if (I("post.newpwd") != "") {
                $data["password"] = I("post.newpwd");
                $user = M("user");
                $user->field("password,id")->save($data);
                session("user.password", $data["password"]);
                $result["state"] = 1;
                $result["msg"] = "修改密码成功！";
                //$this->ajaxReturn($result);
                echo(json_encode($result));
            } else {
                $result["state"] = 0;
                $result["msg"] = "请输入新密码！";
                //$this->ajaxReturn($result);
                echo(json_encode($result));
            }
        } else {
            $result["state"] = 0;
            $result["msg"] = "原密码不正确！";
            //$this->ajaxReturn($result);
            echo(json_encode($result));
        }
    }

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

    /*
     * 登录
     */
    public function login()
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

            $data["state"] = 1;
            $data["url"] = U("Admin/Index/main");
            //$this->ajaxReturn($data);
            exit(json_encode($data));
        } else {
            $data["state"] = 0;
            $data["msg"] = "用户名或密码不正确！";
            //$this->ajaxReturn($data);
            exit(json_encode($data));
        }
    }

}