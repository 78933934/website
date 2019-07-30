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

});
