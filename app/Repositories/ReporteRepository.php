<?php

namespace App\Repositories;

use App\Interfaces\ReporteRepositoryInterface;
use App\Models\solicitud\BitacoraTemporal;
use App\Models\solicitud\Temporal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReporteRepository implements ReporteRepositoryInterface
{
    public function getReporte($id): array
    {
        $temp = Temporal::select('catalogo_vehiculo.numero_motor', 'catalogo_vehiculo.color', 'catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo', 'catalogo_vehiculo.tipo', 'catalogo_vehiculo.placas', 'catalogo_vehiculo.numero_serie', 'temporal.numero_factura_compra', 'temporal.id AS id', 'temporal.total_km_recorridos', 'temporal.litros_totales', 'temporal.importe_total', 'catalogo_vehiculo.km_inicial', 'catalogo_vehiculo.km_final', 'catalogo_vehiculo.rendimiento_ciudad', 'catalogo_vehiculo.rendimiento_carretera', 'catalogo_vehiculo.rendimiento_mixto', 'catalogo_vehiculo.rendimiento_carga', 'resguardante.resguardante_unidad', 'resguardante.puesto_resguardante_unidad', 'catalogo_vehiculo.numero_economico', 'temporal.conductor', 'temporal.comentario')
            ->join('catalogo_vehiculo', 'temporal.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
            ->join('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')
            ->where('temporal.id', $id)
            ->first();

        $recorrido = BitacoraTemporal::where('solicitud_id', $temp->id)->get();
        return ['temporal' => $temp, 'recorrido' => $recorrido];
    }
}
