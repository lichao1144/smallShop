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
       <h1>产品详情</h1>
      </div>
     </header>
    
     <div id="sliderA" class="slider">
      <img src="http://www.goodsimg.com/{{$goodsInfo->goods_img}}" />
     </div><!--sliderA/-->
     <div>
      <input type="hidden" name="goods_id" value="{{$goodsInfo->goods_id}}">
       商品名称:{{$goodsInfo->goods_name}}
     </div>
     <table class="jia-len">
      <tr>
       <th><strong style="color: 333333">本店价格:</strong><strong class="orange">¥{{$goodsInfo->shop_price}}</strong></th>
       <th>
         <strong style="color: 333333">剩余库存:</strong>
         <strong id="goods_number">{{$goodsInfo->goods_number}}</strong>
       </th>
       <td>
          
          <button id="jian">-</button>
          <input type="text" id="buy_number" value="1" style="width: 50px;border-color:808080;">
          <button id="jia">+</button>
      
       </td>
      </tr>
      <tr>
       <td>
        <strong>三级分销农庄有机毛豆500g</strong>
        <p class="hui">富含纤维素，平衡每日膳食</p>
       </td>
       <td align="right">
        <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
       </td>
      </tr>
     </table>
     <div class="height2"></div>
     <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品简介</a>
      <a href="javascript:;">商品参数</a>
      <a href="javascript:;" style="background:none;">订购列表</a>
      <div class="clearfix"></div>
     </div><!--zhaieq/-->
     <div class="proinfoList">
        {{$goodsInfo->description}}
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息....
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息......
     </div><!--proinfoList/-->
     
     <table class="jrgwc">
      <tr>
       <th>
        <a href="show"><span class="glyphicon glyphicon-home"></span></a>
       </th>
       <td><a id="car">加入购物车</a></td>
      </tr>
     </table>
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/style.js')}}"></script>
    <!--焦点轮换-->
    <script src="{{asset('js/jquery.excoloSlider.js')}}"></script>
    <script>
		$(function () {
		 $("#sliderA").excoloSlider();
		});
	</script>
     <!--jq加减-->
    <script src="{{asset('js/jquery.spinner.js')}}"></script>
   <script>
	$('.spinnerExample').spinner({});


      //减号
      $('#jian').click(function(){
        var buy_number=parseInt($(this).next('input').val());
        if(buy_number<=1){
          $(this).prop("disabled",true);
        }else{
          buy_number=buy_number-1;
          $('#buy_number').val(buy_number);
          $('#jia').prop("disabled",false);
        }
        
      });

      //加号
      $('#jia').click(function(){
        var goods_number=parseInt($('#goods_number').text());
        var buy_number=parseInt($(this).prev('input').val());
        if(buy_number>=goods_number){
          $(this).prop("disabled",true);
        }else{
          buy_number=buy_number+1;
          $('#buy_number').val(buy_number);
          $('#jian').prop("disabled",false);
        }  
      });

      //购买数量
      $('#buy_number').blur(function(){
        var goods_number=parseInt($('#goods_number').text());
        var buy_number=$(this).val();
        var reg=/^\d{1,}$/;
        if(buy_number<1 || buy_number=='' || !reg.test(buy_number)){
                $(this).val('1');
            }else if(parseInt(buy_number)>parseInt(goods_number)){
                 $(this).val(goods_number);
            }else{
                $(this).val(parseInt(buy_number));
            }
      });

      //购物车
      $('#car').click(function(){
        var goods_id=$('input[type=hidden]').val();
        var buy_number=$('#buy_number').val();
         $.ajaxSetup({     
                  headers: {         
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')   
                  } 
               }); 

        $.ajax({
          url:"/shop/addcar",
          data:{goods_id:goods_id,buy_number:buy_number},
          dataType:'json',
          success:function(res){
              if(res.code==1){
                alert('添加购物成功');
                location.href="/shop/proinfo"+'/'+goods_id;
              }
          }
        });
      });
	</script>
  </body>
</html>