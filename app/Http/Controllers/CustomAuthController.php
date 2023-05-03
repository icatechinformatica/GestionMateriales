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
        return view('auth.login');
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
            // $MAC = exec('getmac');
            // $MAC = strtok($MAC, ' ');
            $tipo_peticion = 'POST';
            $path = '/login';
            $peticion = ['operacion' => 'Inicio de Sesion', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 1, 'tipo_peticion' => $tipo_peticion];
            $this->storeLog($peticion);
            return redirect()->route('dashboard')
                        ->withSuccess('Sesión Iniciada.');
        }

        return redirect("login")->withSuccess('Los datos de inicio de sesión no son válidos');
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

        return redirect("login")->withSuccess('No tienes permiso para acceder');
    }

    public function singout(Request $request)
    {
        /**
         * enviamos los parametros al trait log para guardar los datos del registro contenido
         */
        $fecha = Carbon::now()->format('Y-m-d');
        $hora = Carbon::now()->format('H:i:s');
        // $MAC = exec('getmac');
        // $MAC = strtok($MAC, ' ');
        $tipo_peticion = 'GET';
        $path = '/logout';
        $peticion = ['operacion' => 'Cerrar sesión', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 5, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);
        Session::flush();
        Auth::logout();

        return redirect()->route('dashboard');
    }


    protected function register()
    {
        return view('auth._register');
    }

    protected function customRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'required',
        ],[
            'name.required' => 'El nombre es requerido',
            'email.required' => 'Correo electrónico es requerido',
            'email.unique' => 'Correo electrónico debe de ser único, ya se encuentra registrado',
            'password.required' => 'la contraseña es requerida'
        ]);

        /**
         * se crea el usuario
         */

        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        return redirect("login")->withSuccess('El Usuario se ha creado correctamente');
    }
}
