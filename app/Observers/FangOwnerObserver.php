<?php

namespace App\Observers;

use App\Jobs\FangOwnerJob;
use App\Models\FangOwner;
use Mail;
use Illuminate\Mail\Message;

class FangOwnerObserver
{
    /**
     * Handle the fang owner "created" event.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return void
     */
    public function created(FangOwner $fangOwner)
    {
        //
        $email = $fangOwner->email;
        $name = $fangOwner->name;
        $data = ['name'=>$name,'email'=>$email];
        //投递任务
        dispatch(new FangOwnerJob($data));
    }

    /**
     * Handle the fang owner "updated" event.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return void
     */
    public function updated(FangOwner $fangOwner)
    {
        //
    }

    /**
     * Handle the fang owner "deleted" event.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return void
     */
    public function deleted(FangOwner $fangOwner)
    {
        //
    }

    /**
     * Handle the fang owner "restored" event.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return void
     */
    public function restored(FangOwner $fangOwner)
    {
        //
    }

    /**
     * Handle the fang owner "force deleted" event.
     *
     * @param  \App\Models\FangOwner  $fangOwner
     * @return void
     */
    public function forceDeleted(FangOwner $fangOwner)
    {
        //
    }
}
