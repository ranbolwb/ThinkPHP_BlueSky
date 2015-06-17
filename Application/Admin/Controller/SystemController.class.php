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
        $page = I("get.page");
        $rows = I("get.rows");
        $sort = I("get.sort") == null ? "id" : I("get.sort");
        $order = I("get.order") == null ? "asc" : I("get.order");
        $user = M("user");
        $list = $user->order($sort,$order)->page($page,$rows)->select();
        $count = $user->count();
        $json = "{\"total\":".$count.",\"rows\":".json_encode($list)."}";
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
                $user->delete($delete);
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