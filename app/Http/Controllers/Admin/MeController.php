<?php

namespace App\Http\Controllers\Admin;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MeController extends BaseController
{
    //

    public function index(){
        $data=auth()->user();
        return view('admin.me.index',compact('data'));
    }
    public function update(Request $request,int $id){
          $data=$this->validate($request,[
              'truename'=>'required',
              'email'=>'nullable|email',
              'password'=>'nullable|confirmed',
              'phone'=>'nullable|min:6',
              'sex'=>'in:先生,女士'
          ])   ;
          if(!$data['password']){
              unset($data['password']);
          }
          Admin::where('id',$id)->update($data);

          return redirect(route('admin.index'))->with('success','修改个人信息['.$data['truename'].']成功');

    }
}
