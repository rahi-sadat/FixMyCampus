<?php

use App\Http\Controllers\ComplaintImageController;
use App\Http\Controllers\Student\ComplaintSubmissionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/complaints/create', [ComplaintSubmissionController::class, 'create'])->name('complaints.create');
    Route::post('/complaints', [ComplaintSubmissionController::class, 'store'])->name('complaints.store');
    Route::post('/complaints/{complaint}/images', [ComplaintImageController::class, 'store'])->name('complaints.images.store');
});
