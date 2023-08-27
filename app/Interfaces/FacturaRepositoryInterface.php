<?php
/**
 * creado y desarrollado por MIS. Daniel Méndez Cruz
 */
namespace App\Interfaces;
use Illuminate\Http\Request;

interface FacturaRepositoryInterface
{
    // cargamos las funciones principales que utilizaremos en la clase de Factura
    public function createFactura(Request $facturaRequest);
    public function facturaAll(Request $request);
    public function getFactura($id);
    public function updateFactura($id, Request $request);
    public function addDetalle(Request $request);
    public function eliminarDetalleFactura($id);
    public function getFacturaDetalle();
    public function checkFactura();
    public function getAllFacturas(Request $request);
}
