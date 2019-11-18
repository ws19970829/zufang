<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
//软删除
use Illuminate\Database\Eloquent\SoftDeletes;
//trait
use App\Models\Traits\Btn;

/**
 * App\Models\Admin
 *
 * @property int $id
 * @property string $username 账号
 * @property string $truename 真实姓名
 * @property string $password 密码
 * @property string|null $email 邮箱
 * @property string $phone 手机号码
 * @property string $sex 性别
 * @property string $last_ip 登录ip
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereLastIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereTruename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Admin whereUsername($value)
 * @mixin \Eloquent
 */
class Admin extends Authenticatable
{
    //继承trait
    use SoftDeletes,Btn;
    //指定软删除字段
    protected  $dates = ['deleted_at'];
    //create黑名单

    protected  $guarded=[];
    public function setPasswordAttribute($value){

    $this->attributes['password']=bcrypt($value);
}
       public function role(){
           return $this->belongsTo(Role::class,'role_id');
       }

}
