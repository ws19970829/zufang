<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\LoginException;
use App\Exceptions\MyValidateException;
use App\Models\Renting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function React\Promise\map;

class RentingController extends Controller
{
    //
    public  function upfile(Request $request){
        $file = $request->file('card_img');
        //store存储 card上级文件夹 renting  file配置文件
        $info = $file->store('card','renting');
        return ['status'=>0,'path'=>'/uploads/renting/'.$info];
    }
    public function editrenting(Request $request){
        try {
            $this->validate($request, [
                'openid' => 'required'
            ]);
        } catch (\Exception $exception) {
            throw new MyValidateException('验证异常', 3);
        }
        //获取所有的数据
        $data = $request->all();
        $model = Renting::where('openid',$data['openid'])->first();
        if(!$model) throw new LoginException('没有查询到此信息',4);

        $model->update($data);
        return ['status'=>0,'msg'=>'更新用户信息成功'];
    }
    public function show(Request $request){
        try {
           $data= $this->validate($request, [
                'openid' => 'required'
            ]);
        } catch (\Exception $exception) {
            throw new MyValidateException('验证异常', 3);
        }
        //获取openid获取用户所有的数据
        $model = Renting::where('openid',$data['openid'])->first();
        if(!$model) throw new LoginException('没有查询到此信息',4);

        return ['status'=>0,'msg'=>'成功','data'=>$model];
    }

    //删除图片请求
    public function delimg(Request $request){
        $data=Renting::where('openid',$request->get('openid'))->value('card_img');
        $id = $request->get('imgid');
//        dd($id);
       $newdata = array_map(function($item){
           return '/'.strstr($item,'u');
        },$data);

           $filepath = public_path($newdata[$id]);
           if(is_file($filepath)){
               unlink($filepath);
           }
           unset($newdata[$id]);
           $img =$newdata;

           $newdata=implode(',',$newdata);
           $newdata=str_replace(',','#',$newdata);
//          return 1;
           $model=Renting::where('openid',$request->get('openid'))->update(['card_img'=>$newdata]);
          if($model==1){
              return ['status'=>0,'msg'=>'删除成功','img'=>$img];
          }else{
              return ['status'=>3,'msg'=>'删除失败'];
          }





    }
}
