<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fang;
use App\Models\FangAttr;
use App\Models\FangOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Http\Requests\FangRequest;
//网络请求类
use GuzzleHttp\Client;

class FangController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Fang::with('fangowner')->paginate($this->pagesize);
//        dd($data);
        return view('admin.fang.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //地区三级联动数据
        $pdata = $this->getCity();
        //房源属性数据
        $arrdata = FangAttr::all()->toArray();
        $arrdata = subTree2($arrdata);
//        dd($attrdata);
        //房东数据
        $fdata = FangOwner::all();
        return view('admin.fang.create',compact(['pdata','arrdata','fdata']));

    }
    public function getCity($pid=0){
        $pid = $pid == 0 ? request()->get('pid',0):$pid;
        //地区三级驱动
        return City::where('pid',$pid)->get();
    }

    public function store(FangRequest $request)
    {
//        dd($request->all());
    Fang::create($request->except('file','_token'));
        return redirect(route('admin.fang.index'));
    }

    public function show(Fang $fang)
    {
        //
    }

    public function edit(Fang $fang)
    {
        // 省
        $pData = $this->getCity();
        // 市
        $cData = $this->getCity($fang->fang_province);
        // 区
        $rData = $this->getCity($fang->fang_city);

        // 房源属性
        $attrData = FangAttr::all()->toArray();
        // 以字段名为下标创建多层数组
        $attrData = subTree2($attrData);
        // 读取房东
        $fData = FangOwner::all();
        return view('admin.fang.edit', compact('fang', 'pData','cData','rData', 'attrData', 'fData'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fang $fang)
    {
        //
        $fang->update($request->except(['_token','_method','file','fang_addr2']));
        return redirect(route('admin.fang.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fang  $fang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fang $fang)
    {
        //
    }
}
