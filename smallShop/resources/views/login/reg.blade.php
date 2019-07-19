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
    <script type="text/javascript" src="{{asset('layui/layui.js')}}"></script>
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
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="{{asset('images/head.jpg')}}" />
     </div><!--head-top/-->
     <class="reg-login">
      <h3>已经有账号了？点此<a class="orange" href="login">登陆</a></h3>
      <br>
      <div class="lrBox">
       <div class="lrList"><input type="text" name='u_email' placeholder="输入手机号码或者邮箱号" />
       </div>
       <div class="lrList2"><input type="text" name='u_code' placeholder="输入短信验证码" /> <button id="yz">获取验证码</button>
       </div>
       <div>
          <span id="spanb"> </span>
       </div>
       <div class="lrList"><input type="password" name='u_pwd' placeholder="设置新密码（6-18位数字或字母）" />
       </div>
       <div>
          <span id="spanc"> </span>
       </div>
       <div class="lrList"><input type="password" name='u_pwdr' placeholder="再次输入密码" /></div>
       <div>
          <span id="spand"> </span>
       </div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即注册" />
      </div>
     
     <div class="height1"></div>
     <div class="footNav">
      <dl>
       <a href="show">
        <dt><span class="glyphicon glyphicon-home"></span></dt>
        <dd>微店</dd>
       </a>
      </dl>
      <dl>
       <a href="prolist">
        <dt><span class="glyphicon glyphicon-th"></span></dt>
        <dd>所有商品</dd>
       </a>
      </dl>
      <dl>
       <a href="car">
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
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/style.js')}}"></script>
  </body>
  <script type="text/javascript">
    layui.use('layer',function(){

      var layer=layui.layer;

       //验证邮箱
        $('input[name=u_email]').blur(function(){
            var u_email=$(this).val();
            $(this).next().empty();
            var _this=$(this);
            var reg=/^[a-zA-Z]\w{5,17}@163.com$/;
            if(u_email==''){
              $(this).after("<span style='color:red'>注册邮箱不能为空!</span>");
              return false;
            }else if(!reg.test(u_email)){
              $(this).after("<span style='color:red'>注册邮箱格式不对!</span>");
              return false;
            }else{
                $.ajaxSetup({     
                  headers: {         
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')   
                  } 
               }); 

              $.ajax({
                        url:"/login/checkemail",
                        method:'post',
                        data:{u_email:u_email},
                        dataType:'json',
                        success:function(res){
                          if(res.code==1){
                            _this.after('<span style="color:red">邮箱已存在</span>')
                          }else if(res.code==2){
                            _this.after('<span style="color:green">√</span>')
                          }
                        }
                      });
            }
        })

        //验证验证码
        $('input[name=u_code]').blur(function(){
            var u_code=$(this).val(); 
            var reg=/^\d{6}$/;
            $(this).next('spanb').empty();
            if(u_code==''){
              $('#spanb').html("<span style='color:red'>验证码不能为空!</span>");
              return false;  
            }else if(!reg.test(u_code)){
              $('#spanb').html("<span style='color:red'>验证码格式不对</span>");
              return false;
            }else{
              $('#spanb').html("<span style='color:green'>√</span>");
            }
        })

        //验证密码
        $('input[name=u_pwd]').blur(function(){
            var u_pwd=$(this).val();
            $(this).next().empty();
            var reg=/^\w{1,6}$/;
            if(u_pwd==''){
              $(this).after("<span style='color:red'>注册密码不能为空!</span>");
              return false;
            }else if(!reg.test(u_pwd)){
              $(this).after("<span style='color:red'>注册密码格式不对!</span>");
              return false;
            }else{
              $(this).after('<span style="color:green">√</span>')
            }
        })

        //验证确认密码
        $('input[name=u_pwdr]').blur(function(){
            var u_pwdr=$(this).val();
            var u_pwd=$('input[name=u_pwd]').val();
            $(this).next().empty();
            var reg=/^\w{1,6}$/;
            if(u_pwdr==''){
              $(this).after("<span style='color:red'>注册重复密码不能为空!</span>");
              return false;
            }else if(!reg.test(u_pwdr)){
              $(this).after("<span style='color:red'>注册重复密码格式不对!</span>");
              return false;
            }else if(u_pwd!=u_pwdr){
              $(this).after("<span style='color:red'>两次密码不符合!</span>");
              return false;
            }else{
              $(this).after('<span style="color:green">√</span>')
            }
        })  

        //获取验证码
        $('#yz').click(function(){
          var u_email=$('input[name=u_email]').val();
          // alert(u_email);
          $('input[name=u_email]').next().empty();
          if(u_email==''){
            $('input[name=u_email]').after("<span style='color:red'>注册邮箱不能为空!</span>");
            return false;
          }

          $.ajaxSetup({     
              headers: {         
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')   
              } 
            }); 

          $.ajax({
              url:"/login/send",
              method:'post',
              data:{u_email:u_email},
              dataType:'json',
              success:function(res){
                  if(res.code==1){
                      alert('注册成功');
                  }else{
                      alert('注册失败');
                      return false;
                  }
              }
          })
        })


        $('input[type=submit]').click(function(){
          var u_email=$('input[name=u_email]').val();
          var u_code=$('input[name=u_code]').val();
          var u_pwd=$('input[name=u_pwd]').val();
          var u_pwdr=$('input[name=u_pwdr]').val();
          var flag=false;

          $.ajaxSetup({     
              headers: {         
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')   
              } 
            }); 

          $.ajax({
              url:"/login/checkcode",
              method:'post',
              data:{u_code:u_code,u_email:u_email,u_pwd:u_pwd,u_pwdr:u_pwdr},
              dataType:'json',
              success:function(res){
                if(res.code==2){
                    layer.msg(res.font,{icon:res.code});
                    flag=false;
                }else if(res.code==1){
                    layer.msg(res.font,{icon:res.code});
                    location.href=('/shop/login');
                }
              }
          });
          return flag;
    })
  })
       
  </script>
</html>
