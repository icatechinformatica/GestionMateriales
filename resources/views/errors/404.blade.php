{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('errors.error_layout')

@section('contenidoCss')
 <style>
    .custom-file-label::after { content: "Seleccionar";}
 </style>
@endsection

@section('contenido')



{{-- Content Row --}}
    <!-- Begin Page Content -->
    <h1>404</h1>
    <div>
        <p>> <span>CODIGO DE ERROR</span>: "<i>HTTP 404 Página no encontrada</i>"</p>
        <p>> <span>DESCRIPCIÓN DEL ERROR</span>: "<i> No se ha encontrado esta página en el sitio</i>"</p>
        <p>> <span>POSIBLE ERROR CAUSADO POR</span>: [<b>No se ha encontrado la página que se busca o hace referencia en el sistema.</b>...]</p>
        <p>> <span>REGRESO AL TABLERO PRINCIPAL DEL SISTEMA</span>: [<a href="{{ route('dashboard') }}">Página de Inicio</a> ...]</p>
    </div>
    <!-- /.container-fluid -->
{{-- Content Row END --}}


@endsection

@section('contenidoJavaScript')
    
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
