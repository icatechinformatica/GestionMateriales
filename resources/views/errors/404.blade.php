{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Página no encontrada | ICATECH')

@section('contenidoCss')
 <style>
    .custom-file-label::after { content: "Seleccionar";}
 </style>
@endsection

@section('contenido')



{{-- Content Row --}}
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- 404 Error Text -->
        <div class="text-center">
            <div class="error mx-auto" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">Página no encontrada</p>
            <p class="text-gray-500 mb-0">Parece que la página que buscas no se encuentra en el sistema ...</p>
            <a href="index.html">&larr; Regresar al Inicio</a>
        </div>

    </div>
    <!-- /.container-fluid -->
{{-- Content Row END --}}


@endsection

@section('contenidoJavaScript')
    
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
