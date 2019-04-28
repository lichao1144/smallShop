<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{	
	//登陆
   	public function login(){

   		return view('login/login');
   	}

   	//注册
   	public function reg(){
   		return view('login/reg');
   	}

   	public function send(){
   		$u_email = request()->u_email;
   		// dd($u_email);
        $rand=rand(100000,999999);
        if($u_email){
            Mail::send('login.emailcode',['code'=>$rand],function($message)use($u_email) {
                //设置主题
                $message->subject("邮箱注册验证码");
                //设置接收方
                $message->to($u_email);
            });
            $data=['u_email'=>$u_email,'code'=>$rand];
            request()->session()->put('emailInfo',$data);
            return ['msg'=>'邮箱注册成功','code'=>1];
        }else{
            return ['msg'=>'请选择一个邮箱注册','code'=>2];
        }
   	}

   	//验证验证码
   	public function checkcode(){
   		$data=request()->all();
   		// dd($data);
   		$u_code=$data['u_code'];
   		// dd($u_code);
   		$emailInfo=request()->session()->get('emailInfo','default');
   		// dd($emailInfo);
   		unset($data['u_pwdr']);
   		// dd($data);
   		if($u_code==$emailInfo['code']){
			$res=DB::table('tp_user')->insert($data);
			return $res=['code'=>1,'font'=>'添加成功'];
   		}else{
   			return $res=['code'=>2,'font'=>'验证码错误'];
   		}

   		
   	}

   	//验证邮箱
   	public function checkemail(){
   		$u_email=request()->u_email;
   		// dd($u_email);
   		$res=DB::table('tp_user')->where('u_email',$u_email)->get()->toArray();
   		if($res){
   			return ['code'=>1,'msg'=>'用户名已存在'];
   		}else{
   			return ['code'=>2,'msg'=>'用户名可用'];
   		}
   	}

   	public function checkemailt(){
   		$u_email=request()->u_email;
   		// dd($u_email);
   		$res=DB::table('tp_user')->where('u_email',$u_email)->get()->toArray();
   		if($res){
   			return ['code'=>1,'msg'=>'对'];
   		}else{
   			return ['code'=>2,'msg'=>'错'];
   		}
   	}

   	public function checkpwd(){
   		$u_pwd=request()->u_pwd;
   		// dd($u_pwd);
   		$res=DB::table('tp_user')->where('u_pwd',$u_pwd)->get()->toArray();
   		if($res){
   			return ['code'=>1,'msg'=>'对'];
   		}else{
   			return ['code'=>2,'msg'=>'错'];
   		}
   	}

   	public function denglu(){
   		$u_email=request()->u_email;
   		$u_pwd=request()->u_pwd;
   		// dd($u_pwd);
   		$res=DB::table('tp_user')->where('u_email',$u_email)->first();
   		// dd($res);
   		if($res){
   			if($u_pwd==$res->u_pwd){
               $u_id=$res->u_id;
               request()->session()->forget('userInfo');
               $data=['u_email'=>$u_email,'u_pwd'=>$u_pwd,'u_id'=>$u_id];
               request()->session()->put('userInfo',$data);
               // dd(request()->session()->get('userInfo',$data));
   				return ['code'=>1,'msg'=>'对']; 
   			}else{
   				return ['code'=>2,'msg'=>'错'];
   			}
   		}else{
   			return ['code'=>2,'msg'=>'错'];
   		}
   	}
}
