<?php

use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');





Route::middleware('auth')->group(function () {
    Route::get('dosen/export/excel', [DosenController::class, 'exportExcel'])->name('dosen.export.excel');
    Route::get('dosen/export/pdf', [DosenController::class, 'exportPdf'])->name('dosen.export.pdf');
    Route::resource('dosen',DosenController::class);
    
    Route::get('mahasiswa/export/excel', [MahasiswaController::class, 'exportExcel'])->name('mahasiswa.export.excel');
    Route::get('mahasiswa/export/pdf', [MahasiswaController::class, 'exportPdf'])->name('mahasiswa.export.pdf');
    Route::resource('mahasiswa',MahasiswaController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
