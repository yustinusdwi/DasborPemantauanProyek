<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard routes
Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');

// API routes for dashboard
Route::prefix('dashboard')->group(function () {
    Route::get('/api/projects', [dashboardController::class, 'getProjectDataApi'])->name('dashboard.api.projects');
    Route::post('/filter', [dashboardController::class, 'filterProjects'])->name('dashboard.filter');
    Route::get('/api/datatable', [dashboardController::class, 'getDataTableData'])->name('dashboard.api.datatable');
    Route::get('/api/filter-options', [dashboardController::class, 'getFilterOptions'])->name('dashboard.api.filter-options');
});

// Admin Dashboard routes
Route::get('/admin-dashboard', [AdminController::class, 'index'])->name('admin-dashboard');
Route::get('/admin', [AdminController::class, 'index'])->name('admin');

// Route untuk masing-masing form POST
Route::post('/spph-store', [AdminController::class, 'storeSPPH'])->name('spph-store');
Route::post('/sph-store', [AdminController::class, 'storeSPH'])->name('sph-store');
Route::post('/nego-store', [AdminController::class, 'storeNego'])->name('nego-store');
Route::post('/kontrak-store', [AdminController::class, 'storeKontrak'])->name('kontrak-store');

// SPPH
Route::get('/spph', [\App\Http\Controllers\spphController::class, 'index'])->name('spph.index');
// SPH
Route::get('/sph', [\App\Http\Controllers\sphController::class, 'index'])->name('sph.index');
// Nego
Route::get('/nego', [\App\Http\Controllers\negoController::class, 'index'])->name('nego.index');
// Kontrak
Route::get('/kontrak', [\App\Http\Controllers\kontrakController::class, 'index'])->name('kontrak.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
