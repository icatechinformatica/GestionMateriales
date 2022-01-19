<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\LogTrait;
use Carbon\Carbon;



class CustomAuthController extends Controller
{
    use LogTrait;
    //
    public function index()
    {
        return view('auth._login');
    }

    protected function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => 'Correo electrónico es requerido',
            'password.required' => 'la contraseña es requerida'
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            /**
             * enviamos los parametros al trait log para guardar los datos del registro contenido
             */
            $fecha = Carbon::now()->format('Y-m-d');
            $hora = Carbon::now()->format('H:i:s');
            $MAC = exec('getmac');
            $MAC = strtok($MAC, ' ');
            $tipo_peticion = 'POST';
            $path = '/login';
            $peticion = ['operacion' => 'Inicio de Sesion', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'mac_request' => $MAC, 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 1, 'tipo_peticion' => $tipo_peticion];
            $this->storeLog($peticion);
            return redirect()->route('dashboard')
                        ->withSuccess('Signed in');
        }
  
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

    /**
     * inicio de tablero tras login
     */
    public function dashboard()
    {
        if(Auth::check()){
            return view('theme.dashboard.layouts.index');
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function singout(Request $request)
    {
        /**
         * enviamos los parametros al trait log para guardar los datos del registro contenido
         */
        $fecha = Carbon::now()->format('Y-m-d');
        $hora = Carbon::now()->format('H:i:s');
        $MAC = exec('getmac');
        $MAC = strtok($MAC, ' ');
        $tipo_peticion = 'GET';
        $path = '/logout';
        $peticion = ['operacion' => 'Cerrar sesión', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'mac_request' => $MAC, 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 5, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
