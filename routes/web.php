<?php

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

Route::prefix('admin')->group(function () {
    
    Route::get('login', [Backend\Auth\LoginController::class,'showLoginForm'])->name('login');
    Route::post('login', [Backend\Auth\LoginController::class,'login']);
    Route::post('logout', [Backend\Auth\LoginController::class,'logout'])->name('logout');
    Route::get('register', [Backend\Auth\RegisterController::class,'showRegistrationForm'])->name('register');
    Route::post('register', [Backend\Auth\RegisterController::class,'register']);
    
});

Route::prefix('user')->group(function () {
    
    Route::get('login', [Frontend\Auth\LoginController::class,'showLoginForm'])->name('login');
    Route::post('login', [Frontend\Auth\LoginController::class,'login']);
    Route::post('logout', [Frontend\Auth\LoginController::class,'logout'])->name('logout');
    Route::get('register', [Frontend\Auth\RegisterController::class,'showRegistrationForm'])->name('register');
    Route::post('register', [Frontend\Auth\RegisterController::class,'register']);
    
});




Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any','.*');
