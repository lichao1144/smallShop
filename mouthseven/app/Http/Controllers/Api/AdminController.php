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
        $rand=rand(1000,9999);
        $_SESSION['code']=$rand;
        //输出一个图片
        header('Content-Type: image/png');
// Create the image创建一个空的画板
        $im = imagecreatetruecolor(100, 30);

// Create some colors
        $white = imagecolorallocate($im, 255, 255, 255);
        $grey = imagecolorallocate($im, 0, 0, 0);
        $black = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 0, 0, 399, 29, $white);

// The text to draw
        $text = ''.$rand;
// Replace path by your own font path*******windows+r 输入fonts
        $font = 'C:\Windows\Fonts\Arvo-Regular.ttf';

        $i=0;
        while($i<4){
            imagettftext($im, 20, rand(-30,30), 15+20*$i, 25, $black, $font, $text[$i]);
            $i++;
        }

// Using imagepng() results in clearer text compared with imagejpeg()
        imagepng($im);
        imagedestroy($im);
        die;
    }
}
