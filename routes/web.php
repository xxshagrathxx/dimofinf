<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuotationContoller;
use App\Http\Controllers\UserController;
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
// Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
// Route::post('/create-user', [RegisterController::class, 'createUser'])->name('create.user');

Route::get('/user/logout', [DashboardController::class, 'userLogout'])->name('user.logout');

// Logged in users
Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', function () {
        return view('pages.home');
    })->name('home');

    // Products
    Route::prefix('product')->group(function() {
        Route::get('/view', [ProductController::class, 'index'])->name('product.view');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('/destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
        // Excel
            Route::get('/excel/view', [ProductController::class, 'excelView'])->name('product.excel.view');
            Route::get('/excel/download', [ProductController::class, 'excelDownload'])->name('product.excel.download');
            Route::post('/excel/import', [ProductController::class, 'excelImport'])->name('product.excel.import');
        // ./Excel
    });
    // ./Products

    // Currencies
        Route::prefix('currency')->group(function() {
            Route::get('/view', [CurrencyController::class, 'index'])->name('currency.view');
            Route::get('/show/{id}', [CurrencyController::class, 'show'])->name('currency.show');
            Route::get('/create', [CurrencyController::class, 'create'])->name('currency.create');
            Route::post('/store', [CurrencyController::class, 'store'])->name('currency.store');
            Route::get('/edit/{id}', [CurrencyController::class, 'edit'])->name('currency.edit');
            Route::post('/update/{id}', [CurrencyController::class, 'update'])->name('currency.update');
            Route::get('/destroy/{id}', [CurrencyController::class, 'destroy'])->name('currency.destroy');
        });
    // ./Currencies

    // Categories
        Route::prefix('category')->group(function() {
            Route::get('/view', [CategoryController::class, 'index'])->name('category.view');
            Route::get('/show/{id}', [CategoryController::class, 'show'])->name('category.show');
            Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
            Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
            Route::get('/destroy/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
            // Excel
                Route::get('/excel/view', [CategoryController::class, 'excelView'])->name('category.excel.view');
                Route::get('/excel/download', [CategoryController::class, 'excelDownload'])->name('category.excel.download');
                Route::post('/excel/import', [CategoryController::class, 'excelImport'])->name('category.excel.import');
            // ./Excel
        });
    // ./Categories

    // Customers
        Route::prefix('customer')->group(function() {
            Route::get('/view', [CustomerController::class, 'index'])->name('customer.view');
            Route::get('/show/{id}', [CustomerController::class, 'show'])->name('customer.show');
            Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
            Route::post('/store', [CustomerController::class, 'store'])->name('customer.store');
            Route::get('/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
            Route::post('/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
            Route::get('/destroy/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
            // Excel
                Route::get('/excel/view', [CustomerController::class, 'excelView'])->name('customer.excel.view');
                Route::get('/excel/download', [CustomerController::class, 'excelDownload'])->name('customer.excel.download');
                Route::post('/excel/import', [CustomerController::class, 'excelImport'])->name('customer.excel.import');
            // ./Excel
        });
    // ./Customers

    // Quotation
        Route::prefix('quotation')->group(function() {
            Route::get('/quote', [QuotationContoller::class, 'index'])->name('quotation.index');
            Route::get('/list', [QuotationContoller::class, 'listAllQuotations'])->name('quotation.list');
            Route::get('/getPrice/{id}', [QuotationContoller::class, 'getPrice'])->name('quotation.get.price');
            Route::post('/store', [QuotationContoller::class, 'store'])->name('quotation.store');
            Route::get('/show/{id}', [QuotationContoller::class, 'show'])->name('quotation.show');
            Route::get('/destroy/{id}', [QuotationContoller::class, 'destroy'])->name('quotation.destroy');
            Route::post('/view/pdf/{quotationId}', [QuotationContoller::class, 'viewPDF'])->name('quotation.view.pdf');
            Route::post('/download/pdf/{quotationId}', [QuotationContoller::class, 'downloadPDF'])->name('quotation.download.pdf');
        });
    // ./Quotation

    // Profile
        Route::prefix('profile')->group(function() {
            Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        });
    // ./Profile
});

// Admin Routes
Route::group(['middleware' => ['auth', 'is.admin']], function () {
    // Users
        Route::prefix('user')->group(function() {
            Route::get('/view', [UserController::class, 'index'])->name('user.view');
            Route::get('/show/{id}', [UserController::class, 'show'])->name('user.show');
            Route::get('/create', [UserController::class, 'create'])->name('user.create');
            Route::post('/store', [UserController::class, 'store'])->name('user.store');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
            Route::get('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        });
    // ./Users
});