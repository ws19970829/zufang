<?php

namespace App\Http\Controllers\Api;

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
    public function list(){
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

}
