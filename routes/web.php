<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WatchlistController;
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

Route::get('/', [HomeController::class, 'index'])->name('homepage'); 
Route::post('postLogin', [AuthController::class, 'post'])->name('postLogin');

Route::get('login', [AuthController::class, 'auth'])->name('login');

// Register routes
Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('postRegister', [AuthController::class, 'register'])->name('register.post');

Route::post('logout', [AuthController::class, 'logout'])->name('actionLogout');

//form
Route::post('formAction', [MovieController::class, 'create'])->name('form.action');

//detail
Route::get('/detail/{id}', [MovieController::class, 'show'])->name('home.detail');
Route::get('/home', [HomeController::class, 'index'])->name('home');
    
Route::post('/trailer/{id}/comment', [MovieController::class, 'storeComment'])->name('comment.store');
Route::post('/comment/{comment}/reply', [MovieController::class, 'storeReply'])->name('comment.reply');
Route::post('/comment/{id}/like', [MovieController::class, 'toggleLikeComment'])->name('comment.like');
Route::post('/comment/{id}/dislike', [MovieController::class, 'toggleDislikeComment'])->name('comment.dislike');
Route::delete('/comments/{id}', [MovieController::class, 'deleteComment'])->name('comments.delete');

Route::post('/video/{id}/like', [MovieController::class, 'likeVideo'])->name('video.like');
Route::post('/video/{id}/dislike', [MovieController::class, 'dislikeVideo'])->name('video.dislike');

Route::post('/video/{id}/rate', [MovieController::class, 'rateVideo'])->name('video.rate');
Route::post('/video/{id}/delete-rating', [MovieController::class, 'deleteRating'])->name('video.delete-rating');

Route::get('/watchlist', [WatchlistController::class, 'watchlist'])->name('watchlists');
Route::post('/trailer/{id}/bookmark', [WatchlistController::class, 'toggleWatchlist'])->name('trailer.bookmark');

Route::post('/switch-account/{accountId}', [AuthController::class, 'switchAccount'])->name('switch-account');
Route::post('/update-profile-photo', [AuthController::class, 'updateProfilePhoto'])->name('update-profile-photo');
Route::delete('/delete-profile-photo', [AuthController::class, 'deleteProfilePhoto'])->name('delete-profile-photo');
Route::delete('/profile/photo', [AuthController::class, 'deleteProfilePhoto'])->name('delete-profile-photo');
Route::post('/delete-profile-photo', [AuthController::class, 'deleteProfilePhoto'])->name('delete-profile-photo');

Route::get('/user-history', [HistoryController::class, 'getUserHistory'])->name('user.history');
Route::get('/getUserHistory', [HistoryController::class, 'getUserHistory']);


Route::get('/settings', [SettingsController::class, 'settings'])->name('settings');
Route::post('/set-theme', [SettingsController::class, 'setTheme'])->name('set.theme');
Route::post('/settings/update-theme', [SettingsController::class, 'updateTheme'])->name('settings.updateTheme');
Route::post('/change-theme', [SettingsController::class, 'changeTheme'])->name('theme.change');
Route::post('/change-language', [SettingsController::class, 'changeLanguage'])->name('language.change');
Route::post('/settings/save', [SettingsController::class, 'saveSettings'])->name('settings.save');
Route::get('change-language/{locale}', function ($locale) {
    session(['locale' => $locale]);
    return redirect()->back();
});

Route::get('/menu', [MenuController::class, 'menu'])->name('menu');

Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
Route::get('/notifications', [NotificationController::class, 'fetchNotifications'])->name('notifications.fetch');









