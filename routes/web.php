<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*-------------------------------- 测试相关 ----------------------------------*/
$router->group(['prefix' => 'test'], function () use ($router) {
    $router->get('/create', 'TestController@create');
});
$router->group(['prefix' => 'php'], function () use ($router) {
    $router->get('/', 'PhpInfoController@index');
});