<?php

namespace App\Http\Traits;
use App\Models\solicitud\PuntoAPunto;
use Illuminate\Support\Str;

trait PuntoAPuntoTrait {
    public function savePuntoAPunto($precomision, $puntoApunto) {
        // Fetch all the students from the 'choferes' table.
        foreach ($puntoApunto as $key => $value) {
            # code...
            $insert_punto_punto = new PuntoAPunto();
            $insert_punto_punto->_de = Str::upper($value['de']);
            $insert_punto_punto->_a = Str::upper($value['a']);
            $insert_punto_punto->kms = $value['kms'];
            $insert_punto_punto->peaje = $value['peaje'];
            $insert_punto_punto->pre_comision_id  = $precomision;
            /**
             * guardar registro
             */
            $insert_punto_punto->save();
        }
            return 'VALIDO';
    }

}