<?php

namespace App\Http\Traits;
use App\Models\solicitud\Chofer;
use Illuminate\Support\Str;

trait ChoferTrait {
    public function savechofer($request) {
        // Fetch all the students from the 'choferes' table.
       
            $insert_chofer = new Chofer();
            $insert_chofer->nombre = $request->get('nombre');
            $insert_chofer->save();
            return 'VALIDO';
    }

    public function getChofer()
    {
        return  Chofer::select('nombre', 'id')->orderBy('id','DESC')->get();
    }

    public function getchoferbyId($id)
    {
        return Chofer::select('nombre', 'id')->where('id', $id)->first();
    }

    protected function updateChofer($id, $request)
    {
        $actualiza_chofer = Chofer::findOrFail($id);
        $actualiza_chofer->nombre = Str::upper($request->get('nombre_editar'));
        $actualiza_chofer->save();

        return true;
    }
}