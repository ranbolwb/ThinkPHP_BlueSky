<?php
/**
 * Created by PhpStorm.
 * User: lwbpe
 * Date: 2015/6/4
 * Time: 15:07
 */

namespace Admin\Controller;

use Think\Controller;
use Think\Exception;

class SystemController extends Controller
{
    public function Index()
    {
        $this->display();
    }

    public function User()
    {
        $this->display();
    }

    public function userList()
    {
//        $where["nickname"] = array("like","%".I("post.txtnickname")."%");
//        $where["email"] = array("like","%".I("post.txtemail")."%");
//        $where["mobile"] = array("like","%".I("post.txtmobile")."%");
//        $where["truename"] = array("like","%".I("post.txttruename")."%");
//        if(I("post.txtscore1") != "")
//            $where["score"] = array("egt",I("post.txtscore1"));
//        if(I("post.txtscore2") != "")
//            $where["score"] = array("elt",I("post.txtscore2"));

        $where["nickname"] = array("like",":nickname");
        $bind[":nickname"] = "%".I("post.txtnickname")."%";
        $where["email"] = array("like",":email");
        $bind[":email"] = "%".I("post.txtemail")."%";
        $where["mobile"] = array("like",":mobile");
        $bind[":mobile"] = "%".I("post.txtmobile")."%";
        $where["truename"] = array("like",":truename");
        $bind[":truename"] = "%".I("post.txttruename")."%";
        if(I("post.txtscore1") != "") {
            $where["score"] = array("egt", ":score1");
            $bind[":score1"] = I("post.txtscore1");
        }
        if(I("post.txtscore2") != ""){
            $where["score"] = array("elt",":score2");
            $bind[":score2"] = I("post.txtscore2");
        }

        $page = I("post.page");
        $rows = I("post.rows");
        $sort = I("post.sort") == null ? "id" : I("post.sort");
        $order = I("post.order") == null ? "asc" : I("post.order");
        $user = M("user");
        $list = $user->where($where)->bind($bind)->order($sort." ".$order)->page($page,$rows)->select();
        $count = $user->where($where)->bind($bind)->count();
        $jsonencode = json_encode($list);
        $jsonencode = $jsonencode == 'null' ? "{}" : $jsonencode;
        $json = "{\"total\":".$count.",\"rows\":".$jsonencode."}";
        exit($json);
    }

    public function userCommit()
    {
        $inserted = I("inserted");
        $deleted = I("deleted");
        $updated = I("updated");

        $inserts = json_decode(stripslashes(html_entity_decode($inserted)),true);
        $deletes = json_decode(stripslashes(html_entity_decode($deleted)),true);
        $updates = json_decode(stripslashes(html_entity_decode($updated)),true);

        $user = M("user");
        $user->startTrans();
        try
        {
            //插入
            foreach($inserts as $insert)
            {
                $insert["createtime"] = date('Y-m-d H:i:s', time());
                $insert["lasttime"] = $insert["createtime"];
                $user->add($insert);
            }
            //更新
            foreach($updates as $update)
            {
                $user->save($update);
            }
            //删除
            foreach($deletes as $delete)
            {
                $user->delete($delete["id"]);
            }

            $user->commit();
            $result["state"] = 1;
            $result["inserts"] = count($inserts);
            $result["deletes"] = count($deletes);
            $result["updates"] = count($updates);
        }catch (Exception $e)
        {
            $user->rollback();
            $result["state"] = 0;
            $result["msg"] = $e.message;
        }
        exit(json_encode($result));
    }
}