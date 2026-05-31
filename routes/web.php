<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Painel\DashboardController;
use App\Http\Controllers\Painel\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::post('/auth', [AuthController::class, 'authentication'])->name('login.auth');


Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard.index');

    Route::resource('products', ProductController::class);

});