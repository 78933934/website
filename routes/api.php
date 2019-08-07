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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
//    $api->group(['middleware' => 'auth:api'], function ($api) {
//
//    });

    /**前台**/
    $api->group([
        'prefix' => 'user',
        'namespace' => 'App\Http\Controllers\User',
    ], function ($api) {

        $api->group([
            'middleware' => [
//                \App\Http\Middleware\AllowCors::class,
//                'session'
            ],
        ], function ($api) {
            //商品详情
            $api->get('/goods/{id}', 'GoodController@show')->name('user.good.show');

            //订单相关
            $api->post('/good_orders', 'GoodOrderController@store')->name('user.order.store');

        });
    });


    /***后台**/
    $api->group([
        'prefix' => 'admin',
        'namespace' => 'App\Http\Controllers\Admin',
    ], function ($api) {
        $api->group([
            'middleware' => [
                'session'
            ],
        ], function ($api) {
            //登录
            $api->post('/login', 'AuthController@login')->name('user_login_post');

            //注销
            $api->post('/logout', 'AuthController@logout')->name('user_logout_post');
        });

        $api->group([
            'middleware' => [
                'auth:admin'
            ],
        ], function ($api) {

        });

    });//后台闭合



//v1闭合
});
