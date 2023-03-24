<?php

namespace App\Http\Controllers\requisicion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\requisicion\Requisicion;
use Illuminate\Database\QueryException;
use App\Models\catalogos\SeguimientoStatus;

class ValidacionRequisicionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $requisicion_por_revisar = Requisicion::with(['memorandum', 'area', 'partidapresupuestal'])->where('id_estado', 1)->orWhere('id_estado', 2)->get();
        return view('theme.dashboard.layouts.requesicion.revision.index', compact('requisicion_por_revisar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * obtenemos la información de la solicitud
         * vamos a actualizar sólo las observaciones y también obtener el id_requisición!!!
         * la variable de observación puede o no tener valores!!!
         * 
         */
        try {
            //parte del código para cargar la información hacer una modificación
            $idRequisicion = base64_decode($request->id_requisicion);
            Requisicion::WHERE('id', $idRequisicion)
            ->update(['id_estado' => 2, 'observaciones' => strtoupper($request->observaciones)]);
            /**
             * redireccionar terminando la actualización
             */
            return redirect()->route('requisicion.revision.index')->with('info', sprintf('¡REQUISICIÓN REVISADA EXITOSAMENTE!'));
        } catch (QueryException $th) {
            //envio de una excepción si hay un error en el MySQL
            return back()->withErrors('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /**
         * mostramos el chequeo de la requisición el cuál sólo tiene observaciones, las cuales se enviaran ya 
         * sea a los usuarios que enviaron a revisión su requisición o al departamento de al que se enviará para la revisión
         * final antes de iniciar el proceso de requisición.
         */
        $idReq = base64_decode($id);
        $id_req = base64_encode($idReq);
        $reqRevision = Requisicion::with(['memorandum', 'area', 'partidapresupuestal', 'partidapresupuestal.requisicionunidad'])->where('id', $idReq)->first();
        return view('theme.dashboard.layouts.requesicion.revision.check_requisicion', compact('reqRevision', 'id_req'));
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

    protected function sendReturn(Request $request)
    {
        // enviar o retornar -- defenir la variable
        $venvio =  $request->get('variable_envio');

        if (isset($venvio)) {
            # code...
            switch ($venvio) {
                case 1:
                    # regresar

                    break;
                case 2:
                    # enviar -- turnado a dirección administrativa
                    try {
                        //enviar.
                        $idRequisicion = base64_decode($request->get('valorRequisicion'));
                        Requisicion::where('id', $idRequisicion)
                        ->update(['id_estado' => 4]); //seguimiento turnado
                        // enviar al indice
                        return redirect()->route('requisicion.index')->with('success', sprintf('¡TURNADO A DIRECCIÓN ADMINISTRATIVA PARA SU SEGUIMIENTO!'));
                    } catch (QueryException $th) {
                        //throw SQL EXCEPTION $th;
                        return back()->with('error', $ex->getMessage());
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }
        
    }
}
