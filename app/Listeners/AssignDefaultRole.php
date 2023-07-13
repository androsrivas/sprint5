<?php

namespace App\Listeners;

use App\Events\newUserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignDefaultRole
{
    /**
     * Handle the event.
     */
    public function handle(newUserRegistered $event): void
    {
        $user = $event->user;

        $user->assignRole('player');
    }
}
