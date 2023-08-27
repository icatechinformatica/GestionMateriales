{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('errors.errores')

@section('code', 'Error 405 😭')
@section('title', __('Método no Permitido'))

@section('image')
    <div style="background-image: url({{ asset('assets/svg/405.svg') }});" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message', __('Lo sentimos, Este Método no está permitido.'))
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
