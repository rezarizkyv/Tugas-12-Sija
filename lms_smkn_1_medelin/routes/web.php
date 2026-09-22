<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElearningController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\GradebookController;
use App\Http\Controllers\MonitoringOsisController;

/*
|--------------------------------------------------------------------------
| SMKN 1 Medelin Web Portal Routes
|--------------------------------------------------------------------------
| Login is BYPASSED per requirements, opening the Main Dashboard directly.
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/elearning', [ElearningController::class, 'index'])->name('elearning');
Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi');
Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal');
Route::get('/ujian', [UjianController::class, 'index'])->name('ujian');
Route::get('/gradebook', [GradebookController::class, 'index'])->name('gradebook');
Route::get('/monitoring-osis', [MonitoringOsisController::class, 'index'])->name('monitoring-osis');
