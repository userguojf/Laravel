<?php
/**
 * Created by PhpStorm.
 * User: guojianfeng
 * Date: 2018/11/13
 * Time: 下午6:46
 */

namespace App\Http\Controllers;

class TestController extends TestBaseController
{

    public function __construct($name = 'wangdk')
    {
        parent::__construct($name);
    }
    public function test1()
    {
        var_dump(TestBaseController::a1()->getValue());
    }

    public function test2()
    {
      TestBaseController::$a->getValue();
    }
}


