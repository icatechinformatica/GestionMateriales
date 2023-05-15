@extends('errors.errores')

@section('code', '403 😓')
@section('title', __('Prohibido'))

@section('image')
    <div style="background-image: url({{ asset('assets/svg/403.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('Acceso Denegado. No tiene permiso para acceder a esta página.'))
