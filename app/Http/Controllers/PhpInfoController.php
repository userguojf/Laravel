<?php
/**
 * Created by PhpStorm.
 * User: guojianfeng
 * Date: 2018/11/13
 * Time: 下午6:46
 */

namespace App\Http\Controllers;

use function GuzzleHttp\Promise\queue;
use Illuminate\Http\Request;
use App\Repository\TestRepository;

class PhpInfoController extends BaseController
{

    public function index(Request $request)
    {

        echo  phpinfo();
    }
}


