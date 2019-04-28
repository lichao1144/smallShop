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
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>购物车</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="{{asset('images/head.jpg')}}" />
     </div><!--head-top/-->
     <div class="dingdanlist" >
      <table>
       <tr>
        <td class="dingimg" width="75%" colspan="2"><a href="address">新增收货地址</a></td>
        
       </tr>
       <tr>
        <td>
         
          <table >
            <tr class="dz" value="{{$addressInfo->address_id}}">
              <td>收货人:{{$addressInfo->address_name}}</td>
              <td>收货地址:{{$addressInfo->province}}{{$addressInfo->city}}{{$addressInfo->area}}{{$addressInfo->address_detail}}</td>
              <td>收货人联系方式:{{$addressInfo->address_tel}}</td>
            </tr>
          </table>
         
        </td>
      </tr>
       <tr class="dingimg">
        <td  width="55%" >支付方式</td>
        <td id="fang">
          
          <button>支付宝</button>
        </td>
       </tr>
       
       <tr><td colspan="3" style="height:10px; background:#fff;padding:0;"></td></tr>
       <tr>
        <td class="dingimg" width="75%" colspan="3">商品清单</td>
       </tr>
       @foreach($goodsInfo as $key=>$value)
       <tr class="goodsInfo" goods_id="{{$value->goods_id}}">
        <td class="dingimg" width="15%"><img src="http://www.goodsimg.com/{{$value->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$value->goods_name}}</h3>
         <time>下单时间：{{$value->create_time}}</time>
        </td>
        <td align="right"><span class="qingdan">X {{$value->buy_number}}</span></td>
       </tr>
       <tr>
        <th colspan="3"><strong class="orange">¥{{$value->market_price}}</strong></th>
       </tr>
       @endforeach
       
       <tr>
        <td class="dingimg" width="75%" colspan="2">商品金额</td>
        <td align="right"><strong class="orange">¥{{$count}}</strong></td>
       </tr>
      
      
      </table>
     </div><!--dingdanlist/-->
     
     
    </div><!--content/-->
    
    <div class="height1"></div>
    <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong class="orange">¥{{$count}}</strong></td>
       <td width="40%"><a class="jiesuan">提交订单</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/style.js')}}"></script>
    <!--jq加减-->
    <script src="{{asset('js/jquery.spinner.js')}}"></script>
   <script>
	$('.spinnerExample').spinner({});
    $('#fang').click(function(){
      alert('aa');
      $(this).val('aa');
    });

    $('.jiesuan').click(function(){
      var _tr=$('.goodsInfo');
      var goods_id='';
       _tr.each(function(index){
                goods_id+=$(this).attr('goods_id')+',';
            })
      goods_id=goods_id.substr(0,goods_id.length-1);
      // alert(goods_id);
      
      // var address_id=$('.dz').val();
      // alert(address_id);

       $.ajaxSetup({     
                  headers: {         
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')   
                  } 
               });

        $.ajax({
          url:'/shop/submit',
          data:{goods_id:goods_id},
          method:'post',
          dataType:'json',
          success:function(res){
                if(res.code==1){
                    alert('下单成功!');
                    location.href='/shop/success?order_id='+res.order_id;
                }else{
                    alert('下单失败！');
                }
          }
        })
    })
	</script>
  </body>
</html>