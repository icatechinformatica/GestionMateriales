<?php
namespace App\Http\Traits;
use App\Models\solicitud\PreComision;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait UploadFileTrait {
    protected function uploadFile($requestFile, $requestId, $name='factura'){
        // nombre del archivo
        $fileName = $name.'_'.$requestId.'_'.time().'.'.$requestFile->getClientOriginalExtension();
        //mover el archivo a publico de store
        $requestFile->storeAs('facturas/'.$requestId, $fileName);
        //obtener el documento URL
        $requestDocument =  Storage::disk('local')->get('facturas/'.id."/".$fileName);
        return $requestDocument; // regresamos el documento si se guardo correctamente

    }
}
