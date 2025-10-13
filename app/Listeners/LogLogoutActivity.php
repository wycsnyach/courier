<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\LogActivity;

class LogLogoutActivity
{
    public function handle(Logout $event)
    {
        // Update the logout time of the most recent log for the user
        LogActivity::where('user_id', $event->user->id)
            ->whereNull('logout_time')
            ->update(['logout_time' => now()]);
    }
}