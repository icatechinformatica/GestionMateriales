{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Modificación de Chofer | SISCOM by ICATECH')

@section('contenidoCss')
    <link href="{{ asset('css/generalStyles.css') }}" rel="stylesheet">
@endsection

@section('contenido')



{{-- Content Row --}}
    <div class="row">
        {{-- Columna de contenido --}}
            <div class="col-lg-12 mb-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br>
            @endif
                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-id-card-alt"></i> MODIFICAR CHOFER - {{ $choferes->nombre }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('cat.choferes.update', base64_encode($choferes->id)) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="col-md-8 mb-3">
                                    <label for="nombre_editar">Nombre Completo</label>
                                    <div class="custom-file">
                                        <input type="text" name="nombre_editar" id="nombre_editar" class="@error('nombre_editar') is-invalid @enderror form-control" autocomplete="off" value="{{ $choferes->nombre }}">
                                        @error('nombre_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <button class="btn btn-warning" type="submit">
                                <i class="fas fa-edit"></i>
                                MODIFICAR
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        {{-- Columna de contenido END --}}

    </div>
{{-- Content Row END --}}


@endsection

@section('contenidoJavaScript')

@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
