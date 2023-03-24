<?php

namespace App\Http\Controllers\cat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\catalogos\Directorio;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use App\Http\Traits\LogTrait;

class DirectorioController extends Controller
{
    use LogTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        /**
         * petición de la solicitud
         */
        $fecha = Carbon::now()->format('Y-m-d');
        $hora = Carbon::now()->format('H:i:s');
        // $MAC = exec('getmac');
        // $MAC = strtok($MAC, ' ');
        $tipo_peticion = 'GET';
        $path = '/solicitud/catalogo/directorio/index';
        $peticion = ['operacion' => 'Inicio del indice del catálogo del directorio institucional', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 2, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);

        /**
         * crear un buscador
         */
        if ($request->filled('busqueda')) {
            # busqueda
            // directorio
            dd(strtoupper($request->busqueda));
            $getDirectorio = Directorio::search($request->busqueda)->get();
        } else {
            // directorio
            $getDirectorio = Directorio::where('activo', true)->get();
        }


        return view('theme.dashboard.layouts.cat.index_directorio', compact('getDirectorio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // enviar al sitio de creación
        return view('theme.dashboard.layouts.cat.form_directorio');
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
