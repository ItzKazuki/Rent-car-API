<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CarController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RentController;
use App\Http\Controllers\Api\UserController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
   Route::post('login', [AuthController::class, 'login']);
   Route::post('register', [AuthController::class, 'register']);
   Route::get('logout', [AuthController::class, 'logout']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'user'
], function () {
    Route::get('info', [UserController::class, 'show']);
    Route::patch('update', [UserController::class, 'update']);
    Route::delete('delete', [UserController::class, 'delete']);
});

Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'car'
], function () {
    Route::post('create', [CarController::class, 'create']);
    Route::get('show', [CarController::class, 'showAll']);
    Route::post('show', [CarController::class, 'show']);
    Route::patch('update', [CarController::class, 'update']);
    Route::delete('delete', [CarController::class, 'delete']);
});

Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'rent'
], function () {
    Route::post('create', [RentController::class, 'create']);
    Route::get('show', [RentController::class, 'showAll']);
    Route::post('show', [RentController::class, 'show']);
});
