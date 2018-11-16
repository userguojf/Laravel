<?php
/**
 * Created by PhpStorm.
 * User: guojianfeng
 * Date: 2018/11/13
 * Time: 下午7:35
 */
namespace App\Http\Controllers;

class TestBaseController
{
    public $name;
    public $age;
    private $n1 = ['a1' => 'aaaa'];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getValue()
    {
//        return $this->name;
        return $this->n1[$this->name];
    }

    public static function __callStatic($name, $arguments)
    {
        return new static($name);
    }


}