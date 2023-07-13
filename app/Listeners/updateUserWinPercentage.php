<?php

namespace App\Listeners;

use App\Models\Game;
use App\Models\User;
use App\Events\newGameStarted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
