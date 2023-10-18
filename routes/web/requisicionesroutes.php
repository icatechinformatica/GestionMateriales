<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\requisicion\RequisicionController;
use App\Http\Controllers\requisicion\MemoController;
use App\Http\Controllers\requisicion\ValidacionRequisicionController;
use App\Http\Controllers\requisicion\ExistenciaController;

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::get('/requisicion/create', [RequisicionController::class, 'create'])->name('requisicion.create');
    Route::get('/requisicion/index', [RequisicionController::class, 'index'])->name('requisicion.index');
    Route::post('/requisicion/store', [RequisicionController::class, 'store'])->name('requisicion.store');
    Route::get('/requisicion/update/{id}', [RequisicionController::class, 'update'])->name('requisicion.update');
    Route::get('/requisicion/show/{id}', [RequisicionController::class, 'show'])->name('requisicion.show');
    Route::put('/requisicion/modify/{id}', [RequisicionController::class, 'modify'])->name('requisicion.modify'); // update


    /**
     * nueva ruta para memorandum
     */
    Route::get('/requisicion/memo/create/{idrequisicion}', [MemoController::class, 'create'])->name('requisicion.memo.create');
    Route::post('/requisicion/memo/store', [MemoController::class, 'store'])->name('requisicion.memo.store');
    Route::get('/requisicion/memo/edit/{id}', [MemoController::class, 'edit'])->name('requisicion.memo.edit');
    Route::put('/requisicion/memo/update/{id}', [MemoController::class, 'update'])->name('requisicion.memo.update');
    Route::get('/requisicion/memo/download/{idmemo}', [MemoController::class, 'download'])->name('document.download');





    /**
     * rutas para funciones ajax
     */
    Route::get('/requisicion/partida/solicita', [RequisicionController::class, 'getsolicita'])->name('requisicion.partida.solicita');
    Route::get('/requisicion/partida/departamento', [RequisicionController::class, 'getdepto'])->name('requisicion.partida.getdepto');
    Route::get('/requisicion/partida/catalogo', [RequisicionController::class, 'getcatalogo'])->name('requisicion.partida.catalogo');
    Route::get('/requisicion/partida/getadministrativebody', [RequisicionController::class, 'getArea'])->name('requisicion.partida.administrativo');
    Route::get('/requisicion/partida/getdepto/{iddepto}', [RequisicionController::class, 'getDeptos'])->name('requisicion.partida.getdeptos');


    /**
     * validación de requisición
     */
    Route::get('/requisicion/validacion/index', [ValidacionRequisicionController::class, 'index'])->name('requisicion.revision.index');
    Route::get('/requisicion/validacion/check/{id}', [ValidacionRequisicionController::class, 'show'])->name('requisicion.revision.check');
    Route::post('/requisicion/validacion/store', [ValidacionRequisicionController::class, 'store'])->name('requisicion.revision.validation');
    Route::post('/requisicion/validacion/sendReturn', [ValidacionRequisicionController::class, 'sendReturn'])->name('requisicion.revision.enviarRetorno');
    // requisición existencia
    Route::get('/requisicion/existencia/index', [ExistenciaController::class, 'index'])->name('requisiciones.revision.existencia');
    Route::get('/requisicion/existencia/check/{id}', [ExistenciaController::class, 'edit'])->name('requisiciones.revision.existencia.edit');

    // buscar áreas
    Route::get('/requisicion/solicita/area', [RequisicionController::class, 'search'])->name('area.solicita.requisicion');
});
