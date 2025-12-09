<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Carbon\Carbon;

class LogSuccessfulLogin
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $event->user->last_sign_in_at = $event->user->current_sign_in_at ? $event->user->current_sign_in_at : Carbon::now();
        $event->user->current_sign_in_at = Carbon::now();
        $event->user->save();
    }
}
