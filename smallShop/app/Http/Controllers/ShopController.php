<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use \Log;
class ShopController extends Controller
{	
	//商品主页
    public function show(){
        $param=request()->input();
        $where=[];
        $goods_name=$param['goods_name']??'';
        if($goods_name){
            $where[]=['goods_name','like',"%$goods_name%"];
        }

       $data=request()->session()->get('userInfo');
       // dd($data);
       // $data=session('userInfo');
       //商品分类展示
       $cateInfo=$this->cateInfo();

       //商品总条数
       $goodsNumber=DB::table('tp_goods')->where(['is_on_sale'=>1])->count();
       // dd($goodsNumber);
       //商品详细信息
       $goodsInfo=DB::table('tp_goods')->where($where)->limit(6)->get();
    	return view('shop/show',compact('data','cateInfo','goodsInfo','goodsNumber'));	
    }

    //所有商品页
    public function prolist($cate_id=0){
        $cate_id=request()->cate_id;
        $where=[];
        $cate_id=$cate_id??'';
        if($cate_id){
            $where[]=['cate_id','=',$cate_id];
        }
        // dd($cate_id);
        $goodsInfo=DB::table('tp_goods')->where($where)->get();
        // dd($goodsInfo);
    	return view('shop/prolist',['goodsInfo'=>$goodsInfo]);
    }

    //商品详情页
    public function proinfo(){
        $goods_id=request()->goods_id;
        // dd($goods_id);
        // 获取缓存信息
        $goodsInfo=cache('goodsInfo'.$goods_id);
        //如果没有
        if(!$goodsInfo){
            // echo 1;die;
            // 进行数据库查询
            $goodsInfo=DB::table('tp_goods')->where('goods_id',$goods_id)->first();
            //并进行数据的缓存添加
            Cache::put(['goodsInfo'.$goods_id=>$goodsInfo],60*24);    
        // } else{
        //     echo 2;die;
        }
        // dd($goodsInfo);
        return view('shop/proinfo',['goodsInfo'=>$goodsInfo]);

    }

    //添加购物车
    public function addcar(){
        $data=request()->all();
        // dd($data);
        $goods_id=$data['goods_id'];
        $buy_number=$data['buy_number'];
        // dd($buy_number);
        // dd($goods_id);
        $userInfo=session('userInfo');
        $u_id=$userInfo['u_id'];

        //买过商品再次购买添加收藏
        $where=[
            'goods_id'=>$goods_id,
            'u_id'=>$u_id,
            'is_del'=>2
        ];

        $again=DB::table('tp_car')->where($where)->first();
        if($again){
            $data=[
                'is_del'=>1,
                'buy_number'=>$buy_number
            ];
            $res=DB::table('tp_car')->where('goods_id',$goods_id)->update($data);
            if($res){
                echo json_encode(['code'=>1]);
            }
        }else{
            $create_time=time();
            $data['create_time']=$create_time;
            $data['u_id']=$u_id;
            $where=[
                'goods_id'=>$goods_id,
                'u_id'=>$u_id
            ];
            $carInfo=DB::table('tp_car')->where($where)->first();
            // dd($carInfo);
            if(empty($carInfo)){
            // echo 1 ;die;  
                $res=DB::table('tp_car')->insert($data);
                // dd($res);
                if($res){
                    return ['code'=>1];
                }else{
                    return ['code'=>2];
                }
            }else{  
            // echo 2 ;die;  
                $updateInfo=[
                    'buy_number'=>$buy_number+$carInfo->buy_number,
                ];
                // dd($updateInfo);
                $where=[
                    'goods_id'=>$goods_id,
                    'u_id'=>$u_id
                ];
                $res=DB::table('tp_car')->where($where)->update($updateInfo);
                // dd($res);
                if($res){
                    return ['code'=>1];
                }else{
                    return ['code'=>2];
                }  
            }
        }


        
    }


    //购物车列表
    public function car(){
        //购物车条数
        $userInfo=request()->session()->get('userInfo');
        $u_id=$userInfo['u_id'];
        // dd($u_id);
        $where=[
            'is_del'=>1,
            'u_id'=>$u_id
        ];
        $car=DB::table('tp_car')->where($where)->count();
        // dd($car);
        $userInfo=request()->session()->get('userInfo');
        $u_id=$userInfo['u_id'];
        //购物车详情信息
        $where=[
            'is_del'=>1,
            'u_id'=>$u_id
        ];
        $carInfo = DB::table('tp_car')
            ->join('tp_goods', 'tp_car.goods_id', '=', 'tp_goods.goods_id')
            ->where($where)
            ->get();
        // dd($carInfo);
        
        //总价
        
    	return view('shop/car',['carInfo'=>$carInfo],['car'=>$car]);
    }

    //支付页面
    public function pay(){
        $userInfo=request()->session()->get('userInfo');
        $u_id=$userInfo['u_id'];
        // dd($u_id);
        $where=[
            'u_id'=>$u_id,
            'is_defaut'=>2
        ];
        // dd($where);
        //地址展示
        $addressInfo=DB::table('tp_address')->where($where)->first();
        // dd($addressInfo);
        if(empty($addressInfo)){    
            return view('shop/pay',compact('goodsInfo','count','addressInfo'));
            die;
        }else{
               $province=$addressInfo->province;
               $city=$addressInfo->city;
               $area=$addressInfo->area;
               $addressInfo->province=DB::table('tp_area')->where('id',$province)->value('name');
               $addressInfo->city=DB::table('tp_area')->where('id',$city)->value('name');
               $addressInfo->area=DB::table('tp_area')->where('id',$area)->value('name');
               // dd($addressInfo);
               
                //查询价格
                $goods_id=request()->goods_id;
                // dd($goods_id);
                $goods_id=explode(',',$goods_id);
                $goodsInfo=DB::table('tp_car')
                    ->join('tp_goods','tp_car.goods_id','=','tp_goods.goods_id')
                    ->whereIn('tp_car.goods_id',$goods_id)
                    ->get();
                // dd($goodsInfo);
                $count=0;
                foreach ($goodsInfo as $k => $v) {
                    $count+=$v->market_price*$v->buy_number;
                }
                // dd($count);
                // return view('shop/pay',['goodsInfo'=>$goodsInfo],['count'=>$count],['addressInfo'=>$addressInfo]);
                return view('shop/pay',compact('goodsInfo','count','addressInfo'));
        }
      
    }

    public function cateInfo(){
        $cateInfo=DB::table('tp_category')->limit(6)->get();
        return $cateInfo;
    }

    //计算总价格
    public function countTotal(){
        $goods_id=request()->goods_id;
        $goods_id=explode(',',$goods_id);
        // dd($goods_id);
        if(empty($goods_id)){
            echo 0;die;
        }
       $info=DB::table('tp_car')
            ->join('tp_goods','tp_car.goods_id','=','tp_goods.goods_id')
            ->whereIn('tp_car.goods_id',$goods_id)
            ->get()
            ->toArray();
            // dd($info);
        $count=0;
        foreach ($info as $k => $v) {
            $count+=$v->market_price*$v->buy_number;
            
        }
        echo $count;
    }

    //检测登陆
    public function checklogin(){
        if(!empty(session('userInfo'))){
            echo json_encode(['code'=>1]);
        }else{
             echo json_encode(['code'=>2]);
        }
    }

    //添加地址页面
    public function address(){
        $addressInfo=DB::table('tp_area')->where(['pid'=>0])->get();
        // dd($addressInfo);
        return view('shop/address',['addressInfo'=>$addressInfo]);
    }

    //获取三级联动
    public function getarea(){
        $id=request()->id;
        // dd($id);
        $where=[
            ['pid','=',$id]
        ];
        $addressInfo=DB::table('tp_area')->where($where)->get();
        // dd($addressInfo);
        if(!empty($addressInfo)){
            echo json_encode($addressInfo);
        }
    }

    //添加地址
    public function addressadd(){
        $data=request()->all();
        // dd($data);
        $userInfo=request()->session()->get('userInfo');
        $u_id=$userInfo['u_id'];
        $data['u_id']=$u_id;
        $res=DB::table('tp_address')->insert($data);
        if($res){
            echo json_encode(['code'=>1]);
        }else{
            echo json_encode(['code'=>2]);
        }
    }

    //个人中心
    public function user(){
        $userInfo=session('userInfo');
        // dd($userInfo);
        return view('shop/user',['userInfo'=>$userInfo]);
    }

    //退出登录
    public function out(){
        request()->session()->forget('userInfo');
        echo json_encode(['code'=>1]);
    }

    //支付成功页面
    public function submit(){
        $goods_id=request()->goods_id;
        // dd($goods_id);
        DB::beginTransaction();
        try{
            //用户id
            $userInfo=request()->session()->get('userInfo');
            $u_id=$userInfo['u_id'];
            //获取订单号
            $order_no=$this->createOrderNo($u_id);
            // dd($order_no);
            //获取订单商品总价格
            $goods_id=explode(',',$goods_id);
            // dd($goods_id);
            $goodsInfo=DB::table('tp_car')
            ->join('tp_goods','tp_car.goods_id','=','tp_goods.goods_id')
            ->whereIn('tp_car.goods_id',$goods_id)
            ->get();
            // dd($goodsInfo);
            $count=0;
            foreach ($goodsInfo as $k => $v) {
                $count+=$v->market_price*$v->buy_number;
            }
            $order_amount=$count;
            // dd($order_amount);
            
            //添加订单信息---------------------------------------------
            $orderInfo['order_no']=$order_no;
            $orderInfo['order_amount']=$order_amount;
            $orderInfo['u_id']=$u_id;
            $res1=DB::table('tp_order')->insert($orderInfo);
            // dd($res1);
            if($res1==false){
                throw new Exception("订单添加失败");
            }


            //订单详情添加--------------------------------------------
            $order_id=DB::getPdo()->lastInsertId();
            // dd($order_id);
            $where=[
                'u_id'=>$u_id,
                'is_del'=>1
            ];
            $news=DB::table('tp_car')
                ->join('tp_goods','tp_car.goods_id','=','tp_goods.goods_id')
                ->whereIn('tp_car.goods_id',$goods_id)
                ->select('tp_goods.goods_id','goods_name','market_price','goods_img','buy_number','goods_number')
                ->get();
            // dd($news);
            $news=json_decode( json_encode($news),true);
            // dd($news);
            foreach ($news as $key => $value) {
                $news[$key]['order_id']=$order_id;
                $news[$key]['u_id']=$u_id;
                unset($news[$key]['goods_number']);
                
            }
            
            // dd($news);
            $res2=DB::table('tp_order_detail')->insert($news);
            // dd($res2);
            if(empty($res2)){
                 throw new Exception("订单详情添加失败");    
            }

            //订单地址添加---------------------------------------------
            $where=[
                'u_id'=>$u_id,
                'is_defaut'=>2,
                'is_del'=>1
            ];

            $addressInfo=DB::table('tp_address')->where($where)->get()->toArray();
            // dd($addressInfo);
            $addressInfo= json_decode(json_encode($addressInfo),true);
            foreach ($addressInfo as $key => $value) {
                $addressInfo[$key]['order_id']=$order_id;
                unset($addressInfo[$key]['address_id']);
                unset($addressInfo[$key]['is_defaut']);
            }
            // dd($addressInfo);
            $res3=DB::table('tp_order_address')->insert($addressInfo);
            // dd($res3);
            
            
            //购物测删除-----------------------------------------------
            $where=[
                'is_del'=>1,
                'u_id'=>$u_id
            ];

            $res4=DB::table('tp_car')->whereIn('goods_id',$goods_id)->where($where)->update(['is_del'=>2]);
            // dd($res4);

            //库存减少
                $newss=DB::table('tp_car')
                    ->join('tp_goods','tp_car.goods_id','=','tp_goods.goods_id')
                    ->whereIn('tp_car.goods_id',$goods_id)
                    ->select('tp_goods.goods_id','goods_name','market_price','goods_img','buy_number','goods_number')
                    ->get();
                // dd($newss);
                $newss=json_decode( json_encode($newss),true);
                // dd($newss);
            foreach ($newss as $key => $value) {
                $goods_id=[
                    ['goods_id','=',$value['goods_id']]
                ];

                $update=[
                    'goods_number'=>$value['goods_number']-$value['buy_number']
                ];

                $res5=DB::table('tp_goods')->where($goods_id)->update($update);
            }
            // dd($res5);
            DB::commit();

            $arr=[
                'code'=>1,
                'font'=>'下单成功',
                'order_id'=>$order_id
            ];

            echo json_encode($arr);
        }

        catch(Exception $e) {
            DB::rollBack();
            $e->getMessage();
        }
    }

    //获得订单号
    public function createOrderNo($u_id){
        return date('Ymd').rand(1000,9999).$u_id;
    }

    //下单成功
    public function success(){
        $order_id=request()->order_id;
        // dd($order_id);
        $orderInfo=DB::table('tp_order')->where('order_id',$order_id)->first();
        // dd($orderInfo);
        return view('shop/success',['orderInfo'=>$orderInfo]);
    }

    //个人中心地址展示
    public function myaddress(){
        $userInfo=request()->session()->get('userInfo');
        $u_id=$userInfo['u_id'];
        $where=[
            'is_del'=>1,
            'u_id'=>$u_id
        ];
        $addressInfo=DB::table('tp_address')->where($where)->get();
        // dd($addressInfo);
        foreach ($addressInfo as $key => $value) {
            $province=$value->province;
            $city=$value->city;
            $area=$value->area;
            $value->province=DB::table('tp_area')->where('id',$province)->value('name');
            $value->city=DB::table('tp_area')->where('id',$city)->value('name');
            $value->area=DB::table('tp_area')->where('id',$area)->value('name');
        }
       
        // dd($addressInfo);
        return view('shop/myaddress',['addressInfo'=>$addressInfo]);
    }

    //删除地址
    public function deladdress(){
        $address_id=request()->address_id;
        // dd($order_id);
        $userInfo=request()->session()->get('userInfo');
        $u_id=$userInfo['u_id'];
        // dd($u_id);
        $where=[
            'address_id'=>$address_id,
            'u_id'=>$u_id
        ];
        $res=DB::table('tp_address')->where($where)->delete();
        if($res){
            echo json_encode(['code'=>1]);
        }else{
            echo json_encode(['code'=>2]);
        }
    }

    //设置默认
    public function mr(){
        $address_id=request()->address_id;
        // dd($address_id);
        $userInfo=request()->session()->get('userInfo');
        $u_id=$userInfo['u_id'];
        $where=[
            'u_id'=>$u_id
        ];
        $data=['is_defaut'=>1];
        $res1=DB::table('tp_address')->where($where)->update($data);
        // dd($res1);
        
        $data=['is_defaut'=>2];
        $where=[
            'u_id'=>$u_id,
            'address_id'=>$address_id
        ];
        $res2=DB::table('tp_address')->where($where)->update($data);
        if($res1 && $res2){
            echo json_encode(['code'=>1]);
        }else{
            echo json_encode(['code'=>2]);
        }

    }

    //修改地址
    public function update(){
        $address_id=request()->address_id;
        // dd($address_id);
        $userInfo=request()->session()->get('userInfo');
        $u_id=$userInfo['u_id'];
        $where=[
            'u_id'=>$u_id,
            'address_id'=>$address_id
        ];
        $info=DB::table('tp_address')->where($where)->first();
        // dd($info);


        $addressInfo=DB::table('tp_area')->where(['pid'=>0])->get();
        // dd($addressInfo);
        return view('shop/update',['addressInfo'=>$addressInfo],['info'=>$info]);
    }

    //修改成功
    public function updateHandle(){
        $data=request()->all();
        // dd($data);
        $address_id=$data['address_id'];
        // dd($address_id);
        $res=DB::table('tp_address')->where('address_id',$address_id)->update($data);
        // dd($res);
        if($res){
            echo  json_encode(['code'=>1]);
        }else{
            echo  json_encode(['code'=>2]);
        }
    }

    //支付宝
    public function paysuccess(){
        $order_id=request()->order_id;
        // dd($order_id);
        $data=DB::table('tp_order')->where('order_id',$order_id)->first();
        // dd($data);
        //配置
        $config = config('pay');
        require_once app_path('alipay/pagepay/service/AlipayTradeService.php');//类
        require_once app_path('alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');//类
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $out_trade_no = $data->order_no;
            //订单名称，必填
            $subject = "您购买的商品";
            //付款金额，必填
            $total_amount = $data->order_amount;
            //构造参数
            $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setOutTradeNo($out_trade_no);
            $aop = new \AlipayTradeService($config);
            /**
             * pagePay 电脑网站支付请求
             * @param $builder 业务参数，使用buildmodel中的对象生成。
             * @param $return_url 同步跳转地址，公网可以访问
             * @param $notify_url 异步通知地址，公网可以访问
             * @return $response 支付宝返回的信息
            */
            $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
            //输出表单
            var_dump($response);
    }

    public function returnAlipay(){
        // echo 11;die;
        $config = config('pay');
        require_once app_path('alipay/pagepay/service/AlipayTradeService.php');
        $arr=$_GET;
        // print_r($arr);
        // dd($arr);
        $alipaySevice = new \AlipayTradeService($config); 
        $result = $alipaySevice->check($arr);
        // dd($result);
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码          
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            //商户订单号
            $where['order_no'] = htmlspecialchars($_GET['out_trade_no']);
            $where['order_amount'] = htmlspecialchars($_GET['total_amount']);
            $counts=DB::table('tp_order')->where($where)->count();
            // dd($counts);
            if(!$counts){
                $result=json_encode($arr);
                 Log::channel('alipay')->info('订单和金额不符，没有当前记录'.$result);
            }

            if(htmlspecialchars($_GET['seller_id']) != config('pay.seller_id') || htmlspecialchars($_GET['app_id']) != config('pay.app_id')){
                Log::channel('alipay')->info('商户不符'.$result);
            }
            // echo 'ok';die;
            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);
            Log::channel('alipay')->info("验证成功<br />支付宝交易号：".$trade_no);
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——  
            return redirect('/shop/show');          
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "验证失败";
        }
    }

    public function returnAlipayB(){
        /* *
         * 功能：支付宝服务器异步通知页面
         * 版本：2.0
         * 修改日期：2017-05-01
         * 说明：
         * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

         *************************页面功能说明*************************
         * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
         * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
         * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
         */
        $config = config('pay');
        require_once app_path('alipay/pagepay/service/AlipayTradeService.php');
        $arr=$_POST;
        dd($arr);
        $alipaySevice = new AlipayTradeService($config); 
        $alipaySevice->writeLog(var_export($_POST,true));
        $result = $alipaySevice->check($arr);
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代          
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——          
            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表          
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            if($_POST['trade_status'] == 'TRADE_FINISHED') {
                //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                    //如果有做过处理，不执行商户的业务程序            
                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            }
            else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                    //如果有做过处理，不执行商户的业务程序            
                //注意：
                //付款完成后，支付宝系统发送该交易状态通知
            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
            echo "success"; //请不要修改或删除
        }else {
            //验证失败
            echo "fail";

        }
    }

}
