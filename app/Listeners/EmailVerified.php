<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Queue\InteractsWithQueue;

class EmailVerified
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Verified $event
     * @return void
     */
    public function handle(Verified $event)
    {
        //会话里闪存验证成功后的信息提示
        session()->flash('success', '邮箱验证成功');
    }
}
