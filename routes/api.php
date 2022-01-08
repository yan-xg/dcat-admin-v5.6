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

//小程序首页
Route::get('index','Api\IndexController@index');

// 商品
Route::get('goods/count','Api\GoodsController@count');
Route::post('goods/searchlist','Api\GoodsController@searchList');
Route::post('goods/detail','Api\GoodsController@detail');

// 分类
Route::get('category/list','Api\CategoryController@list');
Route::post('category/currentlist','Api\CategoryController@currentlist');

//搜索
Route::get('search/index','Api\SearchController@index');// 未使用
Route::post('search/helper','Api\SearchController@helper');
