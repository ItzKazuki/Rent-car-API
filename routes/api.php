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
    Route::patch('update/{id}', [UserController::class, 'update']);
    Route::delete('delete/{id}', [UserController::class, 'delete']);
});

Route::group([
    'middleware' => ['api', 'auth:api'],
    'prefix' => 'car'
], function () {
    Route::post('create', [CarController::class, 'create']);
    Route::get('show/{car}', [CarController::class, 'show']);
    Route::patch('update/{car}', [CarController::class, 'update']);
    Route::delete('delete/{car}', [CarController::class, 'delete']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'rent'
], function () {
    Route::post('create', [RentController::class, 'create']);
    Route::get('show/{rent}', [RentController::class, 'show']);
});
