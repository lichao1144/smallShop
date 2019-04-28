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
    
      <div class="lrBox">
       <div class="lrList"><input type="text" id="address_name" placeholder="收货人" /></div>
     
      
        <select id="province" class="changearea">
         <option value="0" selected="selected">省份/直辖市</option>
         @foreach($addressInfo as $key=>$value)
         <option value="{{$value->id}}">{{$value->name}}</option>
         @endforeach
        </select>
       
       
        <select id="city" class="changearea">
         <option>区县</option>
          <option value="0" selected="selected" >请选择...</option> 
        </select>
      
       
        <select id="area" class="changearea">
         <option>详细地址</option> 
          <option value="0" selected="selected" >请选择...</option> 
        </select>
      
      
         <div class="lrList"><input type="text" id="address_detail" placeholder="详细地址" /></div>
       <div class="lrList"><input type="text" id="address_tel" placeholder="手机" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" id="add_b" value="保存" />
      </div>
     
     
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
      <dl class="ftnavCur">
       <a href="/shop/user">
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
    //三级联动
    $('.changearea').change(function(){
      var _this=$(this);
      var _option="<option value='0' select='selected'>--请选择--</option>";

      _this.nextAll('select').html(_option);

      var id=_this.val();

      $.ajaxSetup({     
                  headers: {         
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')   
                  } 
               }); 
      $.ajax({
          url:'/shop/getarea',
          data:{id:id},
          dataType:'json',
          method:'post',
          success:function(res){
              for(var i in res){
                _option+="<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>";
              }
              _this.next('select').html(_option);
          }
      })

    });

    //添加
    $('#add_b').click(function(){
      var obj={};
        obj.province=$('#province').val();
        obj.city=$('#city').val();
        obj.area=$('#area').val();
        obj.address_name=$('#address_name').val();
        obj.address_detail=$('#address_detail').val();
        obj.address_tel=$('#address_tel').val();
        // console.log(obj);
        $.ajax({
              url:"/shop/addressadd",
              method:'post',
              data:obj,
              dataType:'json',
              success:function(res){
                  if(res.code==1){
                    alert('添加地址成功');
                    location.href="/shop/address";
                  }
              }
            })
    })
   </script>
  </body>
</html>