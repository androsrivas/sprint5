<?php

use App\Http\Controllers\Api\v1\GameController;
use App\Http\Controllers\API\v1\PassportAuthController;
use App\Http\Controllers\API\v1\RankingController;
use App\Http\Controllers\API\v1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {

    //users
    Route::post('/players', [PassportAuthController::class, 'register'])->name('users.register');
    Route::post('/login', [PassportAuthController::class, 'login'])->name('users.login');

    Route::middleware('auth:api')->group(function () {

        Route::post('/logout', [PassportAuthController::class, 'logout'])->name('users.logout');

        //admin
        Route::middleware('role:admin')->group(function () {
            Route::get('/players', [UserController::class, 'index'])->name('admin.players');
            Route::delete('/players/{player}', [UserController::class, 'destroy'])->name('admin.player.delete');
            Route::get('/players/ranking', [RankingController::class, 'showRanking'])->name('admin.ranking');
            Route::get('/players/ranking/winner', [RankingController::class, 'showWinner'])->name('admin.ranking.winner');
            Route::get('/players/ranking/loser', [RankingController::class, 'showLoser'])->name('admin.ranking.loser');
        });

        //players
        Route::middleware('role:player')->group(function () {
            Route::get('/players/{player}/games', [GameController::class, 'show'])->name('players.games');
            Route::put('/players/{player}', [UserController::class, 'update'])->name('players.update');
            Route::post('/players/{player}/games', [GameController::class, 'newGame'])->name('players.newGame');
            Route::delete('/players/{player}/games', [GameController::class, 'destroy'])->name('players.games.delete');
        });
    });
});

/*
    GET /players/ranking: retorna el rànquing mitjà de tots els jugadors/es del sistema. És a dir, el percentatge mitjà d’èxits.
    GET /players/ranking/loser: retorna el jugador/a amb pitjor percentatge d’èxit.
    GET /players/ranking/winner: retorna el jugador/a amb millor percentatge d’èxit.
*/
