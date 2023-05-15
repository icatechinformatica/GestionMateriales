@extends('errors::illustrated-layout')

@section('code', '503')
@section('title', __('Servicio No Disponible'))

@section('image')
    <div style="background-image: url({{ asset('assets/svg/503.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('Lo sentimos, estamos haciendo un poco de mantenimiento. Por favor, revise luego.'))
