<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\solicitud\ComisionController;
use App\Http\Controllers\solicitud\PreComisionController;

Route::middleware(['auth', 'role:revisor|capturista', 'permission:anular publicacion bitacora|borrar bitacora|editar bitacora|publicar bitacora|revisar bitacora|ver bitacora|ver comision|revisar comision|crear precomision|ver-editar-pre-comision'])->group(function () {
    Route::post('/solicitud/temooral/comision/archivar', [ComisionController::class, 'store'])->name('comision.pre.send.to.request');
    Route::get('/solicitud/bitacora/comision/index', [ComisionController::class, 'index'])->name('solicitud.bitacora.comision.index');
    Route::get('/solicitud/bitacora/comision/pre-guardado/{id}', [ComisionController::class, 'show'])->name('comision.pre.guardado');
    Route::get('/solicitud/bitacora/pre/comision/index', [ComisionController::class, 'precomision'])->name('pre.comision.index')->middleware('can:ver comision');
    Route::post('/solicitud/bitacora/pre/comision/update', [ComisionController::class, 'comisionupdate'])->name('solicitud.temporal.comision.update');
    Route::get('/solicitud/pre/comision/create', [ComisionController::class, 'comisioncreatepre'])->name('solicitud.pre.comision.create')->middleware('can:crear precomision');
    Route::post('/solicitud/pre/comision/store', [PreComisionController::class, 'store'])->name('solicitud.pre.comision.store');
    Route::get('/solicitud/pre/comision/detalle/{id}', [PreComisionController::class, 'show'])->name('solicitud.pre.comision.details')->middleware('can:ver-editar-pre-comision');
    Route::get('/solicitud/pre/comision/continue/{id}', [PrecomisionController::class, 'edit'])->name('solicitud.pre.comision.continue');
    Route::post('/solicitud/pre/comision/enviar/registro', [PrecomisionController::class, 'saveandupdate'])->name('solicitud.pre.comision.enviar.registro');
    Route::get('/solicitud/pre/comision/revision', [PrecomisionController::class, 'getRevision'])->name('solicitud.pre.comision.revision')->middleware('can:revisar comision');
    Route::get('/solicitud/pre/comision/revision/precomision/{id}/{status}', [PreComisionController::class, 'preComisionGetRevision'])->name('solicitud.pre.comision.revision.detalle')->middleware('can:revisar comision');
    Route::put('/solicitud/comision/validar/bitacora/{id}', [preComisionController::class, 'update'])->name('solicitud.comision.validar.bitacora');
    Route::get('/solicitud/pre/comision/getrendimiento', [ComisionController::class, 'get_rendimiento'])->name('solicitud.pre.comision.get.rendimiento');
});
