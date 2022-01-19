{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Formulario de Vehiculos | SISCOM by ICATECH')

@section('contenidoCss')
 <style>
    .custom-file-label::after { content: "Seleccionar";}
    table {
        border: 1px solid #ccc;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
    }

    table caption {
        font-size: 1.5em;
        margin: .5em 0 .75em;
    }

    table tr {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        padding: .35em;
    }

    table th,
    table td {
        padding: .625em;
        text-align: center;
    }

    table th {
        font-size: .70em;
        letter-spacing: .09em;
        text-transform: uppercase;
    }
    /*
    * square buttons effects
    */
    .btn-squared-default
    {
        width: 100px !important;
        height: 100px !important;
        font-size: 10px;
    }

    .btn-squared-default:hover
    {
        border: 3px solid white;
        font-weight: 700;
    }

    .btn-squared-default-plain
    {
        width: 100px !important;
        height: 100px !important;
        font-size: 10px;
    }

    .btn-squared-default-plain:hover
    {
        border: 0px solid white;
    }

    @media screen and (max-width: 600px) {
        table {
                border: 0;
        }

        table caption {
                font-size: 1.3em;
        }
            
        table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
            
        table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }
            
        table td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
        }
            
        table td::before {
            /*
            * aria-label has no advantage, it won't be read inside a table
            content: attr(aria-label);
            */
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }
            
        table td:last-child {
            border-bottom: 0;
        }
    }
 </style>
@endsection

@section('contenido')



{{-- Content Row --}}
    <div class="row">
        {{-- Columna de contenido --}}
            <div class="col-lg-12 mb-4">
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ $message }}
                    </div>
                @endif
                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-car"></i> VEHICULO CON PLACAS - {{ $getvehiculo->placas }}</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('solicitud.cat.automovil.update', base64_encode($getvehiculo->id)) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="marca_editar">Marca</label>
                                    <div class="custom-file">
                                        <input type="text" name="marca_editar" id="marca_editar" class="@error('marca_editar') is-invalid @enderror form-control" autocomplete="off" value="{{ $getvehiculo->marca }}">
                                        @error('marca_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="modelo_editar">Modelo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="modelo_editar" name="modelo_editar" autocomplete="off" value="{{ $getvehiculo->modelo }}">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="placas_editar">Placas</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('placas_editar') is-invalid @enderror typeahead form-control" id="placas_editar" name="placas_editar" autocomplete="off" value="{{ $getvehiculo->placas }}">
                                        @error('placas_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="color_editar">Color</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('color_editar') is-invalid @enderror typeahead form-control" id="color_editar" name="color_editar" autocomplete="off" value="{{ $getvehiculo->color }}">
                                        @error('color_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="numero_motor_editar">Número Motor</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('numero_motor_editar') is-invalid @enderror typeahead form-control" id="numero_motor_editar" name="numero_motor_editar" autocomplete="off" value="{{ $getvehiculo->numero_motor }}">
                                        @error('numero_motor_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tipo_editar">Tipo</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('tipo_editar') is-invalid @enderror typeahead form-control" id="tipo_editar" name="tipo_editar" autocomplete="off" value="{{ $getvehiculo->tipo }}">
                                        @error('tipo_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="numero_serie_editar">Número de Serie</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('numero_serie_editar') is-invalid @enderror typeahead form-control" id="numero_serie_editar" name="numero_serie_editar" autocomplete="off" value="{{ $getvehiculo->numero_serie }}">
                                        @error('numero_serie_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="placas">Resguardante</label>
                                    <div class="custom-file">
                                        <select name="resguardante_editar" id="resguardante_editar" class="@error('resguardante') is-invalid @enderror typeahead form-control">
                                            @foreach ($resguardante as $res => $j)
                                                <option value="{{ $j->id }}" {{ $j->id == $getvehiculo->resguardante_id ? 'selected': '' }}>{{ $j->resguardante_unidad }}</option>
                                            @endforeach
                                        </select>
                                        @error('resguardante_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="numero_economico">Número Económico</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('numero_economico_editar') is-invalid @enderror typeahead form-control" id="numero_economico_editar" name="numero_economico_editar" autocomplete="off" value="{{ $getvehiculo->numero_economico }}">
                                        @error('numero_economico_editar')
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
