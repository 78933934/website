<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    //文件上传
    $router->resource('/upload', 'AttachmentController',['only' => ['store', 'destroy']]);

    //商品管理
    $router->resource('/goods','GoodController')->except(['show']);
    //商品导出
    $router->get('/goods/export', 'GoodController@export')->name('goods.export');
    //属性设置
    $router->resource('/good_skus', 'GoodSkuController')->only(['update']);

    //订单管理
    $router->resource('/good_orders', 'GoodOrderController')->except(['store','show']);
    //审核订单
    $router->put('/good_orders/{id}/audit','GoodOrderController@audit')->name('good_orders.audit');
    //加客服备注
    $router->put('good_orders/{id}/update_remark', 'GoodOrderController@update_remark');
    //订单导出
    $router->get('/good_orders/export', 'GoodOrderController@export')->name('good_orders.export');



});
