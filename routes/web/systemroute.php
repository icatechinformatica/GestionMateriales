<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\SystemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'prevent-back-history'])->group(function(){

    Route::get('profile/index/{idUser}', [SystemController::class, 'index'])->name('perfil.indice');
    Route::put('profile/user/update/{id}', [SystemController::class, 'update'])->name('perfil.update');

});
