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
//闭包路由 返回视图
// Route::get('/', function () {
//     return view('welcome');
// });

//闭包路由  调用hello显示hello视图的信息
// Route::get('hello',function(){
// 	return view('hello');
// });

// //调用index,什么控制器下的什么方法----@符连接
// Route::get('/index','TextController@index');

// //表单提交 必须写csrf_field()
// Route::get('/form',function(){
// 	return'<form action="/do" method="post">'.csrf_field().'<input type="text" name="name" ><button>提交</button></form>';
// });


// //接受表单数据
// Route::post('/do','TextController@add');


// //给add传参数
// Route::get('/add/{id}',function($id){
// 	echo "Id is:" .$id;
// });


// Route::get('/add/{id}','TextController@add');


// Route::get('/add/{id?}','TextController@add');


// Route::get('add/{id?}','TextController@add')->where('id','\d+');


// //可选参数，闭包给默认值
// Route::get('user/{name?}',function($name=null){
// 	echo $name;
// });


// //参数约束
// Route::get('student/{id}',function($id){

// })->where('id','\d+');


// //多参数
// Route::get('/aa/{iid}/bb/{id}',function($iid,$id){
// 	echo $iid.'-'.$id;
// });

Route::get('/','ShopController@show');
//珠宝微商城
Route::prefix('shop')->group(function(){
	Route::get('prolist/{cate_id?}','ShopController@prolist');
	Route::get('car','ShopController@car');
	Route::get('addcar','ShopController@addcar');
	Route::get('pay','ShopController@pay');
	Route::get('proinfo/{goods_id}','ShopController@proinfo');
	Route::post('countTotal','ShopController@countTotal');
	Route::post('checklogin','ShopController@checklogin');
	Route::get('address','ShopController@address');
	Route::post('getarea','ShopController@getarea');
	Route::post('addressadd','ShopController@addressadd');
	Route::get('user','ShopController@user');	
	Route::post('out','ShopController@out');
	Route::post('submit','ShopController@submit');	
	Route::get('success','ShopController@success');	
	Route::get('myaddress','ShopController@myaddress');	
	Route::post('deladdress','ShopController@deladdress');	
	Route::post('mr','ShopController@mr');	
	Route::get('update/{address_id?}','ShopController@update');	
	Route::post('updateHandle','ShopController@updateHandle');	
	Route::get('paysuccess/{order_id}','ShopController@paysuccess');
});
Route::get('/returnAlipay','ShopController@returnAlipay');
Route::get('/returnAlipayB','ShopController@returnAlipayB');
//微商城登陆注册
Route::prefix('login')->group(function(){
	Route::get('login','LoginController@login');
	Route::get('reg','LoginController@reg');
	Route::post('checkemail','LoginController@checkemail');
	Route::post('checkemailt','LoginController@checkemailt');
	Route::post('checkcode','LoginController@checkcode');
	Route::post('checkpwd','LoginController@checkpwd');
	//邮箱验证码
	Route::post('send','LoginController@send');
	Route::post('denglu','LoginController@denglu');
});



//laravel自带用户注册
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
