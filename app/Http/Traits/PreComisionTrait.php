<?php

namespace App\Http\Traits;
use App\Models\solicitud\PreComision;
use Illuminate\Support\Str;

trait PreComisionTrait {
    public function savePreComision($request) {
        // Fetch all the students from the 'choferes' table.
       
            $insert_pre_comision = new PreComision();
            $insert_pre_comision->rendimiento = Str::upper($request->get('rendimiento_vehiculo'));
            $insert_pre_comision->costo_combustible = Str::upper($request->get('costo_combustible'));
            $insert_pre_comision->placas_vehiculo = Str::upper($request->get('placas_comision'));
            $insert_pre_comision->marca_vehiculo = Str::upper($request->get('marca_vehiculo'));
            $insert_pre_comision->km_totales = Str::upper($request->get('km_totales'));
            $insert_pre_comision->peaje = Str::upper($request->get('peaje_total'));
            $insert_pre_comision->monto_total = Str::upper($request->get('monto_total'));
            $insert_pre_comision->vehiculo_id = Str::upper($request->get('idcatvehiculo'));
            $insert_pre_comision->save();
            /**
             * retornamos el último id
             */
            return $insert_pre_comision->id;
    }

    public function getPreComision()
    {
        /**
         * se tiene que mejorar la consulta para obtener los precomisiones no enviadas.
         */
        return  PreComision::select('rendimiento', 'costo_combustible', 'placas_vehiculo', 'marca_vehiculo',
        'km_totales', 'peaje', 'monto_total', 'vehiculo_id', 'id', 'comisionado')->orderBy('id','DESC')->get();
    }

    protected function getPreComisionRevision()
    {
        return Precomision::select('pre_comision.rendimiento', 'pre_comision.costo_combustible', 'pre_comision.placas_vehiculo', 'pre_comision.marca_vehiculo', 'pre_comision.comisionado', 'pre_comision.id')
        ->leftjoin('solicitud', 'pre_comision.id', '=', 'solicitud.pre_comision_id')
        ->leftjoin('seguimiento_solicitud', 'solicitud.id', '=', 'seguimiento_solicitud.solicitud_id')
        ->where([
            ['pre_comision.comisionado', true],
            ['seguimiento_solicitud.status_seguimiento_id', '<>', 5]
        ])->orderBy('pre_comision.id', 'DESC')->get();
    }
}