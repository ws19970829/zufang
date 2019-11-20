<?php

namespace App\Models;

use App\Observers\FangAttrObserver;
use Illuminate\Database\Eloquent\Model;

class FangAttr extends Base
{
    //
    protected  $appends = ['actionBtn','checkbox'];
    protected  static function boot(){
        parent::boot();
        //注册观察者
        self::observe(FangAttrObserver::class);
    }
    //修改按钮和删除按钮
    public function getActionBtnAttribute(){
        return $this->editBtn('admin.fangattr.edit').'   '.$this->delBtn('admin.fangattr.destroy');
    }
    public function getCheckBoxAttribute(){
        return $this->checkbox();
    }
}
