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
    $api->group(['middleware' => 'auth:api'], function ($api) {

    });

    /**前台**/
    $api->group([
        'prefix' => 'user',
        'namespace' => 'App\Http\Controllers\User',
    ], function ($api) {

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
