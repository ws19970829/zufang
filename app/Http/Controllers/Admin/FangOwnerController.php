<?php

namespace App\Http\Controllers\Admin;

use App\Models\FangOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\FangOnwerRequest;

class FangOwnerController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = FangOwner::orderBy('id','desc')->paginate($this->pagesize);
        return view('admin.fangowner.index',compact('data'));
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return \Illuminate\Http\Response
     */
    public function show(FangOwner $fangOwner)
    {
        //
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
