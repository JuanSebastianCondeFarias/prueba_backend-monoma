<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonomaApiController;

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
Route::middleware('auth:api')->group( function () {
    Route::get('/lead/{id}', [MonomaApiController::class,'getCandidateById']);
    Route::post('/lead', [MonomaApiController::class,'createCandidate']);
    Route::get('/leads', [MonomaApiController::class, 'getAllCandidates']);
});
Route::post('/auth', [MonomaApiController::class,'auth'])->name('login');