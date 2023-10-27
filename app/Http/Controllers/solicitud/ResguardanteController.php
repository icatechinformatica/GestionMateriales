<?php

namespace App\Http\Controllers\solicitud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\solicitud\Resguardante;
use App\Http\Traits\ResguardanteTrait;
use Illuminate\Database\QueryException;
use App\Http\Traits\LogTrait;

class ResguardanteController extends Controller
{
    use ResguardanteTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $get_resguardantes = $this->getResguardante();
        return view('theme.dashboard.layouts.index_cat_resguardante', compact('get_resguardantes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('theme.dashboard.forms.form_resguardante');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // storeResguardante
        //
        $request->validate([
            // 'memo_comision' => 'required|max:255',
            // 'fecha' => 'date',
            'resguardante' => 'required',
            'puesto' => 'required',

        ], [
            // 'memo_comision.required' => 'El memo de comisión es requerido',
            // 'fecha.date' => 'Se requiere una fecha valida',
            'resguardante.required' => 'El resguardante es requerido',
            'puesto.required' => 'El Puesto es requerido',
        ]);
        try {
            //enviar en un trait a cargar los datos
            switch ($this->storeResguardante($request)) {
                case 'VALIDO':
                    # direccionamos y mandamos un mensaje de éxito
                    return redirect()->route('solicitud.resguardante.indice')->with('success', sprintf('¡REGISTRO AGREGADO EXÍTOSAMENTE!'));
                    break;
                default:
                    # code...
                    break;
            }

            # si es verdadero tenemos que enviarlo al index del catálogo
        } catch (QueryException $th) {
            //cachando excepcion y retornando a la vista
            return back()->with('error', $th->getMessage());
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        //
        $idresguardante = base64_decode($id);
        $resguardante = $this->resguardanteById($idresguardante);
        return view('theme.dashboard.forms.form_resguardante_editar', compact('resguardante'));
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
        $request->validate([
            'resguardante_editar' => 'required',
            'puesto_editar' => 'required'
        ], [
            'resguardante_editar.required' => 'EL NOMBRE ES REQUERIDO',
            'puesto_editar.required' => 'EL PUESTO ES REQUERIDO'
        ]);

        try {
            // actualizar registros a partiir de un id con la petición
            $idResguard =  base64_decode($id);
            $update_resguardante = $this->editResguardante($idResguard, $request);
            if ($update_resguardante == true) {
                # si es verdadero vamos a enviar
                return redirect()->route('solicitud.resguardante.indice')->with('success', sprintf('¡REGISTRO ACTUALIZADO EXÍTOSAMENTE!'));
            }
        } catch (QueryException $r) {
            //lanzar excepcion de sql
            return back()->with('error', $r->getMessage());
        }
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

    public function searchResguardante(Request $resq)
    {
        $resguardanteSearch  = $this->SearchRes($resq);
        return response()->json($resguardanteSearch);
    }

    public function loadData(Request $request)
    {
        $datos = $this->loadDataBase($request);
        return response()->json($datos);
    }
}
