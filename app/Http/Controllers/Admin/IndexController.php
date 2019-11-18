<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.index.welcome');
    }
    public function logout(){
        auth()->logout();
        return redirect(route('admin.login'))->with(['success'=>'退出成功']);
    }
}
