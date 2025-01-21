<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TrailerController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/trailers', [TrailerController::class, 'index']);
Route::get('/trailers/{id}', [TrailerController::class, 'show']);
Route::post('/trailers', [TrailerController::class, 'store']);
Route::put('/trailers/{id}', [TrailerController::class, 'update']);
Route::delete('/trailers/{id}', [TrailerController::class, 'destroy']);

Route::post('/login', [AuthController::class, 'post']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/switch-account/{accountId}', [AuthController::class, 'switchAccount']);
Route::post('/update-profile-photo', [AuthController::class, 'updateProfilePhoto']);
Route::delete('/delete-profile-photo', [AuthController::class, 'deleteProfilePhoto']);
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'getLoggedInUser']);
Route::get('/users', [AuthController::class, 'getAllUsers']);
