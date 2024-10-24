<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController; // Add this line to import the RegisterController
use App\Models\Profile;
use Illuminate\Support\Facades\App;
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

// routes/web.php

Route::get('/', [HomeController::class, 'index'])->name('homepage'); // Tidak menggunakan middleware auth
Route::post('postLogin', [AuthController::class, 'post'])->name('postLogin');

Route::get('login', [AuthController::class, 'auth'])->name('login');

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
Route::post('/comment/{comment}/reply', [HomeController::class, 'storeReply'])->name('comment.reply');
Route::post('/comment/{id}/like', [HomeController::class, 'toggleLikeComment'])->name('comment.like');
Route::post('/comment/{id}/dislike', [HomeController::class, 'toggleDislikeComment'])->name('comment.dislike');
Route::delete('/comments/{id}', [HomeController::class, 'deleteComment'])->name('comments.delete');


Route::post('/video/{id}/like', [HomeController::class, 'likeVideo'])->name('video.like');
Route::post('/video/{id}/dislike', [HomeController::class, 'dislikeVideo'])->name('video.dislike');

Route::post('/video/{id}/rate', [HomeController::class, 'rateVideo'])->name('video.rate');
Route::post('/video/{id}/delete-rating', [HomeController::class, 'deleteRating'])->name('video.delete-rating');

Route::get('/watchlist', [HomeController::class, 'watchlist'])->name('watchlists');
Route::post('/trailer/{id}/bookmark', [HomeController::class, 'toggleWatchlist'])->name('trailer.bookmark');

Route::post('/switch-account/{accountId}', [AuthController::class, 'switchAccount'])->name('switch-account');
Route::post('/update-profile-photo', [AuthController::class, 'updateProfilePhoto'])->name('update-profile-photo');
Route::delete('/delete-profile-photo', [AuthController::class, 'deleteProfilePhoto'])->name('delete-profile-photo');
Route::delete('/profile/photo', [AuthController::class, 'deleteProfilePhoto'])->name('delete-profile-photo');
Route::post('/delete-profile-photo', [AuthController::class, 'deleteProfilePhoto'])->name('delete-profile-photo');

Route::get('/lang/{lang}', function ($lang) {
    App::setLocale($lang);
    return response()->json([
        'settings' => __('messages.settings'),
        'select_language' => __('messages.select_language'),
        'select_theme' => __('messages.select_theme'),
        'save' => __('messages.save'),
        'light' => __('messages.light'),
        'dark' => __('messages.dark'),
        'english' => __('messages.english'),
        'indonesian' => __('messages.indonesian'),
    ]);
});

Route::post('/change-language', [HomeController::class, 'changeLanguage'])->name('changeLanguage');












