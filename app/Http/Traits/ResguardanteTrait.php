<?php

namespace App\Http\Traits;
use App\Models\solicitud\Resguardante;
use Illuminate\Support\Str;

trait ResguardanteTrait {

    public function getResguardante()
    {
        return  Resguardante::select('resguardante_unidad', 'puesto_resguardante_unidad', 'area_adscripcion_id', 'id')->orderBy('id','DESC')->get();
    }

    protected function storeResguardante($request){
        $resguardante = new Resguardante();
        $resguardante->resguardante_unidad = $request->get('resguardante');
        $resguardante->puesto_resguardante_unidad = $request->get('puesto');
        $resguardante->save();
        return "VALIDO";
    }

    protected function editResguardante($id, $request)
    {
        $actualiza_resguardante = Resguardante::findOrFail($id);
        $actualiza_resguardante->resguardante_unidad = Str::upper($request->get('resguardante_editar'));
        $actualiza_resguardante->puesto_resguardante_unidad = Str::upper($request->get('puesto_editar'));
        $actualiza_resguardante->save();

        return true;
    }

    protected function resguardanteById($id){
        return Resguardante::select('resguardante_unidad', 'puesto_resguardante_unidad', 'area_adscripcion_id', 'id')->where('id', '=', $id)->first();
    }
}