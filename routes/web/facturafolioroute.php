<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\factura_folio\FacturaController;

Route::middleware(['auth'])->group(function () {
    /**
     * grupos autenticados
     */
    Route::get('/factura/index', [FacturaController::class, 'index'])->name('factura.index');
    Route::get('/factura/create', [FacturaController::class, 'create'])->name('factura.create');
    Route::post('/factura/store', [FacturaController::class, 'store'])->name('factura.save');
    Route::get('/factura/{filename}', [FacturaController::class, 'getFile'])->name('factura.getfile');
});


