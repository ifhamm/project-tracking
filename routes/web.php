<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\RegisterController;

Route::get('/dashboard', function () {
    return view('dashboard_utama');
})->name('dashboard');

Route::get('/komponen', function () {
    return view('komponen');
});

Route::get('/proses-mekanik', function () {
    return view('proses_mekanik');
});

Route::get('/detail-proses', function () {
    return view('detail_komponen');
});

Route::get('/login', [LoginController::class, 'index'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/register', [RegisterController::class, 'index'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
