<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Node;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//dd($request);
        $data = Role::paginate($this->pagesize);
        return view('admin.role.index',compact('data'));
    }
    public function sel($str){
        dd($str);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $nodeDate  = Node::all()->toArray();
        $nodeDate = treeLevel($nodeDate);
        return view('admin.role.create',compact('nodeDate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       $data=  $this->validate($request,[
            'name'=>'required|unique:roles,name'
        ]);
        $model = Role::create($data);
        $model->nodes()->sync($request->get('node_ids'));
        return redirect(route('admin.role.index'))->with('success','添加角色成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        // 转为数组
        $nodeData = Node::all()->toArray();
        $nodeData = treeLevel($nodeData);


        $role_node = $role->nodes()->pluck('id')->toArray();
        return view('admin.role.edit',compact('role','nodeData','role_node'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
       $data= $this->validate($request,[
            'name'=>'required|unique:roles,name,'.$role->id
        ]);
        $role->update($data);
        $role->nodes()->sync($request->get('node_ids'));
        return redirect(route('admin.role.index'))->with('success','修改角色成功');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Role::destroy($id);
        return ['status'=>0,'msg'=>'删除成功'];
    }
}
