@extends('layouts.newapp')

@section('content')
<form class="login100-form validate-form" method="POST" action="{{ route('register.custom') }}">
    @csrf
    <span class="login100-form-title">
        REGISTRO AL SISTEMA INTEGRAL DE RECURSOS MATERIALES
    </span>

    <div class="wrap-input100 validate-input" data-validate = "correo válido requerido: ex@abc.xyz">
        <input id="name" type="text" class="input100 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="off" autofocus placeholder="Nombre">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fas fa-signature"></i>
        </span>
    </div>
    @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class="wrap-input100 validate-input" data-validate = "El email es requerido">
        <input id="email" type="email" class="input100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" placeholder="E-mail">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fas fa-at"></i>
        </span>
    </div>
    @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class="wrap-input100 validate-input" data-validate = "La contraseña es requerida">
        <input id="password" type="password" class="input100 @error('password') is-invalid @enderror" name="password" required autocomplete="off" placeholder="Contraseña">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fas fa-key"></i>
        </span>
    </div>
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror

    <div class="wrap-input100 validate-input" data-validate = "confirmar contraseña">
        <input id="password-confirm" type="password" class="input100" name="password_confirmation" required autocomplete="off" placeholder="Confirmar Contraseña">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fas fa-key"></i>
        </span>
    </div>
    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    
    <div class="container-login100-form-btn">
        <button class="login100-form-btn">
            Registrar
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