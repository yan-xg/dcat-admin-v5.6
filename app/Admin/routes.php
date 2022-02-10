<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'     => config('admin.route.prefix'),
    'namespace'  => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    //自定义图片上传接口
    $router->any('goods/images', 'GoodsImageController@handle');
    $router->any('goods/wangUploadImage', 'GoodsImageController@wangUploadImage');

    //商品
    $router->resource('category', 'CategoryController');
    $router->resource('goods', 'GoodsController');
    $router->resource('pic', 'PicController');

    //用户
    $router->resource('users', 'UserController');
    $router->resource('address', 'UserAddressController');

    //购物车
    $router->resource('ordercart', 'OrderCartController');
});
