<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

// Home Page
Route::get('/', function () {
    return view('index');
})->name('index');

// Other Pages
Route::view('/product', 'product')->name('product');
Route::view('/cart', 'cart')->name('cart');
Route::view('/contact', 'contact')->name('contact');


// User Authentication
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('signup.submit');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Forgot Password Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');



// Admin Authentication
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'adminLogin'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'adminLogout'])->name('admin.logout');


    // Protect Admin Routes
    Route::middleware(['auth:admin'])->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // All Users Route
        Route::get('/all-users', [UserController::class, 'index'])->name('admin.all-users');
        Route::delete('/all-users/{id}', [UserController::class, 'destroy'])->name('admin.delete-user');


        // Products Route
        Route::get('/add-product', function () {
            return view('admin.add-product');
        })->name('admin.add-product');

        Route::get('/view-products', function () {
            return view('admin.view-products');
        })->name('admin.view-products');
    });
});
