<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Http\Resources\FangDetailResource;
use App\Http\Resources\FangResourceCollection;
use App\Http\Resources\FangGroupResourceCollection;
use App\Models\Fang;
use App\Models\FangAttr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FangController extends Controller
{
    //
    //获取房源得轮播图片
    public function recommend(Request $request){
        $data = Fang::where('is_recommend',1)->orderBy('updated_at','desc')->limit(4)->get(['id','fang_pic']);
        return ['status'=>0,'msg'=>'成功','data'=>$data];
    }

    //租房小组
    public function group(){
        $where =['field_name'=>'fang_group'];
         $pid = FangAttr::where($where)->value('id');

         $data = FangAttr::where('pid',$pid)->orderBy('id','desc')->limit(4)->get();
         return ['status'=>0,'msg'=>'成功','data'=> new FangGroupResourceCollection($data)];
    }

    //房源列表
    public function list(Request $request){
//        dump($request->get('kw'));
        if (!empty($request->get('kw'))) { //调用一下es搜索
            return $this->search($request);
        }
        $data = Fang::orderBy('id','asc')->paginate(env('PAGESIZE'));
        return ['status'=>0,'msg'=>'成功','data'=>new FangResourceCollection($data)];
    }

    //房源详情
    public function detail(Request $request){
        $data = Fang::where('id',$request->get('id'))->first();
//        $data['config']=explode(',',$data['config']);
//        $data['config']=FangAttr::whereIn('id',$data['config'])->pluck('name');
        return ['status'=>0,'msg'=>'成功','data'=>new FangDetailResource($data)];
    }

    //房源属性列表
    public function fangattr(Request $request){
        //房源属性
        $attrData = FangAttr::all()->toArray();
        //以字段名为下标创建多层数组
        $attrData=subTree2($attrData);
        return ['status'=>0,'msg'=>'ok','data'=>$attrData];
    }
    //搜索
    public function search(Request $request){
        //关键词的获取
       $kw = $request->get('kw');
       if(empty($kw)){
           $data=Fang::orderBy('id','asc')->paginate(env('PAGESIZE'));
       }
       //KW有数据
        $client = \Elasticsearch\ClientBuilder::create()->setHosts(config('es.hosts'))->build();
        $params = [
            # 索引名称
            'index' => 'fangs',
            # 查询条件
            'body' => [
                'query' => [
                    'match' => [

                        'desn' => [
                            'query' => $kw
                        ],
                    ]
                ]
            ]
        ];
        $ret = $client->search($params);
//        dump($ret);
        $total =$ret['hits']['total']['value'];
        if($total==0){
            return ['status'=>6,'msg'=>'没有查询到数据','data'=>[]];
        }
        //取出数组中下标为_id的值。
        // 在二维数组中获取指字下标的值，并返回一维数组
        $data = array_column($ret['hits']['hits'], '_id');
        $data = Fang::whereIn('id', $data)->orderBy('id', 'asc')->paginate(10);
        return ['status' => 0, 'msg' => 'ok', 'data' => new FangResourceCollection($data)];

    }

}
