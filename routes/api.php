<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api'
], function($api) {
    // 用户注册
    $api->post('users', 'UsersController@store')
        ->name('api.users.store');

    // 登录
    $api->post('authorization', 'AuthorizationController@store')
        ->name('api.authorization.store');

    // 需要 token 验证的接口
    $api->group(['middleware' => 'api.auth'], function($api) {

        $api->post('threads',"ThreadsController@store")
            ->name('api.threads.store');
    });
});

