<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Models\Notice;
use App\Models\Renting;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use QL\QueryList;

class NoticeController extends Controller
{

    public function index(Request $request){
        try{
            $data = $this->validate($request,[
                'openid'=>'required'
            ]);
        }catch(\Exception $exception) {
            throw new MyValidateException('验证异常', 3);
        }
            //根据openid来获取租客的id，然后获取相应的房东信息
            $rid = Renting::where($data)->value('id');
//        return $rid;
            //根据租客id查询房东信息
            $data= Notice::with('fangOwner:id,name,phone')->where('renting_id',$rid)->orderBy('id','asc')->paginate(env('PAGESIZE'));

            return  ['status'=>0,'msg'=>'成功','data'=> $data];


    }
    public function sipder(){
//           $data = QueryList::Query('https://news.ke.com/bj/baike/00779/',[
//               "src"=>['.m-col .item .img img','data-original','',function($item){
////               return  $item;
////                   return basename($item);
//                   //图片名称
//                   $filename = basename($item);
//                   //保存到本地的路径和文件名称
//                   $filepath=public_path('img/'.$filename);
//                   //请求图片资源
//                   $client= new Client(['timeout'=>5,'verify'=>false]);
//                   //得到主体
//                   $reponse = $client->get($item);
//                   //写入本地
//                   file_put_contents($filepath,$reponse->getBody());
//                   return '/img/'.$filename;
//               }]
//           ])->getData();
//           dump($data);

        //多线程扩展
        QueryList::run('Multi', [
            // 待采集链接集合  数组
            'list' => [
                'https://news.ke.com/bj/baike/033/pg1/',
                'https://news.ke.com/bj/baike/033/pg2/',
                'https://news.ke.com/bj/baike/033/pg3/',

            ],
            // 线程curl的相关设置
            'curl' => [
                'opt' => array(
                    //这里根据自身需求设置curl参数
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_AUTOREFERER => true
                ),
                //设置线程数
                'maxThread' => 100,
                //设置最大尝试数
                'maxTry' => 10
            ],
            // 采集到数据回调处理
            'success' => function ($ret) {
                // 采集规则
               $reg = [
                   'title'=>['.text .tit','text']
               ];
               $ql = QueryList::Query($ret['content'],$reg);
               $data=$ql->getData();
               dump($data);
            }
        ]);


    }


}
