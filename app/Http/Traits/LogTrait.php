<?php

namespace App\Http\Traits;
use App\Models\solicitud\Log;

trait LogTrait {

    protected function storeLog($request){
        $log = new Log();
        $log->operacion = $request['operacion'];
        $log->usuario = $request['usuario'];
        $log->ip_request = $request['ip_request'];
        $log->mac_request = '';
        $log->sistem_path = $request['sistem_path'];
        $log->fecha_ejecucion = $request['fecha_ejecucion'];
        $log->hoarario_ejecucion = $request['hoarario_ejecucion'];
        switch ($request['tipo_interaccion']) {
            case 4:
                # si vamos a guardar algo nos traemos el dato de operanción
                $arreglo = $request['httpRequest'];
                break;
            
            default:
                # otro componente
                $arreglo = implode(" ",$request);
                break;
        }
        $log->tipo_interaccion = $request['tipo_interaccion'];
        $log->tipo_peticion = $request['tipo_peticion'];
        $log->contenido = $arreglo;
        $log->save();
        return "VALIDO";
    }
}