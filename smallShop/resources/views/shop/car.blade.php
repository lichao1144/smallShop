<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="images/favicon.ico" />
    
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
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange">{{$car}}</strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url({{asset('images/xian.jpg')}}) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>
      <input type="checkbox" id="allcheck" /> 全选
     @foreach($carInfo as $key=>$value)
     <div class="dingdanlist">
      <table>
       <tr>
        <td width="100%" colspan="4">
          <a href="javascript:;">
         
        </a>
        </td>
       </tr>

       <tr goods_id={{$value->goods_id}}>
        <td width="4%"><input class="xz" type="checkbox" /></td>
        <td class="dingimg" width="15%"><img src="http://www.goodsimg.com/{{$value->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$value->goods_name}}</h3>
         剩余库存:<h3 id="goods_number">{{$value->goods_number}}</h3>
         <time>下单时间：{{$value->create_time}}</time>
        </td>
        <td>
            <button class="jian">-</button>
          <input type="text" class="buy_number" value="{{$value->buy_number}}" style="width: 50px;border-color:808080;">
            <button class="jia">+</button>
        </td>
       </tr>
       <tr>
        <th colspan="4"><strong class="orange">¥{{$value->market_price}}</strong></th>
       </tr>
      </table>
     </div><!--dingdanlist/-->
     @endforeach
     <div class="height1"></div>
     <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：<strong id="count" class="orange">¥0</strong></td>
       <td width="40%"><a id="pay" class="jiesuan">去结算</a></td>
      </tr>
     </table>
    </div><!--gwcpiao/-->
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="js/style.js"></script>
    <!--jq加减-->
    <script src="{{asset('js/jquery.spinner.js')}}"></script>
   <script>
	$('.spinnerExample').spinner({});

     //减号
      $('.jian').click(function(){
        var buy_number=parseInt($(this).next('input').val());
        // alert(buy_number);
        if(buy_number<=1){
          $(this).prop("disabled",true);
        }else{
          buy_number=buy_number-1;
          $(this).next().val(buy_number);
          $('.jia').prop("disabled",false);
        }
        
      });

      //加号
      $('.jia').click(function(){
        var goods_number=parseInt($('#goods_number').text());
        var buy_number=parseInt($(this).prev('input').val());
        if(buy_number>=goods_number){
          $(this).prop("disabled",true);
        }else{
          buy_number=buy_number+1;
          $(this).prev().val(buy_number);
          $('.jian').prop("disabled",false);
        }  
      });

       //购买数量
      $('.buy_number').blur(function(){
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

      //全选
      $('#allcheck').click(function(){
         var checked=$(this).prop('checked');
         if(checked==true){
          $('.xz').prop('checked',checked);
            countTotal();
          }else{
            $('.xz').prop('checked',false);
            $('#count').text('');
          }
            
      })

      //求总价格
       function countTotal(){
        var box=$('.xz');
        var goods_id='';
        box.each(function(index){
          if($(this).prop('checked')==true){
            goods_id+=$(this).parents("tr").attr("goods_id")+',';
          }
        })
        // alert(goods_id);
        goods_id=goods_id.substr(0,goods_id.length-1);
        // alert(goods_id);
         $.ajaxSetup({     
                  headers: {         
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')   
                  } 
               }); 
        $.ajax({
                    url:"/shop/countTotal",
                    method:'post',
                    data:{goods_id:goods_id},
                    success:function(res){
                        $('#count').text(res);
                    }
                })
       }

       //单选框
       $('.xz').click(function(){
          // alert('aa');
        var checked=$(this).prop('checked');
        
            countTotal();
          
       })

       //结算
       $('#pay').click(function(){
            var box=$('.xz');
            var goods_id='';
            box.each(function(index){
              if($(this).prop('checked')==true){
                goods_id+=$(this).parents("tr").attr("goods_id")+',';
              }
            })
            var goods_id=goods_id.substr(0,goods_id.length-1);

            if(goods_id.length==''){
                    return false;
                }
            $.ajaxSetup({     
                  headers: {         
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')   
                  } 
               }); 
            $.ajax({
              url:"/shop/checklogin",
              dataType:'json',
              method:'post',
              success:function(res){
                  if(res.code==1){
                      location.href="/shop/pay?goods_id="+goods_id;
                  }else if(res.code==2){
                    alert('请先登陆');
                    location.href="/login/login";
                  }
              }
            })
       })
	</script>
  </body>
</html>