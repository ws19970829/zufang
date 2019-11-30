<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\LoginException;
use App\Models\Renting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\Exceptions\MyValidateException;


class WxloginController extends Controller
{
    //
//    public function login(Request $request){
//       $code = $request->get('code');
//       $appid = config('wx.appid');
//       $secret=config('wx.secret');
//       $url=sprintf(config('wx.wxloginUrl'),$appid,$secret,$code);
//       //发起网络请求获取openid
//        $client = new Client(['timeout'=>5,'verify'=>false]);
//        $response=$client->get($url);
//        //得到响应值
//        $json = (string)$response->getBody();
//        //转为数组
//        $arr=json_decode($json,true);
//        $openid=$arr['openid']??'none';
//        //存入租客的数据表
//        if($openid!=='none'){
//            //判断openid是否存在
//            $info = Renting::where('openid',$openid)->value('openid');
//            if(!$info){
//                //数据不存在，添加为null
//                Renting::create(['openid'=>$openid]);
//            }
//        }
//        return ['openid'=>$openid];
//
//    }
    public function login(Request $request) {
        $code = $request->get('code');
        $appid = config('wx.appid');
        $secret = config('wx.secret');
        $url = sprintf(config('wx.wxloginUrl'), $appid, $secret, $code);

        // 发起一个GET请求 verify不检查ssl证书
        $client = new Client(['timeout' => 5, 'verify' => false]);
        $response = $client->get($url);
        // 得到请求响应值
        $json = (string)$response->getBody();
        // 转为数组
        $arr = json_decode($json, true);
        $openid = $arr['openid'] ?? 'none';

        if ($openid != 'none') {
            // 根据OPENID来时行数据是否存在的判断
            $info = Renting::where('openid', $openid)->value('openid');
            if (!$info) {
                // 数据不存在，则添加
                Renting::create(['openid' => $openid]);
            }
        }
        return ['openid' => $openid];
    }
    //授权
    public function userinfo(Request $request){
        try {
            $data = $this->validate($request,[
                'openid'=>'required',
                'nickname'=>'required',
                'sex'=>'required',
                'avatar'=>'required',
            ]);
        }catch(\Exception $exception){
          throw new MyValidateException('验证不通过',3);
        }

        $model = Renting::where('openid',$data['openid'])->first();
        if(!$model){
            Renting::create($data);
        }else{
            $model->update($data);
        }
        return ['status'=>0,'msg'=>'成功'];

    }
}
