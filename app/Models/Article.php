<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Base
{
    //
    protected $appends= ['actionBtn','checkBox','dt'];

    public  function cate(){
        return $this->belongsTo(Articlecate::class,'cid');
    }
    //全选框

    public function getCheckBoxAttribute(){
        return $this->checkBox();
    }
    //修改删除按钮转化器
    public function getActionBtnAttribute(){
        return $this->editBtn('admin.article.edit').' '.$this->delBtn('admin.article.destroy');
}



//获取器，封面图片
       public function getPicAttribute(){
        if(strstr($this->attributes['pic'],'http')){
            return $this->attributes['pic'];
        }
        return self::$host .'/'.ltrim($this->attributes['pic'],'/');
}
//日期，没有时分秒
     public function getDtAttribute()
     {
         return date('Y-m-d',strtotime($this->attributes['created_at']));
     }

}
