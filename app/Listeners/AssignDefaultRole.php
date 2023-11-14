<?php

namespace App\Listeners;

use App\Events\newUserRegistered;

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
