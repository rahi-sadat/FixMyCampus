<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ComplaintManagementController;
use App\Http\Controllers\Admin\ComplaintReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');
    Route::get('/complaints', [ComplaintReviewController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{complaint}', [ComplaintReviewController::class, 'show'])->name('complaints.show');
    Route::delete('/complaints/{complaint}', [ComplaintManagementController::class, 'destroy'])->name('complaints.destroy');
});
