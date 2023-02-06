<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Auth::routes();  // All routes for Authorisation
Route::controller(LoginController::class)->group(function (): void {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function (): void {
    Route::get('register', 'showRegistrationForm')->name('register');
    Route::post('register', 'register');
});
