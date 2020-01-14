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

Route::any('wechat/index','Admin\WechatController@index');//测试
Route::get('createMenu','Admin\WechatController@createMenu');//创建自定义菜单

Route::view('/login','login');//登录页面
Route::post('/dologin','Admin\LoginController@dologin');//登录
 
Route::any('admin_index','Admin\IndexController@index');//首页
Route::any('index_v1','Admin\IndexController@index_v1');//首页

Route::any('index_weather','Admin\IndexController@index_weather');//天气
Route::any('getWeather','Admin\IndexController@getWeather');//天气

//login中间件   在admin里
 Route::prefix('/admin')->middleware('Login')->group(function(){
	 	
//素材管理
 	Route::any('media_add','Admin\IndexController@add');//添加页面
 	Route::any('add_do','Admin\IndexController@add_do');//添加
 	Route::any('media_show','Admin\IndexController@show');//展示

//新闻增删改查
 	Route::any('index','Admin\CurdController@index');//列表
 	Route::any('create','Admin\CurdController@create');//添加展示
 	Route::any('store','Admin\CurdController@store');//添加
 	Route::any('edit/{id}','Admin\CurdController@edit');//修改页面
 	Route::any('update/{id}','Admin\CurdController@update');//修改
 	Route::any('delete/{id}','Admin\CurdController@destroy');//删除
 	
//渠道
	Route::any('channel_show','Admin\ChannelController@show');//渠道展示	
	Route::any('channel_add','Admin\ChannelController@add');//渠道添加页面
	Route::any('channel_add_do','Admin\ChannelController@add_do');//渠道添加
	Route::any('channel_charts','Admin\ChannelController@charts');//统计
	
 });

 	



