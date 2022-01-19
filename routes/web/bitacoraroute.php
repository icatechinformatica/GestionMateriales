<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'role:revisor|capturista', 'permission:anular publicacion bitacora|borrar bitacora|editar bitacora|publicar bitacora|revisar bitacora|ver bitacora|ver comision'])->group(function () {
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
    Route::get('/solicitud/previo/index', 'solicitud\SolicitudBitacoraController@indexsolicitudprevia')->name('solicitud.bitacora.previo.guardado');
    Route::get('/solicitud/pre/save/{id}', 'solicitud\SolicitudBitacoraController@show')->name('solicitud.bitacora.pre.guardado');
    Route::get('/solicitud/detalle/pre-guardado/{id}', 'solicitud\SolicitudBitacoraController@preguardado')->name('bitacora.detalle.pre.guardado');
    Route::post('/solicitud/pre/store', 'solicitud\SolicitudBitacoraController@storeBitacora')->name('solicitud.bitacora.pre.store.send');
    Route::get('/solicitud/bitacora/revision/{review}', 'solicitud\SolicitudBitacoraController@getreview')->name('solicitud.bitacora.get.review');
    Route::post('/solicitud/bitacora/terminar', 'solicitud\SolicitudBitacoraController@done')->name('solicitud.done.bitacora');
    Route::get('/solicitud/bitacora/generar/documento', 'solicitud\SolicitudBitacoraController@archived')->name('solicitud.bitacora.generar_documento.firma');
    Route::get('/solicitud/bitacora/terminado/{id}', 'solicitud\SolicitudBitacoraController@solicitud_detalle_archived')->name('solicitud.bitacora.terminado');
    Route::post('/solicitud/fetch', 'solicitud\SolicitudBitacoraController@fetch')->name('autocomplete.fetch');
});




