{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('errors.errores')

@section('code', '404 👻')
@section('title', __('Página no encontrada'))

@section('image')
    <div style="background-image: url({{ asset('assets/svg/404.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('Lo sentimos, la página que está buscando no se pudo encontrar.'))
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
