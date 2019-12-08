<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\MyValidateException;
use App\Http\Resources\FavResourceCollection;
use App\Models\Fav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavController extends Controller
{
    //
    public function fav(Request $request){
        try{
            $data = $this->validate($request,[
                'openid'=>'required',
                'fang_id'=>'required|numeric',
                'fav'=>'required|numeric'
            ]);
        }catch(\Exception $exception){
            throw new MyValidateException('验证异常',3);
        }
         $fav = $data['fav'];
        unset($data['fav']);
        $model = Fav::where($data)->first();
        if($fav>0){
            if(!$model){
                Fav::create($data);
            }
            $msg = '添加收藏成功';
        }else{
            $model->forceDelete();
            $msg='取消收藏成功';
        }
        return ['status'=>0,'msg'=>$msg];
    }
    public function isfav(Request $request){
        try{
            $data = $this->validate($request,[
                'openid'=>'required',
                'fang_id'=>'required|numeric',
            ]);
        }catch(\Exception $exception){
            throw new MyValidateException('验证异常',3);
        }
        $model = Fav::where($data)->first();
        if($model){
            return ['status'=>0,'msg'=>'取消收藏','data'=>1];
        }else{
            return ['status'=>0,'msg'=>'添加收藏','data'=>0];
        }


    }
    //收藏记录
    public function list(Request $request)
    {
        try {
            $data = $this->validate($request, [
                'openid' => 'required'
            ]);
        } catch (\Exception $exception) {
            throw new MyValidateException('验证异常', 3);
        }
        $data = Fav::where($data)->orderBy('updated_at', 'asc')->paginate(env('PAGESIZE'));
//        dd($data);
        return ['status' => 0, 'data' => new FavResourceCollection($data), 'msg' => '成功'];
    }
}
