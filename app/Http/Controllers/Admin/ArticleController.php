<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Articlecate;
use App\Http\Requests\ArticleAddRequest;

class ArticleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        判断是否是ajax请求
        if($request->ajax()){
            //总记录数
//            $count = Article::count();
            //分页起始位置
            $offset = $request->get('start',0);
            //每页记录数
            $limit = $request->get('length',$this->pagesize);

            //排序
            $order = $request->get('order')[0];
            //排序规则
            $orderType = $order['dir'];
            //可点击排序的表单组
            $column = $request->get('columns')[$order['column']];
            //可点击排序的表单值
            $field =$column['data'];

            //搜索
            $kw = $request->get('kw');
            $builer = Article::when('kw',function($query)use($kw){
                $query->where('title','like',"%{$kw}%");
            });
            //获得记录总数
            $count = $builer->count();
//            $data = Article::with('cate')->offset($offset)->limit($limit)->get();
            $data = $builer->with('cate')->orderBy($field,$orderType)->offset($offset)->limit($limit)->get();
            //返回指定格式的json数据，return 返回的就是json数据
            return [
                // 客户端调用服务器端次数标识
                'draw' => $request->get('draw'),
                // 获取数据记录总条数
                'recordsTotal' => $count,
                // 数据过滤后的总数量
                'recordsFiltered' => $count,
                // 数据
                'data' => $data
            ];
        }

        return view('admin.article.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data= Articlecate::all()->toArray();
        $data = treeLevel($data);

        return view('admin.article.create',compact('data'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleAddRequest $request)
    {
        //
//        $data = $request->all();
//        dd($data);
        $data = $request->except(['_token','file']);
        Article::create($data);
        return redirect(route('admin.article.index'))->with('success','添加文章成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article,Request $request)
    {
        //
        $url_query=$request->all();
        $cate = Articlecate::all()->toArray();
        $cateData=treeLevel($cate);
        return view('admin.article.edit',compact(['cateData','article','url_query']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
        $url = $request->get('url');
        $article->update($request->except(['_token','file','_method','url']));
        $url = route('admin.article.index').'?'.http_build_query($url);
        return redirect($url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function delimg(Request $request){

        $id = $request->get('id');
        $src = $request->get('src');
        $file = public_path($src);
        if(is_file($file)){
            unlink($file);
        }
        return ['status'=>0,'msg'=>'删除成功'];
    }
    public function destroy(Article $article)
    {
        //
        $article->delete();
        return ['status'=>0,'msg'=>'删除成功'];
    }
    public function delall(Request $request){
        $id = $request->get('ids');
//        Article::destroy($id);
        return ['status'=>0,'msg'=>'删除成功'];
    }
}
