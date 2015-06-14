<?php
/**
 * Created by PhpStorm.
 * User: lwbpe
 * Date: 2015/6/4
 * Time: 15:07
 */

namespace Admin\Controller;

use Think\Controller;

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
}