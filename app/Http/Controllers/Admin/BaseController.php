<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    //
    protected $pagesize = 1;

    public function __construct()
    {
        $this->pagesize =env('PAGESIZE');
    }
    public function upfile(Request $request){
//        return ['status'=>0,'url'=>''];
        $node = $request->get('node');
        $file = $request->file('file');
        // ' ' ,直接存在uploads/articles下；
        // 'article'config->file配置下的节点名称

        $url = $file->store('',$node);
        return ['status'=>0,'url'=>'/uploads/'. $node .'/'.$url];
    }

}
