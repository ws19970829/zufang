<?php

namespace App\Http\Controllers\Admin;

use App\Models\FangOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FangOnwerRequest;
//excel导出的数据类
use App\Exports\FangownerExport;
//excel导出类工具
use Maatwebsite\Excel\Facades\Excel;


class FangOwnerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //下载按钮的显示
        $excelpath = public_path('/uploads/fangownerexcel/fangowner.xlsx');
        $isshow = file_exists($excelpath) ? true : false;

        $data = FangOwner::orderBy('id','desc')->paginate($this->pagesize);
        return view('admin.fangowner.index',compact(['data','isshow']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.fangowner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request 2
     * @return \Illuminate\Http\Response
     */
    public function store(FangOnwerRequest $request)
    {
        //
//        dd($request->all());
        FangOwner::create($request->except(['file','_token']));
        return redirect(route('admin.fangowner.index'));

    }
    //exec导出
    public function export(){
    //导出并下载
//        return Excel::download(new FangownerExport(),'fangowner.xlsx');
        //导出并保存在本地文件中
        $obj = Excel::store(new FangownerExport(),'fangowner.xlsx','fangownerexcel');
        dump($obj);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function show(FangOwner $fangowner)
    {
        //
        $pics = $fangowner->pic;
//        dd($pics);
        $piclist =explode('#',$pics);
        if(count($piclist)<=1){
            return ['status'=>1,'msg'=>'没有图片','data'=>[]];
        }
        array_shift($piclist);
        return ['status'=>0,'msg'=>'成功','data'=>$piclist];
        dd($piclist);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function edit(FangOwner $fangOwner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FangOwner $fangOwner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function destroy(FangOwner $fangOwner)
    {
        //
    }
}
