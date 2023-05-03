{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('REQUISICIÓN DE MATERIALES / CATÁLOGO DIRECTORIO / AGREGAR'), 'titlePage' => __('SIRMAT | Formulario Captura Catálogo de Directorio')])

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
                </div> <br>
            @endif
                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-sitemap"></i> DIRECTORIO </h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="nombre_directorio">Nombre</label>
                                    <div class="custom-file">
                                        <input type="text" name="nombre_directorio" id="nombre_directorio" class="@error('nombre_directorio') is-invalid @enderror form-control" autocomplete="off">
                                        @error('nombre_directorio')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="apellido_paterno_directorio">Apellido Paterno</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="apellido_paterno_directorio" name="apellido_paterno_directorio" autocomplete="off">
                                        @error('apellido_paterno_directorio')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="apellido_materno_directorio">Apellido Materno</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="apellido_materno_directorio" name="apellido_materno_directorio" autocomplete="off">
                                        @error('apellido_materno_directorio')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="numero_enlace_directorio">Número de enlace</label>
                                    <div class="custom-file">
                                        <input type="text" name="numero_enlace_directorio" id="numero_enlace_directorio" class="@error('numero_enlace_directorio') is-invalid @enderror form-control" value="" autocomplete="off">
                                        @error('numero_enlace_directorio')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="puesto_directorio">Puesto</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="puesto_directorio" name="puesto_directorio" autocomplete="off" value="">
                                        @error('puesto_directorio')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="categoria_directorio">Categoría</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="categoria_directorio" name="categoria_directorio" autocomplete="off" value="">
                                        @error('categoria_directorio')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="resguardante_editar">Área de adscripción</label>
                                    <div class="custom-file">
                                        <input type="text" name="resguardante_editar" id="resguardante_editar" class="@error('resguardante_editar') is-invalid @enderror form-control" value="" autocomplete="off">
                                        @error('resguardante_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="puesto_editar">Área de adscripción</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="puesto_editar" name="puesto_editar" autocomplete="off" value="">
                                        @error('puesto_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <br>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="activo_directorio" name="activo_directorio">
                                        <label class="custom-control-label" for="activo_directorio">ACTIVO</label>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <button class="btn btn-success" type="submit">
                                <i class="fas fa-user-plus"></i>
                                AGREGAR
                            </button>
                            <input type="hidden" name="periodo_actual" id="periodo_actual" value="">
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
