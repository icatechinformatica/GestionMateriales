<?php
namespace App\Interfaces;
use Illuminate\Http\Request;

interface DevolucionFolioRepositoryInterface
{
    public function getVehiculos();
    public function getFolioByVehicle($id);
    public function returnFolio($folio, $id);
}
