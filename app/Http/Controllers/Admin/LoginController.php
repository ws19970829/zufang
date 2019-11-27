<?php

namespace App\Http\Controllers\Admin;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use Illuminate\Mail\Message;
class LoginController extends Controller
{
    //
    public function index(){
//        dd(bcrypt('admin'));
        return view('admin.login.index');
    }
    public function login(Request $request){
        // var_dump(session('CAPTCHA_IMG'));die;
       $data= $this->validate($request,[
            'username'=>'required',
            'password'=>'required',
             "captcha"=>'required|captcha',
        ]);

        unset($data['captcha']);
        
        $bool=auth()->attempt($data);

        if(!$bool){
          return  redirect(route('admin.login'))->withErrors(['errors'=>'用户登录失败']);
        }
        $userinfo = [];
//       Mail::raw('用户登录成功',function(Message $message){
//           $message->subject('用户登录通知');
//           $message->to('247121925@qq.com','小王');
//
//       });

        return redirect(route('admin.index'));
    }

}

