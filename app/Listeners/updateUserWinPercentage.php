<?php

namespace App\Listeners;

use App\Events\newGameStarted;
use App\Models\Game;
use App\Models\User;

class updateUserWinPercentage
{
    /**
     * Handle the event.
     */
    public function handle(newGameStarted $event): float
    {
        $user = User::findOrFail($event->game->user_id);
        $allGamesFromUser = Game::where('user_id', $user->id)->count();
        $wonGamesFromUser = Game::where(['user_id' => $user->id, 'result' => 7])->count();
        $user->win_percentage = ($wonGamesFromUser / $allGamesFromUser) * 100;
        $user->save();

        return $user->win_percentage;
    }
}
