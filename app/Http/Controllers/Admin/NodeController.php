<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Node;

class NodeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $nodemodel = Node::all();
        $data = Node::all()->toArray();
        $data=treeLevel($data);

//        dd($data);
        return view('admin.node.index',compact(['data','nodemodel']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $data = Node::where('level','<',3)->pluck('name','id')->toArray();
        //$pid = Node::where('pid',0)->pluck('name','id')->toArray();
//        $data = get_cate_list($data);
//        return view('admin.node.create',compact(['data','pid']));
        //
          $data = Node::where('pid',0)->pluck('name','id')->toArray();
         $data[0] = '==顶级==';
        ksort($data);
        return view('admin.node.create',compact('data'));

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
        $this->validate($request,[
            'name'=>'required'
        ]);
        Node::create($request->except(['_token']));
        return redirect(route('admin.node.index'));
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
    public function edit(Node $node)
    {
        //

        $node = $node->toArray();

            $node = treeLevel($node);
        dd($node);

        return view('admin.node.edit',compact('node'));
    }
    public function sel(int $id){
        return 1;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
    }
}
