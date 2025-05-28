<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ProsesMekanikController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\BreakdownPartController;
use App\Http\Controllers\DokumentasiMekanikController;
use App\Http\Middleware\CheckSession;
use App\Http\Middleware\RoleMiddleware;


// Public routes
Route::get('/login', [LoginController::class, 'index'])->name('login.show');
Route::post('/loginSuperadmin', [LoginController::class, 'loginSuperAdmin'])->name('loginSuperAdmin');
Route::post('/loginUser', [LoginController::class, 'loginUser'])->name('loginUser');
Route::get('/register', [RegisterController::class, 'index'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/dokumentasi-mekanik', [DokumentasiMekanikController::class, 'index'])->name('dokumentasi-mekanik');
Route::post('/dokumentasi-mekanik/upload', [DokumentasiMekanikController::class, 'upload'])->name('dokumentasi.upload');


// Protected routes
Route::middleware([checkSession::class])->group(function () {
    // Dashboard - accessible to all roles
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard_utama');

    // API routes
    Route::get('/api/chart-data/{customer}', [ChartController::class, 'getData']);
    Route::get('/api/parts-by-customer/{customer}', [PartController::class, 'getByCustomer']);

    // Superadmin & Mekanik routes
    Route::middleware([RoleMiddleware::class . ':superadmin,mekanik'])->group(function () {
        Route::get('/komponen', [PartController::class, 'create'])->name('komponen');
        Route::get('/proses-mekanik', [ProsesMekanikController::class, 'index'])->name('proses-mekanik');
        Route::get('/breakdown_parts', [BreakdownPartController::class, 'index'])->name('breakdown.parts.index');
        Route::get('/detail-proses/{no_iwo}', [PartController::class, 'show'])->name('detail.show');
    });

    // superadmin-only routes
    Route::middleware([RoleMiddleware::class . ':superadmin'])->group(function () {
        Route::post('/part/store', [PartController::class, 'store'])->name('part.store');
        Route::get('/part/edit/{no_iwo}', [PartController::class, 'edit'])->name('part.edit');
        Route::put('/part/update/{no_iwo}', [PartController::class, 'update'])->name('part.update');
        Route::delete('/part/delete/{no_iwo}', [PartController::class, 'destroy'])->name('part.destroy');
        Route::post('/breakdown_parts', [BreakdownPartController::class, 'store'])->name('breakdown.parts.store');
        Route::get('/detail-proses', [BreakdownPartController::class, 'show'])->name('detail.komponen');
        Route::put('/breakdown_parts/{no_iwo}', [BreakdownPartController::class, 'update'])->name('breakdown.parts.update');
        Route::delete('/breakdown_parts/{no_iwo}', [BreakdownPartController::class, 'destroy'])->name('breakdown.parts.destroy');
    });

    // Mekanik-only routes
    Route::middleware([RoleMiddleware::class . ':mekanik'])->group(function () {
        Route::post('/proses-mekanik/update-step', [ProsesMekanikController::class, 'updateStep'])->name('proses-mekanik.update-step');
    });

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
})->withoutMiddleware([checkSession::class]);
