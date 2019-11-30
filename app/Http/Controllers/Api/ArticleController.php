<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Models\Article;
use App\Models\ArticleCount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //
    public function index(Request $request){
        $field=[
            'id',
            'title',
            'desc',
            'pic',
            'created_at',
        ];
        $data= Article::orderBy('id','asc')->select($field)->paginate(env('PAGESIZE'));
        return ['status'=>0,'msg'=>'成功','data'=>$data];
    }

    //根据id获取数据，详情
    public function show(Article $article){
        return ['status'=>0,'data'=>$article,'msg'=>'ok'];
    }

    //记录用户的浏览次数
    public function history(Request $request){
       try{
           $data=$this->validate($request,[
               'openid'=>'required',
               'art_id'=>'required|numeric'
           ]);
       }catch(\Exception $exception){
           throw  new MyValidateException('验证异常',3);
       }
       //openid,art_id,当前日期一天
       $data['vdt']=date('Y-m-d');
       $model = ArticleCount::where($data)->first();
       if(!$model){
           $data['click']=1;
           $model= ArticleCount::create($data);
       }else{
           $model->increment('click');
       }
       //返回数据post请求，返回的转态码为201
        return response()->json(['status'=>0,'msg'=>'成功','data'=>$model->click],201);

    }


}
