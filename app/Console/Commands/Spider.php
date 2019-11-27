<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use QL\QueryList;

class Spider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //php artisan 执行的命令名称
    protected $signature = 'wu:spider';

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
        //多线程
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
                    'title'=>['.text .tit','text'],
                    'pic'=>['.item .img img','data-original'],
                    'desc'=>['.text p.summary','text'],
                    'cnt_url'=>['.text .tit','href'],
                ];
                $ql = QueryList::Query($ret['content'],$reg);
                $data=$ql->getData();
//                dump($data);
                foreach($data as $item){
                    $item['cid']=2;
                    $item['body']='';
//                    $item['is_url']=0;
                    Article::create($item);
                }
                echo "ok\n";
            }
        ]);
    }
}
