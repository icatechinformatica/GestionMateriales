<?php
namespace App\Repositories;

use App\Interfaces\DriverRepositoryInterface;
use App\Models\solicitud\Chofer;
use App\Models\solicitud\Temporal;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class DriverRepository implements DriverRepositoryInterface
{
    public function searchDriver(Request $request): array
    {
        $qry = Chofer::where('nombre', 'LIKE', "%{$request->term}%")->get();
        $chofer = [];
        foreach ($qry as $query)
        {
            $chofer[] = $query->nombre;
        }
        return $chofer;
    }

    public function saveDateBitacora(Request $request){
        try {
            Temporal::where('id', $request->get('idtemporal'))->update([
                'conductor' => $request->get('conductor'),
                'comentario' => $request->get('comentario'), //si es comisión se agrega el campo y vamos a utilizarlo hasta que deje de servinos en las iteracciones de bitácoras
            ]);
            return true;
        } catch (QueryException $th) {
            //throw $th;
            return $th->getMessage();
        }
    }
}
