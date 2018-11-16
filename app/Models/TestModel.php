<?php
/**
 * Created by PhpStorm.
 * User: guojianfeng
 * Date: 2018/11/16
 * Time: 下午3:06
 */
namespace App\Models;

class TestModel extends BaseModel
{
    protected $table = 'test';

    public $timestamps = false;
//    protected $fillable = [
//        'name',
//        'age'
//        ];
}