<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\GameController;
use App\Http\Controllers\API\v1\UserController;
use App\Http\Controllers\API\v1\PassportAuthController;

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
    Route::post('/register', [PassportAuthController::class, 'register']);
    Route::post('/login', [PassportAuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {

        //admin
        Route::get('/players', [UserController::class, 'index']);
        //Route::get('/players/ranking', []);

        //players
        Route::get('/players/{player}/games', [GameController::class, 'show']);
        Route::put('/players/{player}', [UserController::class, 'update']);
        Route::delete('/players/{player}/games', [GameController::class, 'destroy']);
        Route::post('/players/{player}/games', [GameController::class, 'newGame']);
    });
});

/*
    POST /players : crea un jugador/a.
    GET /players/ranking: retorna el rànquing mitjà de tots els jugadors/es del sistema. És a dir, el percentatge mitjà d’èxits.
    GET /players/ranking/loser: retorna el jugador/a amb pitjor percentatge d’èxit.
    GET /players/ranking/winner: retorna el jugador/a amb millor percentatge d’èxit.
*/ 

/*Route::prefix('v1')->middleware('auth:api')->group(function () {
    //admin
    Route::get('/players', [UserController::class, 'index']);
    // Route::get('/players/ranking/loser', [UserController::class, 'findWinner']);
    // Route::get('/players/ranking/winner', [UserController::class, 'findLoser']);

    //users
    Route::get('/players/{id}/games', [UserController::class, 'show']);
    Route::post('/players', [UserController::class, 'store']);
    Route::put('/players/{id}', [UserController::class, 'update']);
    Route::post('/players/{id}/games', [GameController::class, 'throwDice']);
    Route::delete('/players/{id}/games', [GameController::class, 'destroy']);
});*/
