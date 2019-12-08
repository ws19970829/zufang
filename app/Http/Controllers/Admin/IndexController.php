<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Node;


class IndexController extends BaseController
{
    //
    public function index(){
        $usermodel = auth()->user();
        $rolemodel = $usermodel->role;
        if($usermodel->username!=='admin'){
            $nodedata = $rolemodel->nodes()->where('is_menu','1')->get(['id','name','pid','route_name'])->toArray();
        }else{
            $nodedata=Node::where('is_menu','1')->get(['id','name','pid','route_name'])->toArray();

        }
        $nodedata = subTree($nodedata);
//        dd($nodedata);

        return view('admin.index.index',compact('nodedata'));
//        return view('admin.index.index');

    }
    public function welcome(){
        //已租
        $count1 = Fang::where('fang_status',1)->count();
        //未租
        $count2 =Fang::where('Fang_status',0)->count();
        //拼接图形所需数据
        $legend="'已租','未租'";
        $data=[
            ['value'=>$count1,'name'=>'已租'],
            ['value'=>$count2,'name'=>'待租'],
        ];
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);
//       dd($data);
        return view('admin.index.welcome',compact('legend','data'));
    }
    public function logout(){
        auth()->logout();
        return redirect(route('admin.login'))->with(['success'=>'退出成功']);
    }
}
