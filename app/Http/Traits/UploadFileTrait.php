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
        //obtenemos el path
        $path = storage_path('app/facturas/'.$requestId."/".$fileName);
        // checamos si exite el archivo que estoy retornando
        if (!\File::exists($path)) {
            # si no existe retornamos un false
            $requestDocument = NULL;
        } else {
            //obtener el documento URL
            # si existe el archivo retornamos la url
            $requestDocument = 'facturas/'.$requestId."/".$fileName;
            // Storage::url('facturas/'.$requestId."/".$fileName);
        }

        return $requestDocument; // regresamos el documento si se guardo correctamente

    }
}
