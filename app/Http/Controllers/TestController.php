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

class TestController extends BaseController
{
    private $testRepository;

    public function __construct(TestRepository $repository)
    {
        $this->testRepository = $repository;
    }

    public function create(Request $request)
    {

        $params = $this->validate($request, [
            'name' => 'required|string',
            'age'  => 'required|integer'
        ]);
        return $this->success($this->testRepository->create($params));

    }
}


