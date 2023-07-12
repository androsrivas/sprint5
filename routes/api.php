<?php

use Illuminate\Support\Facades\Route;
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

    //user
    Route::post('/register', [PassportAuthController::class, 'register']);
    Route::post('/login', [PassportAuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        //admin
        Route::get('/players', [UserController::class, 'index']);

        //players

    });
});

/*Route::prefix('v1')->middleware('auth:api')->group(function () {
    //admin
    Route::get('/players', [UserController::class, 'index']);
    Route::get('/players/ranking', []);
    // Route::get('/players/ranking/loser', [UserController::class, 'findWinner']);
    // Route::get('/players/ranking/winner', [UserController::class, 'findLoser']);

    //users
    Route::get('/players/{id}/games', [UserController::class, 'show']);
    Route::post('/players', [UserController::class, 'store']);
    Route::put('/players/{id}', [UserController::class, 'update']);
    Route::post('/players/{id}/games', [GameController::class, 'throwDice']);
    Route::delete('/players/{id}/games', [GameController::class, 'destroy']);
});*/
