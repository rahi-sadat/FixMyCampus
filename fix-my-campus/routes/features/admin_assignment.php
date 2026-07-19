<?php

use App\Http\Controllers\Admin\ComplaintAssignmentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/assignments', [ComplaintAssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/{complaint}/edit', [ComplaintAssignmentController::class, 'edit'])->name('assignments.edit');
    Route::post('/assignments/{complaint}', [ComplaintAssignmentController::class, 'store'])->name('assignments.store');
});
