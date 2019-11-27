<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apiuser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiuserRequest;

class ApiuserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Apiuser::paginate($this->pagesize);
//       dd($data);
       return view('admin.apiuser.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.apiuser.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApiuserRequest $request)
    {
        Apiuser::create($request->except('_token'));
        return ['status' => 0,'msg'=>'成功','url'=>route('admin.apiuser.index')];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apiuser  $apiuser
     * @return \Illuminate\Http\Response
     */
    public function show(Apiuser $apiuser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apiuser  $apiuser
     * @return \Illuminate\Http\Response
     */
    public function edit(Apiuser $apiuser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apiuser  $apiuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apiuser $apiuser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apiuser  $apiuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apiuser $apiuser)
    {
        //
    }
}
