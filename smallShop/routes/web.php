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
Route::prefix('shop')->middleware('checkLogin')->group(function(){
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

//微信接口
Route::prefix('weixin')->group(function(){
    //微信的绑定
    Route::any('weichat','WeixinController@weichat');
    //微信的关注
    Route::any('guanzhu','WeixinController@guanzhu');
    //获取微信的access_token
    Route::any('getAccessToken','WeixinController@getAccessToken');
    //点击微信进行授权商城跳转
    Route::any('sendlogin','WeixinController@sendlogin');
	//测试一

});
//
//微信后台数据管理
Route::prefix('admin')->group(function(){
    //登陆的验证
    Route::any('checklogin','AdminController@checklogin');
    //微信后台操作的主页面
	Route::any('index','AdminController@index');
    //添加素材页面
    Route::any('add','AdminController@add');
    //处理添加素材信息
    Route::any('addHandle','AdminController@addHandle');
    //上传临时文件
    Route::any('temporaryMaterial','AdminController@TemporaryMaterial');
    //设置类型
	Route::any('settype','AdminController@settype');
    //处理设置类型
	Route::any('settypehandle','AdminController@settypehandle');
    //素材的信息展示一
	Route::any('show','AdminController@show');
    //素材的信息展示二
	Route::any('scshow','AdminController@scshow');
    //用户layui主页获取信息
	Route::any('userData','AdminController@userData');
    //获取素材信息
	Route::any('scData','AdminController@scData');
    //删除素材一
	Route::any('del','AdminController@del');
    //删除素材二
    Route::any('scdel','AdminController@scdel');
    //群发设置
    Route::any('sendgroup','AdminController@sendgroup');
    //根据open_id群发
	Route::any('checkopenid','AdminController@checkopenid');
	//设置标签页面
    Route::any('settag','AdminController@settag');
    //处理添加页面
    Route::post('addtag','AdminController@addtag');
    //给用户打标签
    Route::any('taggroup','AdminController@taggroup');
    //给用户设置标签页面
    Route::any('taginfo','AdminController@taginfo');
    //处理给用户添加标签
	Route::any('tagqunfa','AdminController@tagqunfa');
    //根据标签群发页面
	Route::any('tagginggroup','AdminController@tagginggroup');
    //开始标签群发
    Route::any('starttagginggroup','AdminController@starttagginggroup');
    //自定义菜单的添加
    Route::any('addmenu','MenuController@addmenu');
    //添加处理自定义菜单
    Route::any('setmenu','MenuController@setmenu');
    //自定义菜单列表
    Route::any('menulist','MenuController@menulist');
    //获取二级菜单
    Route::any('getmenuinfo','MenuController@getmenuinfo');
    //删除菜单
    Route::any('menudel','MenuController@menudel');
    //二级分类删除菜单
    Route::any('menudelb/{m_id?}','MenuController@menudelb');
    //修改主菜单展示
	Route::any('menuupdate/{m_id}','MenuController@menuupdate');
    //处理修改主菜单
    Route::any('menuupdatehandle','MenuController@menuupdatehandle');
    //修改二级菜单展示
    Route::any('menuupdateb/{m_id}','MenuController@menuupdateb');
	//处理修改二级菜单
	Route::any('menuupdatehandleb','MenuController@menuupdatehandleb');
    //获取所有用户的详细信息
    Route::any('getuserinfo','AdminController@getuserinfo');
    //发送微信模板
	Route::any('sendmenu','MenuController@sendmenu');
	//发送创建个性化菜单
	Route::any('individualization','MenuController@individualization');
	//微信的授权登陆
    Route::any('oauthlogin','OauthController@oauthlogin');
	//删除所有菜单
    Route::any('menudelete','MenuController@menudelete');
    //进行绑定
    Route::any('bindlogin','OauthController@bindlogin');
    //账号绑定页面
    Route::any('banding','OauthController@banding');
    //验证邮箱
	Route::any('checkemail','OauthController@checkemail');
    Route::any('bandinghandle','OauthController@bandinghandle');
	//获取验证码
    Route::any('getqrcode','AdminController@getqrcode');
    //微信登陆授权
    Route::any('wxcodelogin/{userid}','AdminController@wxcodelogin');
    //获取微信二维码
    Route::any('wxcode','AdminController@wxcode');
    //获得状态
    Route::any('getstatus','AdminController@getstatus');
	//添加约惠卷
    Route::any('addjuan','YuekaoController@addjuan');
    //添加处理约惠劵
    Route::any('yhhandle','YuekaoController@yhhandle');
    //抽奖页面
    Route::any('yhagain','YuekaoController@yhagain');
    //获取几率
    Route::any('getcode','YuekaoController@getcode');
    //用户约惠列表
    Route::any('useryh','YuekaoController@useryh');
	//自定义编写函数1
	Route::any('getvalue','AaController@getvalue');
    Route::any('sendvalue','AaController@sendvalue');
    //自定义编写函数2
    Route::any('getvaluet','AaController@getvaluet');
    Route::any('sendvaluet','AaController@sendvaluet');
});
//登陆页面
Route::any('login','AdminController@login');

Route::prefix('text')->group(function(){
    Route::any('wxbd','TextController@wxbd');
});