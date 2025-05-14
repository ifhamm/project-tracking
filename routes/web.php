<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ProsesMekanikController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChartController;
use App\Http\Middleware\CheckSession;

// Public routes
Route::get('/login', [LoginController::class, 'index'])->name('login.show');
Route::post('/loginSuperadmin', [LoginController::class, 'loginSuperAdmin'])->name('loginSuperAdmin');
Route::post('/loginUser', [LoginController::class, 'loginUser'])->name('loginUser');
Route::get('/register', [RegisterController::class, 'index'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// Protected routes
Route::group(['middleware' => [CheckSession::class]], function () {
    // Dashboard - accessible to all roles
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard_utama');

    // API routes
    Route::get('/api/chart-data/{customer}', [ChartController::class, 'getData']);
    Route::get('/api/parts-by-customer/{customer}', [PartController::class, 'getByCustomer']);

    // PM can only access dashboard (no additional routes needed)

    // Mekanik routes
    Route::middleware(['role:mekanik,superadmin'])->group(function () {
        Route::get('/proses-mekanik', [ProsesMekanikController::class, 'index'])->name('proses-mekanik');
        Route::post('/proses-mekanik/update-step', [ProsesMekanikController::class, 'updateStep'])->name('proses-mekanik.update-step');
        Route::get('/detail-proses', function () {
            return view('detail_komponen');
        });

        // Superadmin/PPC routes
        Route::get('/komponen', [PartController::class, 'create'])->name('komponen');
        Route::get('/part/create', [PartController::class, 'create'])->name('part.create');
        Route::post('/part/store', [PartController::class, 'store'])->name('part.store');
    });

    // Logout route
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
