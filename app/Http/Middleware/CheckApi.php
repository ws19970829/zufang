<?php

namespace App\Http\Middleware;

use Closure;

class CheckApi
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
        $username = $request->header('username');
        $password = $request->header('password');
        $sign=$request->header('sign');
        $time = $request->header('time');
        //根据账号和密码进行登录
        $bool = auth()->guard('api')->attempt(['username'=>$username,'password'=>$password]);
        if(!$bool){
            return request()->json(['status'=>100,'msg'=>'登录异常','data'=>[]],401);
        }
        $token = auth()->guard('api')->user()->token;
        //验签
        $signate = md5($username.$token.$time.$password);
        if($signate!=$sign){
            return response()->json(['status'=>100,'msg'=>'登录异常','data'=>[]],401);
        }
        return $next($request);


    }
}
