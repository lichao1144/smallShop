<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}" />
    
    <!-- Bootstrap -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/response.css')}}" rel="stylesheet">
     <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
     <meta name="csrf-token" content="{{csrf_token()}}">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="maincont">
     <header>
      <a  class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>收货地址</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="{{asset('images/head.jpg')}}" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><a href="address" class="hui"><strong class="">+</strong> 新增收货地址</a></td>
       <td width="25%" align="center" style="background:#fff url(images/xian.jpg) left center no-repeat;"></td>
      </tr>
     </table>
     @foreach($addressInfo as $k=>$v)
     @if($v->is_defaut == '1')
     <div class="dingdanlist" address_id="{{$v->address_id}}">
      <table>
       <tr>
        <td width="50%">
         <h3>{{$v->address_name}} {{$v->address_tel}}</h3>
         <time>{{$v->province}}{{$v->city}}{{$v->area}}{{$v->address_detail}}</time>
        </td>
        <td align="right">
          <a href="update/{{$v->address_id}}" class="hui">
            <span class="glyphicon glyphicon-check">
            </span> 修改信息
          </a>
          &nbsp;&nbsp;
          <a  class="orange">删除信息</a>
          <a class='mr'>设置默认</a>
        </td>
       </tr>
      </table>
     </div><!--dingdanlist/-->
     @else
     <div class="dingdanlist" address_id="{{$v->address_id}}">
      <table>
       <tr>
        <td width="50%">
         <h3>{{$v->address_name}} {{$v->address_tel}}</h3>
         <time>{{$v->province}}{{$v->city}}{{$v->area}}{{$v->address_detail}}</time>
        </td>
        <td align="right">
          <a href="update/{{$v->address_id}}" class="hui">
            <span class="glyphicon glyphicon-check">
            </span> 修改信息
          </a>
          &nbsp;&nbsp;
          <a  class="orange">删除信息</a>
          <span style="color: red">默认</span>
        </td>
       </tr>
      </table>
     </div><!--dingdanlist/-->
     @endif
     @endforeach
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
      <dl class="/shop/ftnavCur">
       <a href="user">
        <dt><span class="glyphicon glyphicon-user"></span></dt>
        <dd>我的</dd>
       </a>
      </dl>
      <div class="clearfix"></div>
     </div><!--footNav/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/style.js')}}"></script>
    <!--jq加减-->
    <script src="{{asset('js/jquery.spinner.js')}}"></script>
   <script>
	   $('.orange').click(function(){
        // alert('aa');
        var address_id=$(this).parents('div').attr('address_id');
        // alert(order_id);
         $.ajaxSetup({     
                  headers: {         
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')   
                  } 
               }); 
        $.ajax({
          url:"/shop/deladdress",
          data:{address_id:address_id},
          dataType:'json',
          method:'post',
          success:function(res){
              if(res.code==1){
                alert('删除地址成功!');
                location.href='/shop/myaddress';
              }
          }
        })

     })

     $('.mr').click(function(){
        var address_id=$(this).parents('div').attr('address_id');
        // alert(address_id);
        $.ajaxSetup({     
                  headers: {         
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')   
                  } 
               }); 

        $.ajax({
          url:"/shop/mr",
          data:{address_id:address_id},
          dataType:'json',
          method:'post',
          success:function(res){
              if(res.code==1){
                alert('设置默认成功!');
                location.href='/shop/myaddress';
              }
          }
        })
     })


   </script>
  </body>
</html>