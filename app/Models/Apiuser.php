<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Btn;
//软删除
use Illuminate\Database\Eloquent\SoftDeletes;

class Apiuser extends Authenticatable
{
    //继承trait
    use SoftDeletes,Btn;
    //指定软删除字段
    protected  $dates = ['deleted_at'];
    protected $guarded = [];
    //修改器
    public  function setPassWordAttribute($value)
    {
        $this->attributes['password']=bcrypt($value);
        //添加一个明文的密码，用于给查看/给用户
        $this->attributes['mpassword'] = $value;

    }
}
