<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogoVehiculoRequest;
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
            'resguardante' => 'required',
            'rendimiento_ciudad' => 'required',
            'rendimiento_carretera' => 'required',
            'rendimiento_mixto' => 'required',
            'rendimiento_carga' => 'required'

        ],[
            // 'memo_comision.required' => 'El memo de comisión es requerido',
            // 'fecha.date' => 'Se requiere una fecha valida',
            'modelo.required' => 'El modelo es requerido',
            'placas.required' => 'Las placas son requeridas',
            'color.required' => 'El color es requerido',
            'resguardante.required' => 'El resguardante es requerido',
            'rendimiento_ciudad.required' => 'El rendimiento de la ciudad es requerido',
            'rendimiento_carretera.required' => 'El rendimiento de carretera es requerido',
            'rendimiento_mixto.required' => 'El rendimiento mixto es requerido',
            'rendimiento_carga.required' => 'El rendimiento carga es requerido'
        ]);
        try {
            //enviar en un trait a cargar los datos
            switch ($this->savecatvehiculo($request)) {
                case 'REP':
                    # se encuentra repetido y mandamos un mensaje con el error
                    return redirect()->back()->withErrors('EL REGISTRO DE ESTE VEHÍCULO YA SE ENCUENTRA EN LA BASE DE DATOS');
                    break;
                case 'VALIDO':
                    # direccionamos y mandamos un mensaje de éxito
                    return redirect()->route('solicitud.cat.indice')->with('success', sprintf('¡VEHÍCULO AGREGADO EXÍTOSAMENTE!'));
                    break;
                default:
                    # code...
                    break;
            }

                # si es verdadero tenemos que enviarlo al index del catálogo

        } catch (QueryException $th) {
            //cachando excepcion y retornando a la vista
            return redirect()->back()->withErrors($th->getMessage());
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
    public function update(CatalogoVehiculoRequest $request, $id)
    {

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
