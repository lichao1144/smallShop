<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TextController extends Controller
{
    public function wxbd(){
        $echostr=request()->echostr;
        echo $echostr;
        $this->guanzhu();
    }

    public function guanzhu(){
        $info = file_get_contents("php://input");
        $infostr=simplexml_load_string($info,"SimpleXMLElement",LIBXML_NOCDATA);
//        dd($infostr);
        $keywords = $infostr->Content;
        $toUserName = $infostr->ToUserName;
        $fromUserName = $infostr->FromUserName;
        if ($infostr->MsgType == 'event') {
            if ($infostr->Event == 'subscribe') {
                $re=new WeixinController();
                $token=$re->getAccessToken();
                $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$fromUserName&lang=zh_CN";
                $info=file_get_contents($url);
//                dd($info);
                $data=json_decode($info,true);
//                dd($data);
                $openid=$data['openid'];
                $userinfo=DB::table('trytext')->where('openid',$openid)->get()->toArray();
//                dd($userinfo);
                if(empty($userinfo)){
                    $nickname=$data['nickname'];
                    $datas=[
                        'openid'=>$openid,
                        'nickname'=>$nickname
                    ];
                    $res= DB::table('trytext')->insert($datas);
                    dd($res);
                }else{

                }
            }
        }
    }
}
