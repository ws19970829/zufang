<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Services\AdminServices;
//角色模型
use App\Models\Role;

//邮件
use Mail;
use Illuminate\Mail\Message;
class AdminController extends BaseController
{
    //
    public function index(Request $request){
//        $data= Admin::orderBy('id','desc')->paginate($this->pagesize);
//        var_dump($data);
        $data = (new AdminServices())->getList($request,$this->pagesize);
        return view('admin.admin.index',compact('data'));
    }
    public function add(){
        $roles = Role::pluck('name','id');
//        dd($roles);
        return view('admin.admin.add',compact('roles'));
    }
    public function create(Request $request){

//          var_dump($request);
        $this->validate($request,[
            'username'=>'required|unique:admins,username',
           'truename'=>'required',
            'email'=>'nullable|email',
            'password'=>'required|confirmed',
            'role_id'=>'required'
        ],
            ['role_id.required'=>'角色必须选一个']);
    $data = $request->except(['_token','password_confirmation']);
    $model = Admin::create($data);
        Mail::raw('添加用户成功',function(Message $message){
            $message->subject('添加用户成功通知');
            $message->to('247121925@qq.com','小王');
        });
//        Mail::send('admin.mail.adduser',compact('model'),function(Message $message)use($model){
//            $message->subject('添加用户成功通知');
////        $message->to($model->email,$model->truename);
//            $message->to('1942714179@qq.com','狗子');
//      });
    return redirect(route('admin.user.index'))->with('success','添加用户['.$model->truename.']成功');
    }
    public function edit(int $id){
        $data= Admin::find($id);
//        dd($data);
        return view('admin.admin.edit',compact('data'));
    }
    public function update(Request $request,int $id){
        $data=$this->validate($request,[
            'username'=>'required|unique:admins,username,'.$id,
            'truename'=>'required',
            'email'=>'nullable|email',
            'password'=>'nullable|confirmed',
            'phone'=>'nullable|min:6',
            'sex'=>'in:先生,女士'
        ]);
        if(!$data['password']){
            unset($data['password']);
        }
        Admin::where('id',$id)->update($data);
        return redirect(route('admin.user.index'))->with('success','修改用户['.$data['truename'].']成功');
    }
    public function delete(int $id){
        Admin::destroy($id);
        return ['status'=>0,'msg'=>'删除成功'];
    }
    public function delall(Request $request){
        $ids= $request->get('ids');
        Admin::destroy($ids);
        return ['status'=>0,'msg'=>'批量删除成功'];
    }
    public function restore(Request $request){
        $id = $request->get('ids');
        // 查找到此用户
        Admin::where('id', $id)->onlyTrashed()->restore();
        return ['status' => 0, 'msg' => '成功'];
    }

}
