<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'prevent-back-history'])->group(function () {
    Route::resource('devoluciones', 'solicitud\DevolucionesFolioController');
    Route::delete('devoluciones/folio/{id}/{folio}', 'solicitud\DevolucionesFolioController@deleteimtem')->name('devoluciones.folio.done');

});
