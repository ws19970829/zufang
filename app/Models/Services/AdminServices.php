<?php

namespace App\Models\Services;
use Illuminate\Http\Request;
use App\Models\Admin;


class AdminServices
{
    //
    public function getList(Request $request,int $pagesize=10){
        $id =auth()->id();
        $st = $request->get('st');
        $et = $request->get('et');
        $ss = $request->get('ss');
        return Admin::when($st,function($query)use($st,$et){
            $st = date('Y-m-d 00;00;00',strtotime($st));
            $et = date('Y-m-d  23:59:59',strtotime($et));
            $query->whereBetween('created_at',[$st,$et]);
        })->when($ss,function($query)use($ss){
            $query->where('username','like',"%{$ss}%");
        })->where('id','!=',$id)->orderBy('id','desc')->withTrashed()->paginate($pagesize);
    }
}
