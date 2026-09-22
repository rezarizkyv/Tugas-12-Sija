<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElearningController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\GradebookController;
use App\Http\Controllers\MonitoringOsisController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| SMKN 1 Medelin Web Portal Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke login
Route::redirect('/', '/login');

// Route Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route khusus Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

// Route User (Siswa/Guru - Sudah Login)
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/elearning', [ElearningController::class, 'index'])->name('elearning');
    Route::get('/elearning/{course}', [ElearningController::class, 'show'])->name('elearning.show');
    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi');
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
    Route::get('/ujian', [UjianController::class, 'index'])->name('ujian');
    Route::get('/gradebook', [GradebookController::class, 'index'])->name('gradebook');
    Route::get('/monitoring-osis', [MonitoringOsisController::class, 'index'])->name('monitoring-osis');
});
