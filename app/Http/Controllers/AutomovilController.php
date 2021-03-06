<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\VehiculoTrait;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;
use App\Http\Traits\ResguardanteTrait;

class AutomovilController extends Controller
{
    use VehiculoTrait, ResguardanteTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $catalogo = $this->getVehiculo();
        return view('theme.dashboard.layouts.index_cat_automovil', compact('catalogo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('theme.dashboard.forms.form_automovil');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            // 'memo_comision' => 'required|max:255',
            // 'fecha' => 'date',
            'modelo' => 'required|max:70',
            'placas' => 'required',
            'color' => 'required',
            'resguardante' => 'required'

        ],[
            // 'memo_comision.required' => 'El memo de comisión es requerido',
            // 'fecha.date' => 'Se requiere una fecha valida',
            'modelo.required' => 'El modelo es requerido',
            'placas.required' => 'Las placas son requeridas',
            'color.required' => 'El color es requerido',
            'resguardante.required' => 'El resguardante es requerido'
        ]);
        try {
            //enviar en un trait a cargar los datos
            switch ($this->savecatvehiculo($request)) {
                case 'REP':
                    # se encuentra repetido y mandamos un mensaje con el error
                    return Redirect::back()->withErrors('EL REGISTRO DE ESTE VEHÍCULO YA SE ENCUENTRA EN LA BASE DE DATOS');
                    break;
                case 'VALIDO':
                    # direccionamos y mandamos un mensaje de éxito
                    return redirect()->route('alumnos.valid')->with('success', sprintf('¡REGISTRO AGREGADO EXÍTOSAMENTE!'));
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
    public function edit($id)
    {
        //
        $idvehiculo = base64_decode($id);
        $getvehiculo = $this->editVehiculo($idvehiculo);
        $resguardante = $this->getResguardante();
        
        return view('theme.dashboard.forms.form_automovil_edit', compact('getvehiculo', 'resguardante'));
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
        // se valida los campos del formulario antes de realizar la actualización
        $request->validate([
            'marca_editar' => 'required',
            'placas_editar' => 'required',
            'color_editar' => 'required',
            'numero_motor_editar' => 'required',
            'tipo_editar' => 'required',
            'numero_serie_editar' => 'required',
            'resguardante_editar' => 'required',
            'numero_economico_editar' => 'required'
        ],[
            'marca_editar.required' => 'LA MARCA ES REQUERIDA',
            'placas_editar.required' => 'LA PLACA ES REQUERIDA',
            'color_editar.required' => 'EL COLOR ES REQUERIDO',
            'numero_motor_editar.required' => 'EL NÚMERO DE MOTOR ES REQUERIDO',
            'tipo_editar.required' => 'EL TIPO ES REQUERIDO',
            'numero_serie_editar.required' => 'EL NÚMERO DE SERIE ES REQUERIDO',
            'resguardante_editar.requiered' => 'EL RESGUARDANTE ES REQUERIDO',
            'numero_economico_editar' => 'El NÚMERO ECONÓMICO ES REQUERIDO'
        ]);

        try {
            // actualizar registros a partiir de un id con la petición
           $idvehiculo =  base64_decode($id);
           $update_vehiculo = $this->updateVehiculo($idvehiculo, $request);
           if ($update_vehiculo == true) {
               # si es verdadero vamos a enviar 
               return redirect()->route('solicitud.cat.indice')->with('success', sprintf('¡REGISTRO ACTUALIZADO EXÍTOSAMENTE!'));
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
}
