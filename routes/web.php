<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController; // Add this line to import the RegisterController
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('/', [AuthController::class, 'auth'])->name('login');
Route::post('postLogin', [AuthController::class, 'post'])->name('postLogin');

// Register routes
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('postRegister', [AuthController::class, 'register'])->name('register.post');

Route::post('logout', [AuthController::class, 'logout'])->name('actionLogout');

//form
Route::post('formAction', [HomeController::class, 'create'])->name('form.action');

//detail
Route::get('/detail/{id}', [HomeController::class, 'show'])->name('home.detail');
Route::get('/home', [HomeController::class, 'index'])->name('home');
    
Route::post('/trailer/{id}/comment', [HomeController::class, 'storeComment'])->name('comment.store');
Route::post('comment/{id}/like', [HomeController::class, 'likeComment'])->name('comment.like');
Route::post('comment/{id}/dislike', [HomeController::class, 'dislikeComment'])->name('comment.dislike');
Route::post('/comment/{comment}/reply', [HomeController::class, 'storeReply'])->name('comment.reply');

Route::post('/video/{id}/like', [HomeController::class, 'likeVideo'])->name('video.like');
Route::post('/video/{id}/dislike', [HomeController::class, 'dislikeVideo'])->name('video.dislike');

Route::post('/video/{id}/rate', [HomeController::class, 'rateVideo'])->name('video.rate');
Route::post('/video/{id}/delete-rating', [HomeController::class, 'deleteRating'])->name('video.delete-rating');

Route::get('/watchlist', [HomeController::class, 'watchlist'])->name('watchlist');
Route::post('/watchlist/toggle/{id}', [HomeController::class, 'toggleWatchlist'])->name('watchlist.toggle');









