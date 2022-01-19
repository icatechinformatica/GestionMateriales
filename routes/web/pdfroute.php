<?php
use Illuminate\Support\Facades\Route;
# Import Controller Class
use App\Http\Controllers\pdfControllers\ReporteBitacoraController;

# Add Route
Route::get('/generate-pdf', [ReporteBitacoraController::class, 'index']);
Route::get('/generar/reporte/pdf/bitacora/{id}', [ReporteBitacoraController::class, 'show'])->name('generar.reporte.bitacora.pdf');
