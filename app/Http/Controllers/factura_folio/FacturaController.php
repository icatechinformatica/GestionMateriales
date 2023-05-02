<?php

namespace App\Http\Controllers\factura_folio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\factura_folio\Factura;
use App\Http\Traits\UploadFileTrait;
use Illuminate\Database\QueryException;

class FacturaController extends Controller
{
    use UploadFileTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * obtenemos todas las facturas con un poco con paginación
         */
        $factura = Factura::paginate(
            $perPage = 15, $columns = ['*'], $pageName = 'factura'
        );
        // regreso a la vista
        return view('theme.dashboard.layouts.facturas_folio.indexfolio', compact('factura'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // retornamos una vista del formulario
        return view('theme.dashboard.layouts.facturas_folio.Forms.frmaddfacturas');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // guardar los registros
        /**
         * validar inputs antes de guardar el registro
         */
        // $validador = $request->validate([
        //     'fileup' => 'required|mimes:pdf|max:2048',
        //     'cliente' => 'required',
        //     'concepto' => 'required',
        //     'folio_serie' => 'required',
        //     'subtotal' => 'required|numeric|between:0,1000000.99',
        //     'impuesto_trasladados' => 'required|numeric|between:0,1000000.99',
        //     'total' => 'required|numeric|between:0,1000000.99'
        // ],[
        //     'fileup.required' => 'El archivo es requerido',
        //     'fileup.mimes' => 'Sólo se aceptan archivos en formato pdf',
        //     'fileup.max' => 'Tamaño máximo de 4 MB',
        //     'cliente.required' => 'El cliente es requerido',
        //     'concepto.required' => 'El concepto es requerido',
        //     'folio_serie.required' => 'El folio/Serie es requerido',
        //     'subtotal.required' => 'Subtotal es requerido',
        //     'subtotal.numeric' => 'Subtotal debe ser númerico',
        //     'impuesto_trasladados.required' => 'Impuesto de traslado requerido',
        //     'impuesto_trasladados.numeric' => 'Impuesto de traslado debe ser númerico',
        //     'total.required' => 'El total es requerido',
        //     'total.numeric' => 'toal es númerico'
        // ]);

        try {
            //se realiza el guardado de datos
            $nuevaFactura = new Factura;
            $nuevaFactura->concepto = trim(strtoupper($request->concepto));
            $nuevaFactura->subtotal = trim($request->subtotal);
            $nuevaFactura->cliente = trim(strtoupper($request->cliente));
            $nuevaFactura->serie = trim(strtoupper($request->folio_serie));
            $nuevaFactura->impuestos_trasladados = trim($request->impuesto_trasladados);
            $nuevaFactura->total = trim($request->total);
            $nuevaFactura->save(); // se guardan los registros

            /**
             * obtener el último ID
             */
            $lastId = $nuevaFactura->id;

            if ($request->hasFile('fileup')) {
                # si hay archivo se agrega el registro a la base de datos y contenido también a la carpeta
                $file = $request->file('fileup');
                $returnImage = $this->uploadFile($file, $lastId);
                // creamos un arreglo
                $arrFactura = [
                    'archivo' => $returnImage
                ];
                // vamos a actualizar el registro con el arreglo que trae diferentes variables y carga de archivos
                Factura::WHERE('id', $lastId)->update($arrFactura);
                //limpiarmos el arreglo
                unset($arrFactura);
            }
            // retornaremos una llamada json porque no necesito un retornar una vista
            $doneArray = [
                'success' => true,
                'message' => 'Factura Agregada Exitosamente!',
                'data' => 'OK'
            ];
            return response()->json($doneArray, 200);
        } catch (QueryException $th) {
            //throw $th;
            $errorArray = [
                'Error' => $th->getMessage(),
            ];
            return response()->json($errorArray, 401);
        }
        echo "done";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getFile($filename)
    {
        $files = Factura::WHERE('id', $filename)->first();
        $filepath = $files->archivo;
        if (!\File::exists(storage_path('app/'.$filepath))) {
            # checndo si el archivo éxiste
            abort(404); // si no hay abortamos
        }
        $file = \File::get($files->archivo);
        $type = \File::mimetype($files->archivo);
        $response = \Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}