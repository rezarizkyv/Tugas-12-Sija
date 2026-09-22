<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttendanceApiController;
use App\Http\Controllers\Api\CbtExamApiController;

/*
|--------------------------------------------------------------------------
| Mobile App REST API Routes (SMKN 1 Medelin)
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Attendance Endpoints
    Route::post('/attendance/check-in', [AttendanceApiController::class, 'checkIn']);
    Route::get('/attendance/history', [AttendanceApiController::class, 'history']);

    // CBT Exam Endpoints
    Route::post('/quizzes/{id}/log-violation', [CbtExamApiController::class, 'logViolation']);
    Route::post('/quizzes/{id}/submit', [CbtExamApiController::class, 'submitExam']);
});
