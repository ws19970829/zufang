<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EsController extends Controller
{

//    public function initindex()
//    {
//        $hosts = config('es.hosts');
//        // 实例化
//        $client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
//        // 创建索引
//        $params = [
//            // 索引名
//            'index' => 'fangs',
//            'body' => [
//                // 指定副本和分片
//                'settings' => [
//                    // 分片 后续不可修改
//                    'number_of_shards' => 5,
//                    // 副本后续可修改
//                    'number_of_replicas' => 1
//                ],
//                'mappings' => [
//                    // 相当于类型 es7取消
//                    '_doc' => [
//                        '_source' => [
//                            'enabled' => true
//                        ],
//                        // 字段
//                        'properties' => [
//                            'xiaoqu' => [
//                                // 精确查询
//                                'type' => 'keyword'
//                            ],
//                            'desn' => [
//                                // 模糊搜索
//                                'type' => 'text',
//                                // 插件 中文分词插件  需要安装
//                                'analyzer' => 'ik_max_word',
//                                'search_analyzer' => 'ik_max_word'
//                            ]
//                        ]
//                    ]
//                ]
//            ]
//        ];
//        $response = $client->indices()->create($params);
//
//        dump($response);
//    }


    //es7
    public function initindex1() {
        $hosts = config('es.hosts');
        // 实例化
        $client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        // 创建索引
        $params = [
            // 索引名
            'index' => 'fangs',
            'body' => [
                // 指定副本和分片
                'settings' => [
                    // 分片 后续不可修改
                    'number_of_shards' => 5,
                    // 副本后续可修改
                    'number_of_replicas' => 1
                ],
                'mappings' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    // 字段
                    'properties' => [
                        'xiaoqu' => [
                            // 精确查询
                            'type' => 'keyword'
                        ],
                        'desn' => [
                            // 模糊搜索
                            'type' => 'text',
                            // 插件 中文分词插件  需要安装
//                            'analyzer' => 'ik_max_word',
//                            'search_analyzer' => 'ik_max_word'
                        ]
                    ]
                ]
            ]
        ];
        $response = $client->indices()->create($params);
        dump($response);

        // 写文档
        // 添加 也可以 更新
//        $params = [
//            // 索引名称
//            'index' => 'fangs',
//            // 可以不定义，它会自动给生成
//            'id' => 1,
//            // 文档字段内容
//            'body' => [
//                'xiaoqu' => '你好世界11111',
//                'desn' => '还行这个可以有',
//            ],
//        ];
//        $client->update($params);

        // 更新文档
//        $params = [
//            // 索引名称
//            'index' => 'fangs',
//            // 可以不定义，它会自动给生成
//            'id' => 1,
//            // 文档字段内容
//            'body' => [
//                'doc'=>[
//                    'xiaoqu' => '你好世界222',
//                    'desn' => '还行这个可以有'
//                ]
//            ],
//        ];
//        $ret = $client->update($params);
//        dump($ret);
//
//        $params = [
//            'index' => 'fangs',
//            'body' => [
//                'query' => [
//                    'match' => [
//                        'desn' => [
//                            'query' => '这个可以有'
//                        ]
//                    ]
//                ]
//            ]
//        ];
//        $results = $client->search($params);
//
//        if (count($results['hits']['hits']) > 0) {
//            $ids = array_column($results['hits']['hits'],'_id');
//            return $ids;
//        }


    }
}

