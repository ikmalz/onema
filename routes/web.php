<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController; // Add this line to import the RegisterController
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
Route::get('detail/{id}', [HomeController::class, 'show'])->name('home.detail');
Route::get('/home', [HomeController::class, 'index'])->name('home');
    

Route::post('/profile/upload', [HomeController::class,'profile'])->name('profile.upload');




