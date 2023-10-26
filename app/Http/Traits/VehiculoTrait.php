<?php

namespace App\Http\Traits;

use App\Models\solicitud\CatalogoVehiculo;
use Illuminate\Support\Str;

trait VehiculoTrait
{
    public function savecatvehiculo($index)
    {
        // Fetch all the students from the 'student' table.
        /**
         * antes de guardar se debe revisar que el vehículo no se encuentre en la base de datos
         */
        $checkCatVehiculo = CatalogoVehiculo::where([
            ['placas', '=', $index->get('placas')],
            ['numero_serie', '=', $index->get('numero_serie')]
        ])->count();
        if ($checkCatVehiculo > 0) {
            # registro encontrado
            return 'REP';
        } else {
            $vehiculo = new CatalogoVehiculo();
            $vehiculo->color = $index->get('color');
            $vehiculo->numero_motor = $index->get('numero_motor');
            $vehiculo->marca = Str::upper($index->get('marca'));
            $vehiculo->modelo = Str::upper($index->get('modelo'));
            $vehiculo->tipo = Str::upper($index->get('tipo'));
            $vehiculo->placas = Str::upper($index->get('placas'));
            $vehiculo->numero_serie = Str::upper($index->get('numero_serie'));
            $vehiculo->resguardante_id = $index->get('resguardante');
            $vehiculo->numero_economico = Str::upper($index->get('numero_economico'));
            $vehiculo->km_final = $index->get('km_recorrido');
            $vehiculo->rendimiento_ciudad = $index->get('rendimiento_ciudad');
            $vehiculo->rendimiento_carretera = $index->get('rendimiento_carretera');
            $vehiculo->rendimiento_mixto = $index->get('rendimiento_mixto');
            $vehiculo->rendimiento_carga = $index->get('rendimiento_carga');
            $vehiculo->save();
            return 'VALIDO';
        }
    }

    public function getVehiculo()
    {
        return  CatalogoVehiculo::select('color', 'numero_motor', 'marca', 'modelo', 'tipo', 'placas', 'numero_serie', 'linea', 'id', 'numero_economico')->orderBy('id', 'DESC')->get();
    }

    public function editVehiculo($id)
    {
        return CatalogoVehiculo::select(
            'catalogo_vehiculo.id',
            'catalogo_vehiculo.color',
            'catalogo_vehiculo.numero_motor',
            'catalogo_vehiculo.marca',
            'catalogo_vehiculo.modelo',
            'catalogo_vehiculo.tipo',
            'catalogo_vehiculo.placas',
            'catalogo_vehiculo.numero_serie',
            'catalogo_vehiculo.linea',
            'resguardante.resguardante_unidad',
            'catalogo_vehiculo.resguardante_id',
            'catalogo_vehiculo.numero_economico',
            'catalogo_vehiculo.km_final',
            'catalogo_vehiculo.rendimiento_ciudad',
            'catalogo_vehiculo.rendimiento_carretera',
            'catalogo_vehiculo.rendimiento_mixto',
            'catalogo_vehiculo.rendimiento_carga'
        )->where('catalogo_vehiculo.id', '=', $id)->join('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')->first();
    }

    protected function updateVehiculo($id, $request)
    {
        $cat_vehiculo = CatalogoVehiculo::findOrFail($id);
        $cat_vehiculo->marca = Str::upper($request->get('marca_editar'));
        $cat_vehiculo->placas = Str::upper($request->get('placas_editar'));
        $cat_vehiculo->color = Str::upper($request->get('color_editar'));
        $cat_vehiculo->numero_motor = Str::upper($request->get('numero_motor_editar'));
        $cat_vehiculo->numero_serie = Str::upper($request->get('numero_serie_editar'));
        $cat_vehiculo->resguardante_id = $request->get('resguardante_editar');
        $cat_vehiculo->modelo = Str::upper($request->get('modelo_editar'));
        $cat_vehiculo->numero_economico = Str::upper($request->get('numero_economico_editar'));
        $cat_vehiculo->km_final = $request->get('km_recorrido_editar');
        $cat_vehiculo->rendimiento_ciudad = $request->get('rendimiento_ciudad');
        $cat_vehiculo->rendimiento_carretera = $request->get('rendimiento_carretera');
        $cat_vehiculo->rendimiento_mixto = $request->get('rendimiento_mixto');
        $cat_vehiculo->rendimiento_carga = $request->get('rendimiento_carga');
        $cat_vehiculo->save();

        return true;
    }
}
