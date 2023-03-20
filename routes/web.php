<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SocialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::get('authorized/google', [SocialController::class, 'redirectToGoogle'])->name('google.login');
Route::get('authorized/google/callback', [SocialController::class, 'handleGoogleCallback']);
Route::get('authorized/facebook', [SocialController::class, 'redirectToFacebook'])->name('facebook.login');
Route::get('authorized/facebook/callback', [SocialController::class, 'handleFacebookCallback']);
Route::get('authorized/linkedin', [SocialController::class, 'redirectToLinkedin'])->name('linkedin.login');
Route::get('authorized/linkedin/callback', [SocialController::class, 'handleLinkedinCallback']);

Route::get('/user/logout', [DashboardController::class, 'userLogout'])->name('user.logout');

// Logged in users
// used throttle middleware for preventing ddos 100 request per min.
Route::group(['middleware' => ['auth', 'verified', 'throttle:100,1']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Posts
    Route::prefix('post')->group(function() {
        Route::get('/view', [PostController::class, 'index'])->name('post.view');
        Route::get('/show/{id}', [PostController::class, 'show'])->name('post.show');
        Route::get('/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/store', [PostController::class, 'store'])->name('post.store');
        Route::get('/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
        Route::post('/update/{id}', [PostController::class, 'update'])->name('post.update');
        Route::get('/destroy/{id}', [PostController::class, 'destroy'])->name('post.destroy');
        Route::post('/upload-image', [PostController::class, 'uploadImage'])->name('post.upload.image');
    });
    // ./Posts
});
