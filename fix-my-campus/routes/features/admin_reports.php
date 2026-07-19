<?php

use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/reports', [ReportController::class, 'index'])
    ->middleware('auth')
    ->name('admin.reports.index');
