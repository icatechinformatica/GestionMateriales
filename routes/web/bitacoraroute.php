<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\solicitud\SolicitudBitacoraController;
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

Auth::routes();

Route::middleware(['auth', 'role:revisor|capturista', 'permission:anular publicacion bitacora|borrar bitacora|editar bitacora|publicar bitacora|revisar bitacora|ver bitacora|ver comision|ver-solicitud-bitacora-pre|ver-editar-bitacora', 'prevent-back-history'])->group(function () {
    /**
     * grupos de autenticación -
     */
    Route::get('/solicitud/index', 'solicitud\SolicitudBitacoraController@index')->name('solicitud.bitacora.index')->middleware('can:ver bitacora');
    Route::get('/solicitud/create', 'solicitud\SolicitudBitacoraController@create')->name('solicitud.bitacora.create')->middleware('can:publicar bitacora');
    Route::post('/solicitud/store', 'solicitud\SolicitudBitacoraController@store')->name('solicitud.bitacora.store')->middleware('can:publicar bitacora');
    Route::get('/solicitud/autocomplete', 'solicitud\SolicitudBitacoraController@autocomplete')->name('autocomplete');
    Route::get('/solicitud/softload', 'solicitud\SolicitudBitacoraController@loaddata')->name('softload');
    Route::get('/solicitud/detail/{id}', 'solicitud\SolicitudBitacoraController@show')->name('solicitud.bitacora.detalle');
    Route::get('/solicitud/bitacora/revision/index', 'solicitud\SolicitudBitacoraController@revisionIndex')->name('solicitud.bitacora.revision');
    Route::get('/solicitud/revision/detail/{id}', 'solicitud\SolicitudBitacoraController@revisionDetalle')->name('revision.bitacora.detalle')->middleware('can:revisar bitacora');
    Route::get('/solicitud/previo/index', 'solicitud\SolicitudBitacoraController@indexsolicitudprevia')->name('solicitud.bitacora.previo.guardado')->middleware('can:ver-solicitud-bitacora-pre');
    Route::get('/solicitud/pre/save/{id}', 'solicitud\SolicitudBitacoraController@show')->name('solicitud.bitacora.pre.guardado');
    Route::get('/solicitud/detalle/pre-guardado/{id}', 'solicitud\SolicitudBitacoraController@preguardado')->name('bitacora.detalle.pre.guardado')->middleware('can:ver-editar-bitacora');
    Route::post('/solicitud/pre/store', 'solicitud\SolicitudBitacoraController@storeBitacora')->name('solicitud.bitacora.pre.store.send');
    Route::get('/solicitud/bitacora/revision/{review}', 'solicitud\SolicitudBitacoraController@getreview')->name('solicitud.bitacora.get.review');
    Route::post('/solicitud/bitacora/terminar', 'solicitud\SolicitudBitacoraController@done')->name('solicitud.done.bitacora');
    Route::get('/solicitud/bitacora/generar/documento', 'solicitud\SolicitudBitacoraController@archived')->name('solicitud.bitacora.generar_documento.firma')->middleware('can:ver-firma-bitacora');
    Route::get('/solicitud/bitacora/terminado/{id}', 'solicitud\SolicitudBitacoraController@solicitud_detalle_archived')->name('solicitud.bitacora.terminado');
    Route::post('/solicitud/fetch', 'solicitud\SolicitudBitacoraController@fetch')->name('autocomplete.fetch');
    Route::get('/solicitud/reporte/bitacora/index', [SolicitudBitacoraController::class, 'reporteBitacora'])->name('reporte.solicitud.bitacora_recorrido');
    Route::post('/solicitud/reporte/get/info', [SolicitudBitacoraController::class, 'reporteGetInfo'])->name('solicitud.reporte.bitacora.obtener.vinculados');
    Route::get('/solicitud/reporte/filter/get/facturas', [SolicitudBitacoraController::class, 'getFilterFactura'])->name('filter.get.facturas');
    Route::post('/solicitud/reporte/save', [SolicitudBitacoraController::class, 'saveDataReporte'])->name('reporte.solicitud.bitacora.save');

});




