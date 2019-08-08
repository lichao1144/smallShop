<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    /*
     * 服务端处理并返回数据
     * */
    public function send(Request $request){
//        $data=$request->all();
//        dd($data);
        $arr=[
            'username'=>'lichao',
            'password'=>'123456'
        ];

        return $arr;
    }


    /*
     * 获取验证码图片的url
     * */
    public function getImageCodeUrl(){
        session_start();
        $sid=session_id();
        //dd($sid);
        $image_url='http://www.mouth7.com/image?sid='.$sid;

        $data=[
          'image_url'=>$image_url,
            'unique_id'=>$sid
        ];

        return $data;
    }

    /*
     * 生成随机码图片
     * */
    public function showImageCode(){
        $sid=request()->get('sid');
        session_id($sid);
        session_start();
        //输出一个图片
        header('Content-Type: image/png');
// Create the image创建一个空的画板
        $im = imagecreatetruecolor(300, 30);

// Create some colors
        $white = imagecolorallocate($im, 255, 255, 255);
        $grey = imagecolorallocate($im, 0, 0, 0);
        $black = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 0, 0, 399, 29, $white);

// The text to draw
        $rand=rand(1,4);
        switch ($rand){
            case 1:
                $a=rand(1,9);
                $b=rand(1,9);
                $result=$a+$b;
                $text=$a.'+'.$b.'=?';
                break;
            case 2:
                $a=rand(1,9);
                $b=rand(1,9);
                if($a<$b){
                    list($a,$b)=[$b,$a];
                }
                $result=$a-$b;
                $text=$a.'-'.$b.'=?';
                break;
            case 3:
                $a=rand(1,9);
                $b=rand(1,9);
                $result=$a*$b;
                $text=$a.'*'.$b.'=?';
                break;
            case 4:
                $a=rand(1,9);//2
                $b=rand(1,9);//4
                $c=$a*$b;
                $result=$a;
                $text=$c.'/'.$b.'=?';
            default:
                break;
        }
        $_SESSION['code']=$result;
// Replace path by your own font path*******windows+r 输入fonts
        $font = 'C:\Windows\Fonts\Arvo-Regular.ttf';

        $i=0;
        while($i<5){
            if(is_numeric($text[$i])){
                imagettftext($im, 14, rand(-30,30), 15+20*$i, 25, $black, $font, $text[$i]);
            }else{
                imagettftext($im, 14, 0, 15+20*$i, 25, $black, $font, $text[$i]);
            }
            $i++;
        }

// Using imagepng() results in clearer text compared with imagejpeg()
        imagepng($im);
        imagedestroy($im);
        die;
    }
}
