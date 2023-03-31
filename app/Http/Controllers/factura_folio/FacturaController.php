<?php

namespace App\Http\Controllers\factura_folio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\factura_folio\Factura;
use App\Traits\UploadFileTrait;

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
        $validador = $request->validate([
            'fileup' => 'required|mimes:pdf|max:2048',
            'cliente' => 'required',
            'concepto' => 'required',
            'folio_serie' => 'required',
            'subtotal' => 'required|numeric|between:0,1000000.99',
            'impuesto_trasladados' => 'required|numeric|between:0,1000000.99',
            'total' => 'required|numeric|between:0,1000000.99'
        ],[
            'fileup.required' => 'El archivo es requerido',
            'fileup.mimes' => 'Sólo se aceptan archivos en formato pdf',
            'fileup.max' => 'Tamaño máximo de 4 MB',
            'cliente.required' => 'El cliente es requerido',
            'concepto.required' => 'El concepto es requerido',
            'folio_serie.required' => 'El folio/Serie es requerido',
            'subtotal.required' => 'Subtotal es requerido',
            'subtotal.numeric' => 'Subtotal debe ser númerico',
            'impuesto_trasladados.required' => 'Impuesto de traslado requerido',
            'impuesto_trasladados.numeric' => 'Impuesto de traslado debe ser númerico',
            'total.required' => 'El total es requerido',
            'total.numeric' => 'toal es númerico'
        ]);

        try {
            //se realiza el guardado de datos
        } catch (\Throwable $th) {
            //throw $th;
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
}
