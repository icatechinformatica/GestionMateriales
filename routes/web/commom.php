<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\AutomovilController;
use App\Http\Controllers\solicitud\ResguardanteController;
use App\Http\Controllers\cat\ChoferController;
use App\Http\Controllers\cat\DirectorioController;
use Illuminate\Support\Facades\Auth;

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

// agregar nuevo middleware que evita el ir hacia atrás desde el navegador después de un logout
Route::group(['middleware' => 'prevent-back-history'], function () {
    Auth::routes();
    Route::get('/login', [CustomAuthController::class, 'index'])->name('login');
    Route::post('/customlogin', [CustomAuthController::class, 'customLogin'])->name('login.custom');
    Route::get('/signout', [CustomAuthController::class, 'singout'])->name('signout');
    Route::get('/register', [CustomAuthController::class, 'register'])->name('register');
    Route::post('/custom-register', [CustomAuthController::class, 'customRegister'])->name('register.custom');
});


Route::middleware(['auth', 'role:revisor|capturista', 'permission:crear catalogo vehiculo|leer catalogo vehiculo|
editar catalogo vehiculo|eliminar catalogo vehiculo|leer catalogo choferes|editar catalogo choferes|crear catalogo choferes|eliminar catalogo choferes|leer catalogo resguardante|crear catalogo resguardante|
editar catalogo resguardante|eliminar catalogo resguardante|ver comision', 'prevent-back-history'])->group(function () {
    /**
     * ruta principal HOME
     */
    Route::get('/', [CustomAuthController::class, 'dashboard'])->name('dashboard');
    /**
     * rutas validacion presupuestal
     */
    Route::get('/solicitud/validacion_presupuestal/index', 'solicitud\SolicitudPresupuestal@index')->name('solicitd.validacion_presupuestal.index');
    Route::get('/solicitud/validacion_presupuestal/create', 'solicitud\SolicitudPresupuestal@create')->name('solicitd.validacion_presupuestal.create');
    Route::get('/suficiencia/presupuestal/create', 'solicitud\SolicitudPresupuestal@suficienciacreate')->name('solicitud.suficiencia_presupuestal.create');
    /**
     * rutas catalogo vehiculo
     */
    Route::get('/solicitud/catalogo/vehiculo', [AutomovilController::class, 'create'])->name('solicitud.catalogo.vehiculo')->middleware('can:crear catalogo vehiculo');
    Route::post('/solicitud/catalogo/store', [AutomovilController::class, 'store'])->name('solicitud.catalogo.store')->middleware('can:crear catalogo vehiculo');
    Route::get('/solicitud/catalogo/index', 'AutomovilController@index')->name('solicitud.cat.indice')->middleware('can:leer catalogo vehiculo');
    Route::get('/solicitud/catalogo/automovil/edit/{id}', [AutomovilController::class, 'edit'])->name('solicitud.cat.automovil.edit')->middleware('can:editar catalogo vehiculo');
    Route::put('/solicitud/catalogo/automovil/{id}/actualizar', [AutomovilController::class, 'update'])->name('solicitud.cat.automovil.update')->middleware('can:editar catalogo vehiculo');

    /**
     * rutas resguardantes
     */
    Route::get('/solicitud/resguardante/index', [ResguardanteController::class, 'index'])->name('solicitud.resguardante.indice')->middleware('can:leer catalogo resguardante');
    Route::get('/solicitud/resguardante/create', [ResguardanteController::class, 'create'])->name('solicitud.resguardante.create')->middleware('can:crear catalogo resguardante');
    Route::post('/solicitud/resguardante/store', [ResguardanteController::class, 'store'])->name('solicitud.resguardante.store')->middleware('can:crear catalogo resguardante');
    Route::get('/solicitud/resguardante/edit/{id}', [ResguardanteController::class, 'edit'])->name('solicitud.resguardante.edit')->middleware('can:editar catalogo resguardante');
    Route::put('/solicitud/resguardante/update/{id}', [ResguardanteController::class, 'update'])->name('solicitud.resguardante.update')->middleware('can:editar catalogo resguardante');

    /**
     * rutas catalogo choferes
     */
    Route::get('/solicitud/catalogo/chofer/index', [ChoferController::class, 'index'])->name('solicitud.cat.chofer')->middleware('can:leer catalogo choferes');
    Route::get('/solicitud/catalogo/chofer/create', [ChoferController::class, 'create'])->name('solicitud.cat.chofer.create')->middleware('can:crear catalogo choferes');
    Route::post('/solicitud/catalogo/chofer/store', [ChoferController::class, 'store'])->name('solicitud.cat.chofer.store')->middleware('can:crear catalogo choferes');
    Route::get('/solicitud/catalogo/chofer/edit/{id}', [ChoferController::class, 'edit'])->name('solicitud.cat.chofer.edit')->middleware('can:editar catalogo choferes');

    Route::put('/solicitud/catalogo/chofer/{id}/actualizar', [ChoferController::class, 'update'])->name('cat.choferes.update')->middleware('can:editar catalogo choferes');

    /**
     * rutas de catalogo directorio
     */
    Route::get('/solicitud/catalogo/directorio/index', [DirectorioController::class, 'index'])->name('solicitud.cat.directorio.indice')->middleware('can:leer catalogo vehiculo');
    Route::get('/solicitud/catalogo/directorio/create', [DirectorioController::class, 'create'])->name('cat.directorio.create');
    Route::post('/solicitud/catalogo/directorio/store', [DirectorioController::class, 'store'])->name('cat.directorio.store');

    /**
     * nueva tura de choferes --search
     */
    Route::get('/solicitud/catalogo/chofer/search', [ChoferController::class, 'search'])->name('solicitud.search.driver');
});
