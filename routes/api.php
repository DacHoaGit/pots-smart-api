<?php

use Illuminate\Http\Request;
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
Route::get('test', [\App\Http\Controllers\TestController::class, 'test']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('suggestion', [\App\Http\Controllers\SuggestionController::class, 'store']);
    Route::delete('suggestion/{id}', [\App\Http\Controllers\SuggestionController::class, 'destroy']);
    Route::get('suggestions', [\App\Http\Controllers\SuggestionController::class, 'getSuggestions']);
    Route::get('list-suggestions', [\App\Http\Controllers\SuggestionController::class, 'getAllSuggestions']);

    Route::post('timer', [\App\Http\Controllers\TimerController::class, 'store']);
    Route::get('timers', [\App\Http\Controllers\TimerController::class, 'getTimers']);
    Route::put('timer/{id}', [\App\Http\Controllers\TimerController::class, 'changeStatus']);
    Route::delete('timer/{id}', [\App\Http\Controllers\TimerController::class, 'destroy']);

    Route::post('device', [\App\Http\Controllers\DeviceController::class, 'store']);
    Route::get('devices', [\App\Http\Controllers\DeviceController::class, 'getDevicesByUser']);
    Route::delete('device/{id}', [\App\Http\Controllers\DeviceController::class, 'destroy']);
    Route::post('device/{id}', [\App\Http\Controllers\DeviceController::class, 'edit']);

    Route::post('share', [\App\Http\Controllers\ShareController::class, 'store']);
    Route::get('shares', [\App\Http\Controllers\ShareController::class, 'getSharesByUser']);
    Route::delete('share/{id}', [\App\Http\Controllers\ShareController::class, 'destroy']);
    Route::get('shared-list', [\App\Http\Controllers\ShareController::class, 'getSharedList']);
    Route::put('share/{id}', [\App\Http\Controllers\ShareController::class, 'changeStatus']);
    Route::get('shared-comfirm-list', [\App\Http\Controllers\ShareController::class, 'getSharedComfirmList']);

    Route::post('video', [\App\Http\Controllers\VideoController::class, 'store']);
    Route::get('videos', [\App\Http\Controllers\VideoController::class, 'getVideos']);
    Route::delete('video/{id}', [\App\Http\Controllers\VideoController::class, 'destroy']);
    Route::post('video/{id}', [\App\Http\Controllers\VideoController::class, 'edit']);

});

Route::post('register', [\App\Http\Controllers\Auth\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::get('logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);



