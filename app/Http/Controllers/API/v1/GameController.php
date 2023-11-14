<?php

namespace App\Http\Controllers\API\v1;

use App\Events\NewGameStarted;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Models\User;

class GameController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function newGame(int $id)
    {
        $user = User::findOrFail($id);

        if (auth()->user()->id !== $user->id) {

            return response()->json(['message' => 'Unauthorised.'], 401);

        } else {

            $game = new Game;
            $gameResult = $game->gameLogic();
            $game->user_id = $user->id;
            $game->fill($gameResult);
            $game->save();

            event(new newGameStarted($game));

            return GameResource::make($game);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        if (auth()->user()->id != $id) {

            return response()->json(['message' => 'Forbidden.'], 403);

        }

        $user = User::findOrFail($id);
        $userGames = Game::where('user_id', $user->id)->get();

        return response()->json([
            'user' => $user->nickname,
            'win percentage' => $user->win_percentage,
            'games' => GameResource::collection($userGames),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if (auth()->user()->id !== $id) {

            return response()->json(['message' => 'Forbidden.'], 403);

        } else {

            $user = User::findOrFail($id);
            Game::where('user_id', $user->id)->delete();

            return response()->json(['message' => 'Games deleted successfully.'], 200);
        }
    }
}
