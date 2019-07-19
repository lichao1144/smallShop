<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class ApiMiddleware
{
    private $key='1144167099';
    private $error_count='5';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //接口防刷 ----【1分钟内调用不能超过150次，超过加入黑名单1小时】
        $black=$this->Antiattack();
        if($black['code']==1){
            return response($black);
        }
        //接受客户端传递的数据，并解密
        //1.对数据进行解密
        $data=$this->Asdecrypt();
        //2.验证数据签名，防止篡改
        $checknum=$this->checkSgin($data);
        if($checknum['code']==200){
            $request->request->replace($data);
            //接受返回数据，对返回数据进行加密
            $response=$next($request);
            $api_response=[];
            $api_response['data']=$this->Asencrypt($response->original);
            //dd($api_response['data']);
            $api_response['sign']=$this->_createServiceSign($response->original,$data);
            //dd($api_response);
            return response($api_response);
        }else{
            return response($checknum);
        }
    }

    /*
     * 对客户端数据进行解密------对称加密
     * */
    private function decrypt(){
        $data=request()->post('data');
//        dd($data);
        $key='1144167099';
        $decrypt=openssl_decrypt(
            base64_decode($data),
            'DES-ECB'
            ,$key);
//        dd($decrypt);
        return json_decode($decrypt,true);
    }

    /*
     *对客户端数据进行解密------非对称加密
     * */
    private function Asdecrypt(){

        $data=request()->post('data');
        $data=base64_decode($data);
        $i=0;
        $all='';
        while($sub_str=substr($data,$i,177)){
            openssl_private_decrypt($sub_str,$encrypt,file_get_contents('./privatekey.txt'));
            $all.=$encrypt;
            $i+=177;
        }
        return json_decode($all,true);
    }

    /*
     * 验证sign
     * */
    private function checkSgin($data){
        $sign=request()->post('sign');
//        dd($sign);
       if(empty($sign)){

       }
//        dd($data);
        //1.ksort
        ksort($data);
        //2.json
        $json_str=http_build_query($data);
        //3.拼接
        $json_str.='&key='.$this->key;
        //4.验证
        $server_sign=md5($json_str);
        if($server_sign != $sign){
            return $arr=['msg'=>'client sign error','code'=>500];
        }else{
            return $arr=['msg'=>'success','code'=>200];
        }
    }

    /*
     * 防刷
     * */
    private function Antiattack(){
        //获取用户ip
        $ip = request()->ip();
        $ip_key = 'IP:'.$ip;
        //先判断ip是否存在黑名单中，如果在就不让继续访问了
        $black_key = 'black_list';
        $black_list = Redis::zRange($black_key,0,-1);
        if(in_array($ip,$black_list)){
            // 先判断今日黑名单的时候，是否超过一小时
            $join_time = Redis::zScore($black_key,$ip);
            //如果不超过一小时，不让访问
            if(time() - $join_time < 60 * 60){
                return $this->fail('限制时间还未过，请稍后重试');
            }else{
                Redis::zRem($black_key,$ip);
            }
        }

        $count = Redis::incr($ip_key);
        //第一次访问   设置有效时间  1分钟
        if($count == 1){
            Redis::expire($ip_key,60);
        }
        //如果大于指定次数，加入黑名单
        if($count > $this->error_count){
            //加入黑名单
            Redis::zAdd($black_key,time(),$ip);
            return $this->fail('访问次数太频繁已被加入黑名单，请稍后重试');
        }
    }

    private function fail($msg='fail',$code=1,$data=[]){
        return $arr=[
          'code'=>$code,
            'msg'=>$msg,
            'data'=>$data
        ];
    }

    /*
     * 服务器加密数据------对称加密
     * */
    private function _AesEncrypt(){
        $data=request()->post('data');

        $json_str=json_encode($data);
       $encrypt=base64_encode(openssl_encrypt($json_str, 'DES-ECB',$this->key));

        return $encrypt;
    }


    /*
     *服务器加密数据------非对称加密
     * */
    private function Asencrypt($data){
        $json_str=json_encode($data);
        $i=0;
        $encrypt='';
        while($sub_str=substr($json_str,$i,117)){
            openssl_private_encrypt($sub_str,$all,file_get_contents('./privatekey.txt'));
            $encrypt.=base64_encode($all);
            $i+=117;
        }
        return $encrypt;
//        dd($all);
    }



    /*
     * 服务器加密
     * */
    private function _createServiceSign($data){
        //1.对数组进行排序
        ksort($data);
        //2.转为json串
        $json_str=http_build_query($data);
        //3.拼接key
        $json_str.='&key='.$this->key;
        //4.生成sign
        //dd(md5($json_str));
        return md5($json_str);
    }
}
