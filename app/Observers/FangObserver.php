<?php

namespace App\Observers;
use App\Models\Fang;
use GuzzleHttp\Client;

class FangObserver
{
    //封装经纬度
 public function geo(){
     //request()不需要依赖注入
     $url=sprintf(config('geo.url'),request()->get('fang_addr'));
     //引入guzzle发起get请求
     $client = new Client(['timeout'=>5,'verify'=>false]);
     $response =$client->get($url);
     //获取请求的主体
     $json = (string)$response->getBody();
     $arr = json_decode($json,true)['geocodes'];

     $longitude = $latitude = 0;
     if(count($arr)>0){
         $location = $arr[0]['location'];
         // 解析赋值
         [$longitude,$latitude] = explode(',',$location);
     }
     return  [$longitude,$latitude];
     //地址转化为单独的经纬度;

 }
    public function creating(Fang $fang){
        $geo = $this->geo();
        $fang->longitude = $geo[0];
        $fang->latitude=$geo[1];

        //处理数据表的配套设施设置为，拼接的字符串
        $fang->fang_config=implode(',',request()->get('fang_config'));
    }

    public function created(Fang $fang){
        $hosts = config('es.hosts');
        $client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        // 写文档
        $params = [
            // 索引名称
            'index' => 'fangs',
            // 可以不定义，它会自动给生成
            'id' => $fang->id,
            // 文档字段内容
            'body' => [
                'xiaoqu' => $fang->fang_xiaoqu,
                'desn' => $fang->fang_desn,
            ],
        ];
        $client->index($params);
    }
    public function updating(Fang $fang){
        if(request()->get('fang_addr2')!=request()->get('fang_addr')){
            $geo=$this->geo();
            $fang->longitude = $geo[0];
            $fang->latitude=$geo[1];
        }
        $fang->fang_config=implode(',',request()->get('fang_config'));
    }
    public function updated(Fang $fang){
        $this->created($fang);
    }
}
