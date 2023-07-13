<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\RankingResource;

class RankingController extends Controller
{
    public function showWinner() 
    {
        $winner = User::orderByDesc('win_percentage')->first();

        return response()->json([
            'winner' => RankingResource::make($winner),
        ], 200);

    }

    public function showLoser()
    {
        $loser = User::orderBy('win_percentage')->first();

        return response()->json([
            'loser' => RankingResource::make($loser),
        ], 200);
    }

    public function showRanking()
    {
        $avarage = User::avg('win_percentage');
        $ranking = User::orderByDesc('win_percentage');

        return response()->json([
            'avarage win percentage' => $avarage,
            'ranking' => RankingResource::collection($ranking),
        ], 200);
    }
}
