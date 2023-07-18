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
        $average = User::avg('win_percentage');
        $ranking = User::orderByDesc('win_percentage')->get();

        return response()->json([
            'average_win_percentage' => $average,
            'ranking' => RankingResource::collection($ranking),
        ], 200);
    }
}
