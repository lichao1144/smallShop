<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    private $key='1144167099';
    /*
     * 客户端发送数据
     * */
    public function ClientSend(){
        $url="http://www.mouth7.com/admin/send";
        $arr=[
          'username'=>'lichao',
            'password'=>'123456'
        ];

        $res=$this->CurlPost($url,$arr);
        //echo $res;die;
        $data=json_decode($res,true);
        //解密服务端的加密数据s
        $Server_info=$this->Asymmetricencryption($data['data']);
        echo $Server_info;
        echo "<br>";
        //进行服务器和客户端的验签
        $sign=$this->checkSian($data['sign']);
        echo $sign;
    }

    /*
     * 封装curl
     * */
    private function CurlPost($url,$arr){
        # 数据加密
        $encrypt = $this->Asencrypt($arr);
//        dd($encrypt);
        # 生成签名
        $sign = $this->createSign($arr);
        $data = [
            'data' => $encrypt,
            'sign' => $sign
        ];
//        dd($data);
        # 1、初始化curl
        $ch = curl_init();
        # 2、设置请求的接口地址
        curl_setopt($ch, CURLOPT_URL, $url);
        # 3、POST提交
        curl_setopt($ch, CURLOPT_POST, 1);
        # 4、提交数据
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        # 5、发送请求
        $res = curl_exec($ch);
        # 6、关闭curl
        curl_close($ch);
        return $res;
    }

    /*
     * 加密数据----对称加密
     * */
    private function encrypt($data){
        $json_data=json_encode($data,JSON_UNESCAPED_UNICODE);
        $key='1144167099';
        $encryptData=base64_encode(openssl_encrypt($json_data,'DES-ECB',$key));
       // dd($encryptData);//"Wkl0WTFnbGhkM0pkaElaRzd3OWtDcDg2b3BlRFF0L0JmQ1pSWGZiUVBPcVpCYnpLdXlhUHpnPT0="
        return $encryptData;
    }

    /*
     * 加密数据----非对称加密
     * */
    private function Asencrypt($data){
//        dd($data);
        $json_str=json_encode($data,JSON_UNESCAPED_UNICODE);
        $i=0;
        $all='';
        while($sub_str=substr($json_str,$i,117)){
            openssl_public_encrypt($sub_str,$decrypt,file_get_contents('./publickey.txt'));
            $all.=$decrypt;
            $i+=177;
        }
        return base64_encode($all);
    }

    /*
     * 生成签名
     * */
    private function createsign($data){
//        dd($data);
            //1.对数组进行排序
        ksort($data);
        //2.转为json串
        $json_str=http_build_query($data);
        //3.拼接key
        $json_str.='&key='.$this->key;
        //4.生成sign
        return md5($json_str);
    }


    /*
     * 验证服务器的签名
     * */
    private function checkSian($data){
        $arr=[
            'username'=>'lichao',
            'password'=>'123456'
        ];

        ksort($arr);
        $json_str=http_build_query($arr);
        //3.拼接key
        $json_str.='&key='.$this->key;
        //4.生成sign
         $json_str=md5($json_str);
        //dd($json_str);//393094e47cbd5e242c3bc8d32c1691d6
       // dd($data);//b40203288aacc0ab622933854724d592
        if($data !=$json_str){
           return $arr=json_encode(['msg'=>'error sign','code'=>600]);die;
        }else{
            return $json_str;
        }
    }

    /*
     * 生成公钥私钥
     * */
    private function getkey(){
        //1.生成公钥私钥对
        $config=[
            "config"=>"C:\phpStudy\PHPTutorial\Apache\conf\openssl.cnf",
            "private_key_bits"=>"2048",
        ];
        $pk=openssl_pkey_new($config);
        // 得到私钥
        openssl_pkey_export($pk,$privateKey,null,$config);
        //得到公钥
        $pk = openssl_pkey_get_details($pk);
        $publicKey = $pk['key'];
    }

    /*
     * 解密服务端的数据-----非对称加密
     * */
    private function Asymmetricencryption($data){
//        dd($data);
        $i=0;
        $decrypt='';
        while($str_sub=substr($data,$i,172)){
            openssl_public_decrypt(base64_decode($str_sub),$all,file_get_contents('publickey.txt'));
            $decrypt.=$all;
            $i+=172;
        }
        return $decrypt;
    }
}
