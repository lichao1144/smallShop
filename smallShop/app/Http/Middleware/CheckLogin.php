<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if(!request()->session()->get('userInfo')){
           // $request->session()->forget('userInfo'); 
          echo "<script>alert('请登陆！');location.href='/login/login'</script>";
        }
        return $next($request);
    }
}
