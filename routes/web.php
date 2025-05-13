<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ProsesMekanikController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChartController;

// Route::get('/dashboard', function () {
//     return view('dashboard_utama');
// })->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard_utama');
Route::get('/api/chart-data/{customer}', [ChartController::class, 'getData']);

Route::get('/api/parts-by-customer/{customer}', [PartController::class, 'getByCustomer']);


Route::get('/komponen', [PartController::class, 'create'])->name('komponen');

Route::get('/proses-mekanik', [ProsesMekanikController::class, 'index'])->name('proses-mekanik');
Route::post('/proses-mekanik/update-step', [ProsesMekanikController::class, 'updateStep'])->name('proses-mekanik.update-step');

Route::get('/detail-proses', function () {
    return view('detail_komponen');
});

Route::get('/login', [LoginController::class, 'index'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/register', [RegisterController::class, 'index'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/part/create', [PartController::class, 'create'])->name('part.create');
Route::post('/part/store', [PartController::class, 'store'])->name('part.store');
