@extends('layouts.newapp')

@section('content')
<form class="login100-form validate-form" action="{{ route('login.custom') }}" method="post">
    {{ method_field('POST') }}
    @csrf
    <span class="login100-form-title">
        SISTEMA INTEGRAL DE RECURSOS MATERIALES (SIRMAT)
    </span>
   {{-- mensaje del sistema --}}
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ $message }}
        </div>
    @endif
   {{-- mensaje del sistema END --}}
    <div class="wrap-input100 validate-input" data-validate = "correo válido requerido: ex@abc.xyz">
        <input class="input100" type="text" name="email" placeholder="Correo electrónico" autocomplete="off">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-envelope" aria-hidden="true"></i>
        </span>
    </div>
    @error('email')
        <div class="alert alert-danger mt-1 mb-1">
            {{ $message }}
        </div>
    @enderror

    <div class="wrap-input100 validate-input" data-validate = "La Contraseña es requerida">
        <input class="input100" type="password" name="password" placeholder="Contraseña">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </span>
    </div>
    @error('password')
        <div class="alert alert-danger mt-1 mb-1">
            {{ $message }}
        </div>
    @enderror

    <div class="container-login100-form-btn">
        <button class="login100-form-btn">
            Iniciar Sesión
        </button>
    </div>

    <div class="text-center p-t-12">
        <span class="txt1">
            {{-- Forgot --}}
        </span>
        <a class="txt2" href="#">
            {{-- Username / Password? --}}
        </a>
    </div>

    {{-- <div class="text-center p-t-136">
        <a class="txt2" href="#">
            Create your Account
            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
        </a>
    </div> --}}
</form>
@endsection
