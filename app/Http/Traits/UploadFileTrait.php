<?php
namespace App\Http\Traits;
use App\Models\solicitud\PreComision;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

trait UploadFileTrait {
    protected function uploadFile($requestFile, $requestId, $name='factura'){
        // nombre del archivo
        $fileName = $name.'_'.time().'.'.$requestFile->getClientOriginalExtension();
        //mover el archivo a publico de store
        $requestFile->storeAs('facturas', $fileName);
        //obtener el documento URL

    }
}
