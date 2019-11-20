<?php

namespace App\Models;
use App\Observers\FangOwnerObserver;


class FangOwner extends Base {

    protected  static function boot(){
        parent::boot();
        //注册观察者
        self::observe(FangOwnerObserver::class);
    }

}
