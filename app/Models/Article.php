<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Base
{
    //
    protected $appends= ['actionBtn','checkBox'];

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

}
