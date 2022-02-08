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
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-car"></i> Vehiculo</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('solicitud.catalogo.store') }}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="fecha">Marca</label>
                                    <div class="custom-file">
                                        <input type="text" name="marca" id="marca" class="@error('marca') is-invalid @enderror form-control">
                                        @error('marca')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="periodo">Modelo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="modelo" name="modelo" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="placas">Placas</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('placas') is-invalid @enderror typeahead form-control" id="placas" name="placas" autocomplete="off">
                                        @error('placas')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="placas">Color</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('color') is-invalid @enderror typeahead form-control" id="color" name="color" autocomplete="off">
                                        @error('color')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="placas">Número Motor</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('numero_motor') is-invalid @enderror typeahead form-control" id="numero_motor" name="numero_motor" autocomplete="off">
                                        @error('numero_motor')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="placas">Tipo</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('tipo') is-invalid @enderror typeahead form-control" id="tipo" name="tipo" autocomplete="off">
                                        @error('tipo')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="placas">Número de Serie</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('numero_serie') is-invalid @enderror typeahead form-control" id="numero_serie" name="numero_serie" autocomplete="off">
                                        @error('numero_serie')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="placas">Resguardante</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('resguardante') is-invalid @enderror typeahead form-control" id="resguardante" name="resguardante" autocomplete="off">
                                        @error('resguardante')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="numero_economico">Número Económico</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('numero_economico') is-invalid @enderror typeahead form-control" id="numero_economico" name="numero_economico" autocomplete="off">
                                        @error('numero_economico')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="km_recorrido">Kilometros Recorridos</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('km_recorrido') is-invalid @enderror typeahead form-control" id="km_recorrido" name="km_recorrido" autocomplete="off" onkeypress="return valideKey(event);">
                                        @error('km_recorrido')
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
    <script type="text/javascript">
        function valideKey(evt){
    
            // code is the decimal ASCII representation of the pressed key.
            var code = (evt.which) ? evt.which : evt.keyCode;
            
            if(code==8) { // backspace.
                return true;
            } else if(code>=48 && code<=57) { // is a number.
                return true;
            } else{ // other keys.
                return false;
            }
        }
    </script>
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
