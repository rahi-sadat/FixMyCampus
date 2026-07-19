<?php

use App\Http\Controllers\Student\FeedbackController;
use Illuminate\Support\Facades\Route;

Route::post('/complaints/{complaint}/feedback', [FeedbackController::class, 'store'])
    ->middleware('auth')
    ->name('complaints.feedback');
