<?php
/**
 * Created by PhpStorm.
 * User: guojianfeng
 * Date: 2018/11/13
 * Time: 下午6:46
 */

namespace App\Http\Controllers;

use App\Http\Controllers\TestController;

class Test1Controller
{

    public function test1()
    {
        $res = TestController::Tom()->getValue();
        var_dump($res);
    }

    public function test2()
    {

    }
}


