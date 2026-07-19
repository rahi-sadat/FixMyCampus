<?php

use App\Http\Controllers\Staff\ComplaintWorkflowController;
use App\Http\Controllers\Staff\ProgressController;
use App\Http\Controllers\Staff\StaffDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', StaffDashboardController::class)->name('dashboard');
    Route::get('/complaints', [ComplaintWorkflowController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [ComplaintWorkflowController::class, 'show'])->name('complaints.show');
    Route::post('/complaints/{complaint}/progress', [ProgressController::class, 'store'])->name('complaints.progress');
});
