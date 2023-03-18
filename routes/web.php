<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
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

Route::get('/user/logout', [DashboardController::class, 'userLogout'])->name('user.logout');

// Logged in users
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', function () {
        return view('pages.home');
    })->name('home');

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
