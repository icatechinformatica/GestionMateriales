<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\DashboardController;

Route::get('/dashboard/index', [DashboardController::class, 'index'])->name('typography');
Route::get('/dashboard/user/list', [DashboardController::class, 'index_user'])->name('user.list');
Route::get('/dashboard/user/profile/{id}', [DashboardController::class, 'show'])->name('dashboard.user.profile');

