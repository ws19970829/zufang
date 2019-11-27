<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use QL\QueryList;

class Sipdercnt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wu:cnt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $data = \DB::table('articles')->where('is_url','0')->get(['id','cnt_url'])->toArray();
//        print_r($data);
        //多线成扩展
        QueryList::run('Multi', [
            // 待采集链接集合  数组
            'list' => array_column($data,'cnt_url'),
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
                    'body'=>['.article-detail','html']
                ];
                //根据获取的url地址获取相应的参数
//                print_r($ret);
                $cnt_url =$ret['info']['url'];
                $ql = QueryList::Query($ret['content'],$reg);
                $data=$ql->getData();
//                print_r($data);die;
                //查找到的内容
                $body = $data[0]['body']??'';
                \DB::table('articles')->where('cnt_url',$cnt_url)->update([
                    'body'=>$body,
                    'is_url'=>1
                ]);

                echo "ok\n";

            }

        ]);
    }
}
