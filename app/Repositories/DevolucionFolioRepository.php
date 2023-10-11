<?php

namespace App\Repositories;

use App\Interfaces\DevolucionFolioRepositoryInterface;
use Illuminate\Database\QueryException;
use App\Models\factura_folio\Folio;
use App\Models\solicitud\CatalogoVehiculo;
use Illuminate\Support\Facades\DB;

class DevolucionFolioRepository implements DevolucionFolioRepositoryInterface
{
    public function getVehiculos()
    {
        try {
            //realizamos la consulta
            return CatalogoVehiculo::where('marca', '!=', 'REMOLQUE')->orderBy('id', 'asc')->with(['resguardante', 'folio'])->whereHas('folio', function ($query) {
                $query->where('folio.status', '=', 'ASIGNADO');
            })->get();
        } catch (QueryException $th) {
            //throw sql exception $th;
            return $th->getMessage();
        }
    }

    public function getFolioByVehicle($id): object
    {
        $idVehicle = base64_decode($id);
        $Query = DB::table('vehiculo_folio AS VEHICULOS_FOLIOS')->select(
            'FOLIOS.numero_folio',
        )->leftJoin('folio AS FOLIOS', 'FOLIOS.id', '=', 'VEHICULOS_FOLIOS.folio_id')
            ->leftJoin('catalogo_vehiculo AS CATALOGOS_VEHICULOS', 'CATALOGOS_VEHICULOS.id', '=', 'VEHICULOS_FOLIOS.catalogo_vehiculo_id')
            ->where('CATALOGOS_VEHICULOS.id', $idVehicle)
            ->whereIn('VEHICULOS_FOLIOS.status', ['ASIGNADO'])
            ->get();

        return $Query;
    }

    public function returnFolio($folio, $id)
    {
        try {
            //modificaciones
            $getFolio = Folio::where('numero_folio', $folio)->first();
            // update folio with id
            Folio::where('id', $getFolio->id)
                ->update(['status' => 'DISPONIBLE']);

            $catVehiculo = CatalogoVehiculo::findOrFail($id);
            // delete from pivot table
            $catVehiculo->folio()->detach($getFolio->id);
            return true;
        } catch (QueryException $th) {
            //throw $th;
            return $th->getMessage();
        }
    }
}
