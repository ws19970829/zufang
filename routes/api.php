<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('login', function () {
//    // 获取请求的头信息数据
//    $username = request()->header('username');
//    $password = request()->header('password');
//    $stime = request()->header('stime');
//    $signate = request()->header('sign');
//    $userData = ['username' => $username, 'password' => $password];
//    // auth登录
//    $bool = auth()->guard('api')->attempt($userData);
//
//    // 异常情况统一到一个地方  异常的地方
//    if (!$bool) { // 登录不成功
//        // 处理
//        //return ['stauts' => 1, 'msg' => '登录失败'];
//        throw new \App\Exceptions\LoginException('登录失败', 1);
//    }
//    // 登录成功，进行签名比较
//    $token = auth()->guard('api')->user()->token;
////    dd($token);
//    // 签名计算  username+token+时间+password md5
//    $sign = $username . $token . $stime . $password;
//    $sign = md5($sign);
////    dd($sign);
//    if ($sign !== $signate) {
//        // 处理
////        return ['stauts' => 2, 'msg' => '登录异常'];
//        throw new \App\Exceptions\LoginException('登录异常', 2);
//    }
//
//    return ['stauts' => 0, 'msg' => '登陆成功'];
//});

 //小程序路由
Route::group(['prefix'=>'v1','namespace'=>'Api','middleware'=>['checkapi']],function(){
    //微信小程序的登录
    Route::post('wxlogin','WxloginController@login');
    //小程序的授权
    Route::post('userinfo','WxloginController@userinfo');
    //图片上传
    Route::post('upfile','RentingController@upfile');
    //删除图片请求
    Route::get('delimg','RentingController@delimg');


    //租客信息接收处理
    Route::put('editrenting','RentingController@editrenting');
     //以openid来返回用户信息
    Route::get('renting','RentingController@show');
    //看房通知
    Route::get('notices','NoticeController@index');
    //测试采集路由
    Route::get('sipder','NoticeController@sipder');


    //记录用户浏览文章记录
    Route::post('article/history','ArticleController@history');
    //文章资讯详情
    Route::get('articles/{article}','ArticleController@show');
    //文章列表
    Route::get('articles','ArticleController@index');
    //推荐房源的轮播图片
    Route::get('fang/recommend','FangController@recommend');
    //租房小组
    Route::get('fang/group','FangController@group');
    //房源列表
    Route::get('fang/list','FangController@list');
    //房源详情
    Route::get('fang/detail','FangController@detail');
    //收藏
    Route::get('fang/fav','FavController@fav');
    //检查是否收藏
    Route::get('fang/isfav','FavController@isfav');
    //收藏页面
    Route::get('fav/list','FavController@list');
    //房源属性
    Route::get('fang/fangattr','FangController@fangattr');
    //es模糊查询
    Route::get('fang/search','FangController@search');



});
