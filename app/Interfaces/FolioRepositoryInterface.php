<?php
/**
 * creado y desarrollado por MIS. Daniel Méndez Cruz
 */
namespace App\Interfaces;
use Illuminate\Http\Request;

interface FolioRepositoryInterface
{
    // cargamos las funciones principales que utilizaremos en la clase de Folio
    public function addFolioFactura(Request $folioRequest);
    public function getFolio(Request $request, $id);
    public function searchFolio(Request $request);
    public function loadData(Request $request);
    public function getFoliosByStatus();
    public function getDenominacionByFactura();
    public function cargarFolios(Request $req);
    public function asignarFoliosVehiculo(Request $rquest);
    public function folioAsignadoIndex();
    public function getDetails($id);
    public function getReasignar($id);
    public function getFolioByCatVehicle($id);
    public function getSumByFoliosUsed($id);
}
