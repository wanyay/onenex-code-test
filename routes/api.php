<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\MovieController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthController::class, 'login']);

Route::post('comment/{movie}', [CommentController::class, 'store']);

Route::get('movie',[MovieController::class, 'index']);
Route::get('movie/{id}', [MovieController::class, 'show']);

Route::middleware('auth:api')->group(function () {

    Route::post('movie', [MovieController::class, 'store']);
    Route::put('movie/{id}', [MovieController::class, 'update']);
    Route::delete('movie/{id}', [MovieController::class, 'destroy']);
});
