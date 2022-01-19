<?php

namespace App\Http\Traits;
use App\Models\solicitud\Temporal;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait TemporalTrait {

   protected function save_temporal($request){
       /**
        * obtenemos la fecha actual con el método carbon
        */
            $fecha_actual = Carbon::now();
            $anio = $fecha_actual->year;
       /**
        * inserta en la base de datos y retornamos el id
        */
        $temporal = new Temporal;
        $temporal->catalogo_vehiculo_id = $request->get('idcatvehiculo');
        // $temporal->directorio_id = $request->get('');
        $temporal->memorandum_comision = $request->get('memo_comision');
        $temporal->fecha = Str::upper($request->get('fecha_comision'));
        $temporal->periodo = Str::upper($request->get('periodo_comision'));
        $temporal->km_inicial = $request->get('kmInicial');
        $temporal->km_final_antes_cargar_combustible = $request->get('kmFinal');
        $temporal->nombre_elabora = Auth::user()->name;
        $temporal->puesto_elabora = Auth::user()->puesto;
        $temporal->conductor = Str::upper($request->get('nombreConductor'));
        $temporal->anio_actual = $anio;
        $temporal->periodo_actual = Str::upper($request->get('periodo_comision_actual'));
        $temporal->litros_totales = $request->get('litros_totales');
        $temporal->total_km_recorridos = $request->get('km_totales');
        $temporal->importe_total = $request->get('importe_total');
        $temporal->status_proceso = true;
        $temporal->users_id = Auth::user()->id;
        $temporal->observacion = $request->get('observaciones');
        $temporal->es_comision = true;
        $temporal->pre_comision_id = base64_decode($request->get('pre_comision_id'));
        // guardar registros y obteneer el último id
        $temporal->save();
        return $temporal->id;
   }

   protected function gettemporalbycomision()
   {
       return Temporal::select('temporal.fecha', 'temporal.periodo', 
       'temporal.numero_factura_compra', 'temporal.id',
       'temporal.status_proceso', 'catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo',
       'catalogo_vehiculo.tipo', 'catalogo_vehiculo.placas')
       ->leftjoin('catalogo_vehiculo', 'temporal.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
       ->where([
           ['temporal.users_id', '=', auth()->id()],
           ['temporal.enviado', '=', false],
           ['temporal.es_comision', '=', true]
       ])->get();
   }
}