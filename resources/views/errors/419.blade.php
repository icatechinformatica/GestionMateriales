@extends('errors.errores')

@section('code', '419')
@section('title', __('Sesión Expirada'))

@section('image')
    <div style="background-image: url({{ asset('assets/svg/419.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('Lo sentimos, su sesión ha expirado. Por favor, actualice y pruebe de nuevo.'))
