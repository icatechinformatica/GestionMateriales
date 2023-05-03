{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Formulario de Modificación de Resguardante | SISCOM by ICATECH')

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
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-shield"></i> RESGUARDANTE - {{ $resguardante->resguardante_unidad }}</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('solicitud.resguardante.update', base64_encode( $resguardante->id )) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="resguardante_editar">Resguardante</label>
                                    <div class="custom-file">
                                        <input type="text" name="resguardante_editar" id="resguardante_editar" class="@error('resguardante_editar') is-invalid @enderror form-control" value="{{ $resguardante->resguardante_unidad }}" autocomplete="off">
                                        @error('resguardante_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="puesto_editar">Puesto</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="puesto_editar" name="puesto_editar" autocomplete="off" value="{{ $resguardante->puesto_resguardante_unidad }}">
                                        @error('puesto_editar')
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
