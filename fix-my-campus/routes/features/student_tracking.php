<?php

use App\Http\Controllers\Student\ComplaintTrackingController;
use App\Http\Controllers\Student\StudentDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/student/dashboard', StudentDashboardController::class)->name('student.dashboard');
    Route::get('/complaints', [ComplaintTrackingController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [ComplaintTrackingController::class, 'show'])->name('complaints.show');
});
