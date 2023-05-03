{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Formulario Resguardante | SISCOM by ICATECH')

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
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-shield"></i> Resguardante</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('solicitud.resguardante.store') }}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="resguardante">Resguardante</label>
                                    <div class="custom-file">
                                        <input type="text" name="resguardante" id="resguardante" class="@error('resguardante') is-invalid @enderror form-control">
                                        @error('resguardante')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="puesto">Puesto</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="puesto" name="puesto" autocomplete="off">
                                        @error('puesto')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-save"></i>
                                Guardar
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
