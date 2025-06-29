<?php

use App\Http\Controllers\AddMekanikPmController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ProsesMekanikController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\BreakdownPartController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\DokumentasiMekanikController;
use App\Http\Middleware\CheckSession;
use App\Http\Middleware\RoleMiddleware;


// Public routes
Route::get('/login', [LoginController::class, 'index'])->name('login.show');
Route::post('/loginSuperadmin', [LoginController::class, 'loginSuperAdmin'])->name('loginSuperAdmin');
Route::post('/loginUser', [LoginController::class, 'loginUser'])->name('loginUser');

// Protected routes
Route::middleware([checkSession::class])->group(function () {
    // Dashboard - accessible to all roles
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard_utama');
    Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData']);

    // API routes
    Route::get('/api/chart-data/{customer}', [DashboardController::class, 'chartData']);
    Route::get('/api/parts-by-customer/{customer?}', [PartController::class, 'getByCustomer']);

    Route::get('/export/pdf', [ExportController::class, 'exportPdf'])->name('export.pdf');

    // Dokumentasi routes
    Route::get('/dokumentasi-mekanik', [DokumentasiMekanikController::class, 'index'])->name('dokumentasi-mekanik');
    Route::post('/dokumentasi/upload', [DokumentasiMekanikController::class, 'upload'])->name('dokumentasi.upload');
    Route::get('/dokumentasi/filter', [DokumentasiMekanikController::class, 'filter'])->name('dokumentasi.filter');
    Route::delete('/dokumentasi/{id}', [DokumentasiMekanikController::class, 'destroy'])->name('dokumentasi.delete');
    Route::get('/dokumentasi/{no_iwo}', [DokumentasiMekanikController::class, 'show'])->name('dokumentasi.detail');

    // Superadmin & Mekanik routes
    Route::middleware([RoleMiddleware::class . ':superadmin,mekanik,ppc'])->group(function () {
        Route::get('/komponen', [PartController::class, 'create'])->name('komponen');
        Route::get('/proses-mekanik', [ProsesMekanikController::class, 'index'])->name('proses-mekanik');
        Route::get('/breakdown_parts', [BreakdownPartController::class, 'index'])->name('breakdown.parts.index');
        Route::get('/detail-proses/{no_iwo}', [PartController::class, 'show'])->name('detail.show');
        Route::get('/detail-proses', [BreakdownPartController::class, 'show'])->name('detail.komponen');
        Route::get('/part/{no_iwo}', [PartController::class, 'show'])->name('part.show');
        Route::post('/proses-mekanik/update-step', [ProsesMekanikController::class, 'updateStep'])->name('proses-mekanik.update-step');
    });

    // superadmin & ppc routes
    Route::middleware([RoleMiddleware::class . ':superadmin,ppc'])->group(function () {
        Route::post('/part/store', [PartController::class, 'store'])->name('part.store');
        Route::put('/part/update/{no_iwo}', [PartController::class, 'update'])->name('part.update');
        Route::delete('/part/delete/{no_iwo}', [PartController::class, 'destroy'])->name('part.destroy');
        Route::post('/breakdown_parts', [BreakdownPartController::class, 'store'])->name('breakdown.parts.store');
        Route::put('/breakdown_parts/{no_iwo}', [BreakdownPartController::class, 'update'])->name('breakdown.parts.update');
        Route::post('/parts/{no_iwo}/set-urgent', [PartController::class, 'setUrgent'])->name('parts.setUrgent');
        Route::delete('/breakdown_parts/{bdp_number}', [BreakdownPartController::class, 'destroy'])->name('breakdown.parts.destroy');
    });

    // superadmin-only routes
    Route::middleware([RoleMiddleware::class . ':superadmin,ppc'])->group(function () {
        Route::get('/add-mekanik-PM', [AddMekanikPmController::class, 'index'])->name('add-mekanik-PM');
        Route::post('/add-mekanik-PM/add', [AddMekanikPmController::class, 'store'])->name('add-mekanik-PM.store');
        Route::delete('/add-mekanik-PM/destroy/{id_credentials}', [AddMekanikPmController::class, 'destroy'])->name('add-mekanik-PM.destroy');
        Route::get('/add-mekanik-PM/edit/{id_credentials}', [AddMekanikPmController::class, 'edit'])->name('add-mekanik-PM.edit');
        Route::put('/add-mekanik-PM/update/{id_credentials}', [AddMekanikPmController::class, 'update'])->name('add-mekanik-PM.update');
        
    });

    // Mekanik-only routes
    Route::middleware([RoleMiddleware::class . ':mekanik'])->group(function () {
        // Route::post('/proses-mekanik/update-step', [ProsesMekanikController::class, 'updateStep'])->name('proses-mekanik.update-step');
    });

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
})->withoutMiddleware([checkSession::class]);
