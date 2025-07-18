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

// ===== SPPH CRUD Routes =====
Route::get('/admin/spph', [AdminController::class, 'spphIndex'])->name('spph-index');
Route::get('/admin/spph/{id}/edit', [AdminController::class, 'spphEdit'])->name('spph-edit');
Route::put('/admin/spph/{id}', [AdminController::class, 'spphUpdate'])->name('spph-update');
Route::delete('/admin/spph/{id}', [AdminController::class, 'spphDestroy'])->name('spph-destroy');

// ===== SPH CRUD Routes =====
Route::get('/admin/sph', [AdminController::class, 'sphIndex'])->name('sph-index');
Route::get('/admin/sph/{id}/edit', [AdminController::class, 'sphEdit'])->name('sph-edit');
Route::put('/admin/sph/{id}', [AdminController::class, 'sphUpdate'])->name('sph-update');
Route::delete('/admin/sph/{id}', [AdminController::class, 'sphDestroy'])->name('sph-destroy');

// ===== NEGOSIASI CRUD Routes =====
Route::get('/admin/nego', [AdminController::class, 'negoIndex'])->name('nego-index');
Route::get('/admin/nego/{id}/edit', [AdminController::class, 'negoEdit'])->name('nego-edit');
Route::put('/admin/nego/{id}', [AdminController::class, 'negoUpdate'])->name('nego-update');
Route::delete('/admin/nego/{id}', [AdminController::class, 'negoDestroy'])->name('nego-destroy');
Route::get('/admin/nego/detail-by-project', [App\Http\Controllers\negoController::class, 'getByProject'])->name('nego.detailByProject');
Route::get('/admin/nego/detail-by-id', [App\Http\Controllers\negoController::class, 'getById'])->name('nego.detailById');
Route::post('/admin/nego/store', [App\Http\Controllers\negoController::class, 'store'])->name('nego.store');
Route::put('/admin/nego/update/{id}', [App\Http\Controllers\negoController::class, 'update'])->name('nego.update');
Route::delete('/admin/nego/delete/{id}', [App\Http\Controllers\negoController::class, 'destroy'])->name('nego.destroy');
Route::put('/admin/nego/update-main/{id}', [App\Http\Controllers\negoController::class, 'updateMain'])->name('nego.updateMain');
Route::post('/admin/nego/store-detail', [App\Http\Controllers\negoController::class, 'storeDetail'])->name('nego.storeDetail');
Route::post('/admin/nego/store-main', [App\Http\Controllers\negoController::class, 'storeMain'])->name('nego.storeMain');
Route::put('/admin/nego/update-detail/{id}', [App\Http\Controllers\negoController::class, 'updateDetail'])->name('nego.updateDetail');
Route::delete('/admin/nego/delete-detail/{id}', [App\Http\Controllers\negoController::class, 'destroyDetail'])->name('nego.destroyDetail');

// ===== KONTRAK CRUD Routes =====
Route::get('/admin/kontrak', [AdminController::class, 'kontrakIndex'])->name('kontrak-index');
Route::get('/admin/kontrak/{id}/edit', [AdminController::class, 'kontrakEdit'])->name('kontrak-edit');
Route::put('/admin/kontrak/{id}', [AdminController::class, 'kontrakUpdate'])->name('kontrak-update');
Route::delete('/admin/kontrak/{id}', [AdminController::class, 'kontrakDestroy'])->name('kontrak-destroy');

// SPPH
Route::get('/spph', [\App\Http\Controllers\spphController::class, 'index'])->name('spph.index');
// SPH
Route::get('/sph', [\App\Http\Controllers\sphController::class, 'index'])->name('sph.index');
// Nego
Route::get('/nego', [\App\Http\Controllers\negoController::class, 'index'])->name('nego.index');
// Kontrak
Route::get('/kontrak', [\App\Http\Controllers\kontrakController::class, 'index'])->name('kontrak.index');

// ===== BAPP CRUD Routes =====
Route::get('/admin/bapp', [App\Http\Controllers\BappController::class, 'indexAdmin'])->name('bapp.indexAdmin');
Route::post('/admin/bapp/store', [App\Http\Controllers\BappController::class, 'store'])->name('bapp.store');
Route::post('/admin/bapp/update/{id}', [App\Http\Controllers\BappController::class, 'update'])->name('bapp.update');
Route::delete('/admin/bapp/delete/{id}', [App\Http\Controllers\BappController::class, 'destroy'])->name('bapp.destroy');
Route::get('/bapp', [App\Http\Controllers\BappController::class, 'index'])->name('bapp.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
