@extends('errors.errores')

@section('code', '401 😓')
@section('title', __('No autorizado'))

@section('image')
    <div style="background-image: url({{ asset('assets/svg/401.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('Lo sentimos, no está autorizado para acceder a esta página.'))
