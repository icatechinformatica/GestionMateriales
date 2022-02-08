<?php

namespace App\Http\Controllers\cat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Traits\LogTrait;
use App\Models\solicitud\Chofer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ChoferTrait;

class ChoferController extends Controller
{
    use LogTrait, ChoferTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * petición de la solicitud
         */
        $fecha = Carbon::now()->format('Y-m-d');
        $hora = Carbon::now()->format('H:i:s');
        // $MAC = exec('getmac');
        // $MAC = strtok($MAC, ' ');
        $tipo_peticion = 'GET';
        $path = '/solicitud/catalogo/chofer/index';
        $peticion = ['operacion' => 'Inicio del indice del catálogo del chofer', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 2, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);

        $getAllChoferes = $this->getChofer();

        return view('theme.dashboard.layouts.index_choferes', compact('getAllChoferes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /**
         * petición de la solicitud
         */
        $fecha = Carbon::now()->format('Y-m-d');
        $hora = Carbon::now()->format('H:i:s');
        // $MAC = exec('getmac');
        // $MAC = strtok($MAC, ' ');
        $tipo_peticion = 'GET';
        $path = '/solicitud/catalogo/chofer/create';
        $peticion = ['operacion' => 'Agregar una nueva solicitud de Choferes', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 3, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);

        return view('theme.dashboard.forms.form_choferes');
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
            'nombre' => 'required',
        ],[
            'nombre.required' => 'EL NOMBRE ES REQUERIDO',
        ]);
        try {
            /**
             * petición de la solicitud
             */
            $fecha = Carbon::now()->format('Y-m-d');
            $hora = Carbon::now()->format('H:i:s');
            // $MAC = exec('getmac');
            // $MAC = strtok($MAC, ' ');
            $tipo_peticion = 'POST';
            $path = '/solicitud/store';
            $peticion_parcial =  (array)$request->all();
            $solicitud_total = json_encode($peticion_parcial);
            $peticion = ['operacion' => 'Agregar Un nuevo Chofer', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 4, 'tipo_peticion' => $tipo_peticion, 'httpRequest' => $solicitud_total];
            $this->storeLog($peticion);
            // llamamos al método que nos ejecutará la operación de guardado en el modulo
            $insertar_chofer = $this->savechofer($request);
            if ($insertar_chofer == 'VALIDO') {
                # fue realizado con éxito y enviamos el resultado
                # direccionamos y mandamos un mensaje de éxito
                return redirect()->route('solicitud.cat.chofer')->with('success', sprintf('¡REGISTRO AGREGADO EXÍTOSAMENTE!'));
            }
        } catch (QueryException $th) {
            //cachamos la excepcion y retornamos la vista con el mensaje de error
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
        // obtener el chofer adecuado
        $idchofer = base64_decode($id);
        $choferes = $this->getchoferbyId($idchofer);
        return view('theme.dashboard.forms.form_choferes_edit', compact('choferes'));
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
            'nombre_editar' => 'required',
        ],[
            'nombre_editar.required' => 'EL NOMBRE ES REQUERIDO',
        ]);

        try {
            // actualizar registros a partiir de un id con la petición
           $idChofer =  base64_decode($id);
           $update_chofer = $this->updateChofer($idChofer, $request);
           if ($update_chofer == true) {
               # si es verdadero vamos a enviar 
               return redirect()->route('solicitud.cat.chofer')->with('success', sprintf('¡REGISTRO ACTUALIZADO EXÍTOSAMENTE!'));
           }
        } catch (QueryException $r) {
            //lanzar excepcion de sql 
            return back()->with('error', $th->getMessage());
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
