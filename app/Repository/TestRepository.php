<?php
/**
 * Created by PhpStorm.
 * User: guojianfeng
 * Date: 2018/11/16
 * Time: 下午3:03
 */
namespace App\Repository;

use App\Models\TestModel;
use App\Exceptions\ApiException;

class TestRepository
{
        public function create(array $param):array
        {
            try{
                TestModel::create([
                    'name' => $param['name'],
                    'age'  => $param['age']
                ]);
            } catch (\Exception $e) {
                throw new ApiException($e->getMessage());
            }

            return [];
        }
}