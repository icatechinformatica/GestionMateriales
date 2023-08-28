<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\factura_folio\FacturaController;
use App\Http\Controllers\factura_folio\FolioController;

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    /**
     * grupos autenticados
     */
    Route::get('/factura/index', [FacturaController::class, 'index'])->name('factura.index');
    Route::get('/factura/create', [FacturaController::class, 'create'])->name('factura.create');
    Route::post('/factura/store', [FacturaController::class, 'store'])->name('factura.save');
    Route::get('/factura/{filename}', [FacturaController::class, 'getFile'])->name('factura.getfile');
    Route::get('/factura/edit/{id}', [FacturaController::class, 'edit'])->name('factura.edit');
    Route::get('/factura/add/folios/{id}', [FolioController::class, 'show'])->name('factura.add.folio');
    Route::post('/factura/details/add', [FacturaController::class, 'storeDetail'])->name('factura.add.details');
    Route::delete('/factura/delete/details/{id}', [FacturaController::class, 'destroy'])->name('factura.delete.details');
    Route::post('/folio/add/factura', [FolioController::class, 'store'])->name('folio.add.factura');
    Route::get('/folio/assign/vouchers', [FolioController::class, 'index_voucher'])->name('folio.assign.vouchers');
    Route::get('/folios/assign/create', [FolioController::class, 'create'])->name('folios.assign.create');
    Route::get('/folio/search', [FolioController::class, 'folioSearch'])->name('assign.search');
    Route::post('/vales/assign/load', [FolioController::class, 'loadData'])->name('assign.load');
    Route::post('/get/vales/load', [FolioController::class, 'cargarVales'])->name('getVales.load');
    Route::post('/folio/assign/data/store', [FolioController::class, 'attachCatVehiculoFolio'])->name('assign.folio.store.vehicle');
    Route::get('/folio/get/details/{id}', [FolioController::class, 'getDetails'])->name('folioGetDetails');
    Route::get('/factura/folio/get/reasignar/{id}', [FolioController::class, 'getFolioReasignar'])->name('facturagetReasignarStatus');

});


