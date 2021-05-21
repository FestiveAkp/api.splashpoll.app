<?php

use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\PollController;
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

Route::prefix('v1')->group(function () {
    Route::apiResource('polls', PollController::class)->except(['update', 'destroy']);
    Route::patch('/polls/{poll}/vote', [PollController::class, 'vote']);
    Route::patch('/polls/{poll}/combine', [PollController::class, 'combine']);
    Route::apiResource('choices', ChoiceController::class)->only('destroy');
});
