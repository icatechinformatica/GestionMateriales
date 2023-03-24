<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\DashboardController;

Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('typography');
