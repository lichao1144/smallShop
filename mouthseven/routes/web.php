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

//服务端处理返回数据
Route::prefix('admin')->middleware('apimiddleware')->group(function(){
    Route::any('send','api\AdminController@send');
});

//客户端请求数据
Route::get('send','api\AdminController@send');
//请求服务器给图片路径
Route::get('getimage','api\AdminController@getImageCodeUrl');
//获取验证码图片
Route::get('image','api\AdminController@showImageCode');
Route::get('am','client\ClientController@Asymmetricencryption');
