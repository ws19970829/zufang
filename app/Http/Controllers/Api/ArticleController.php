<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
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
}
