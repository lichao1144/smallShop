<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="{{asset('index/images/favicon.ico')}}" />
    
    <!-- Bootstrap -->
  <link href="{{asset('index/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('index/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('index/css/response.css')}}" rel="stylesheet">
   <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="maincont">
     <div class="head-top">
      <img src="{{asset('index/images/head.jpg')}}" />
      <dl>
       <dt><a href="user.html"><img src="{{asset('index/images/touxiang.jpg')}}" /></a></dt>
       <dd>
        <h1 class="username">三级分销终身荣誉会员</h1>
        <ul>
         <li><a href="prolist"><strong>{{$goodsNumber}}</strong><p>全部商品</p></a></li>
         <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
         <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
         <div class="clearfix"></div>
        </ul>
       </dd>
       <div class="clearfix"></div>
      </dl>
     </div><!--head-top/-->


     <form action="" method="get" class="search">
      <input type="text" name="goods_name" class="seaText fl" />
      <input type="submit" value="搜索" class="seaSub fr" />
     </form><!--search/-->


    @if($data=='')
     <ul class="reg-login-click">
      <li><a href="/login/login">登录</a></li>
      <li><a href="reg" class="rlbg">注册</a></li>
      <div class="clearfix"></div>
     </ul><!--reg-login-click/-->
    @else
    <div align="center" style="color:red">
      
        <li>欢迎{{$data['u_email']}}登陆!</li>
     <!--reg-login-click/-->
    </div>
    
     @endif
     <div id="sliderA" class="slider">
      <img src="{{asset('index/images/image1.jpg')}}" />
      <img src="{{asset('index/images/image2.jpg')}}" />
      <img src="{{asset('index/images/image3.jpg')}}" />
      <img src="{{asset('index/images/image4.jpg')}}" />
      <img src="{{asset('index/images/image5.jpg')}}" />
     </div><!--sliderA/-->
     <ul class="pronav">
      @foreach($cateInfo as $key=>$value)
      <li><a href="/shop/prolist/{{$value->cate_id}}">{{$value->cate_name}}</a></li>
      @endforeach
      <div class="clearfix"></div>
     </ul><!--pronav/-->

     <div class="index-pro1">
      @foreach($goodsInfo as $key=>$value)
      <div class="index-pro1-list">
       <dl>
        <dt><a href="/shop/proinfo/{{$value->goods_id}}"><img src="http://www.goodsimg.com/{{$value->goods_img}}" /></a></dt>
        <dd class="ip-text"><a href="proinfo">{{$value->goods_name}}</a><span>库存：{{$value->goods_number}}</span></dd>
        <dd class="ip-price"><strong>¥{{$value->market_price}}</strong> <span>¥{{$value->shop_price}}</span></dd>
       </dl>
      </div>
      @endforeach
      <div class="clearfix"></div>
     </div><!--index-pro1/-->
     <div class="prolist">
      <dl>
       <dt><a href="proinfo.html"><img src="{{asset('images/prolist1.jpg')}}" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="proinfo.html">四叶草</a></h3>
        <div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>
        <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl>
      <dl>
       <dt><a href="proinfo.html"><img src="{{asset('images/prolist1.jpg')}}" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="proinfo.html">四叶草</a></h3>
        <div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>
        <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl>
      <dl>
       <dt><a href="proinfo.html"><img src="{{asset('images/prolist1.jpg')}}" width="100" height="100" /></a></dt>
       <dd>
        <h3><a href="proinfo.html">四叶草</a></h3>
        <div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>
        <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
       </dd>
       <div class="clearfix"></div>
      </dl>
     </div><!--prolist/-->
     <div class="joins"><a href="fenxiao.html"><img src="{{asset('images/jrwm.jpg')}}" /></a></div>
     <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>
     
     <div class="height1"></div>
     <div class="footNav">
      <dl>
       <a href="/">
        <dt><span class="glyphicon glyphicon-home"></span></dt>
        <dd>微店</dd>
       </a>
      </dl>
      <dl>
       <a href="/shop/prolist">
        <dt><span class="glyphicon glyphicon-th"></span></dt>
        <dd>所有商品</dd>
       </a>
      </dl>
      <dl>
       <a href="/shop/car">
        <dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
        <dd>购物车 </dd>
       </a>
      </dl>
      <dl>
       <a href="/shop/user">
        <dt><span class="glyphicon glyphicon-user"></span></dt>
        <dd>我的</dd>
       </a>
      </dl>
      <div class="clearfix"></div>
     </div><!--footNav/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('index/js/jquery.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('index/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('index/js/style.js')}}"></script>
    <!--焦点轮换-->
    <script src="{{asset('index/js/jquery.excoloSlider.js')}}"></script>
    <script>
		$(function () {
		 $("#sliderA").excoloSlider();
		});
	</script>
  </body>
</html>