@extends('errors.errores')

@section('code', '504')
@section('title', __('Servicio No Disponible'))

@section('image')
    <div style="background-image: url({{ asset('assets/svg/504.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('Lo sentimos, el servidor no respondió en tiempo.'))
