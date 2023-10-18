<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
    public function update(UpdateProfileRequest $request, $id)
    {
        // edición del perfil
        try {

            #concidir con la contraseña anterior
            // if (!Hash::check($request->new_password, $request->password_confirmation)) {
            //     # condicional - si no coinciden
            //     return back()->with('error', '¡La contraseña anterior no coincide!');
            // }

            $idUser = base64_decode($id);

            #Actualizar la nueva contraseña
            User::whereId(
                $idUser
            )->update([
                'name' => Str::upper($request->name)
            ]);

            // redireccionar
            return back()->with('success', 'Datos del Usuario Actualizado!');
        } catch (QueryException $q) {
            //cachando excepcion y retornando a la vista
            return back()->with('error', $q->getMessage());
        }
    }

    public function update_password(UpdatePasswordRequest $req, $id)
    {
        try {
            $idUser = base64_decode($id);

            #Actualizar la nueva contraseña
            User::whereId(
                $idUser
            )->update([
                'password' => Hash::make($req->password)
            ]);

            // redireccionar
            return back()->with('success', 'Contraseña Actualizada!');
        } catch (QueryException $th) {
            //throw $th;
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
