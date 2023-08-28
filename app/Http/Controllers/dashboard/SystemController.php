<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class SystemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //obtenemos el id del usuario
        $idUser = base64_decode($request->idUser);
        return view('theme.dashboard.layouts.caracteristicas.perfil', compact('idUser'));
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
        // edición del perfil
        try {
            //actualización de la contraseña
            $request->validate([
                'name' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required|confirmed'
            ]);

            #concidir con la contraseña anterior
            if (!Hash::check($request->new_password, auth()->user()->password)) {
                # condicional - si no coinciden
                return back()->with('error', '¡La contraseña anterior no coincide!');
            }

            #Actualizar la nueva contraseña
            User::whereId(
                auth()->user()->id
            )->update([
                'password' => Hash::make($request->new_password)
            ]);

            // redireccionar
            return back()->with('status', '¡Contraseña cambiada con éxito!');
        } catch (QueryException $q) {
            //cachando excepcion y retornando a la vista
            return back()->with('error', $q->getMessage());
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
