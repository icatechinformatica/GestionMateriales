<?php
/**
 * creado y desarrollado por MIS. Daniel Méndez Cruz
 */
namespace App\Interfaces;
use Illuminate\Http\Request;

interface BitacoraRepositoryInterface
{
    // cargamos las funciones principales que utilizaremos de la Bitacora
    public function getBitacora();
    public function getBitacoraDetails($id);
    public function storeRouteLog(Request $request);
    public function getBitacoraTemp($id);
    public function getBitacoraReport(Request $request);
    public function getTemporal($id);
}
