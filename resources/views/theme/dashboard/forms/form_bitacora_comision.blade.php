{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'SOLICITUD BITÁCORA DE RECORRIDO - GUARDADO | SISCOM by ICATECH')

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

    .ui-autocomplete {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        float: left;
        display: none;
        min-width: 160px;
        padding: 4px 0;
        margin: 0 0 10px 25px;
        list-style: none;
        background-color: #ffffff;
        border-color: #ccc;
        border-color: rgba(0, 0, 0, 0.2);
        border-style: solid;
        border-width: 1px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        *border-right-width: 2px;
        *border-bottom-width: 2px;
    }

    .ui-menu-item > a.ui-corner-all {
        display: block;
        padding: 3px 15px;
        clear: both;
        font-weight: normal;
        line-height: 18px;
        color: #555555;
        white-space: nowrap;
        text-decoration: none;
    }

    .ui-state-hover, .ui-state-active {
        color: #ffffff;
        text-decoration: none;
        background-color: #0088cc;
        border-radius: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        background-image: none;
        cursor: pointer;
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
    .error{
	    color: red;
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
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-route"></i> Bitacora de Comisión para el vehiculo {{ $preComision->marca_vehiculo }}</h6>
                    </div>
                    <div class="card-body">
                        <form id="form_bitacora_comision" method="POST" action="{{ route('comision.pre.send.to.request') }}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-8 mb-3">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modelPreComision" data-whatever="@mdo">
                                        <i class="fas fa-info-circle"></i> &nbsp; INFORMACIÓN PRE COMISIÓN
                                    </button>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-8 mb-3">
                                    <label for="memo_comision">MEMORANDUM DE COMISION No.</label>
                                    <div class="custom-file">
                                        <input type="text" name="memo_comision" id="memo_comision" class="@error('memo_comision') is-invalid @enderror form-control" autocomplete="off">
                                        @error('memo_comision')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="fecha_comision">Fecha</label>
                                    <div class="custom-file">
                                        <input type="date" name="fecha_comision" id="fecha_comision" class="@error('fecha_comision') is-invalid @enderror form-control">
                                        @error('fecha_comision')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="periodo_comision">Periodo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="periodo_comision" name="periodo_comision" placeholder="click aquí" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="placas_comision">Placas de Vehiculo</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('placas_comision') is-invalid @enderror typeahead form-control" id="placas_comision" name="placas_comision" placeholder="Placas de Vehiculo" autocomplete="off" value="{{ $catAutomovil->placas }}" readonly />
                                        @error('placas_comision')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="marca_vehiculo">Marca del Vehiculo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control " id="marca_vehiculo" name="marca_vehiculo" placeholder="Marca del Vehiculo"  readonly value="{{ $catAutomovil->marca }}">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="modelo">Modelo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control " id="modelo" name="modelo" placeholder="Modelo"  readonly value="{{ $catAutomovil->modelo }}">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tipo">Tipo de Vehiculo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control " id="tipo" name="tipo" placeholder="Tipo de Vehiculo"  readonly value="{{ $catAutomovil->tipo }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="color">Color</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control " id="color" name="color" placeholder="Color"  readonly value="{{ $catAutomovil->color }}">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="no_serie">N° de Serie</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="no_serie" name="no_serie" placeholder="N° de Serie" readonly value="{{ $catAutomovil->numero_serie }}">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="no_motor">N° de Motor</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('no_motor') is-invalid @enderror form-control " id="no_motor" name="no_motor" placeholder="N° de Motor" readonly value="{{ $catAutomovil->numero_motor }}" >
                                        @error('no_motor')
                                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="placas">Responsable de la Unidad</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="responsableUnidad" name="responsableUnidad" readonly value="{{ $catAutomovil->resguardante_unidad }}">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="placas">Puesto del responsable de la unidad</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="puestoResponsableUnidad" readonly name="puestoResponsableUnidad" readonly value="{{ $catAutomovil->puesto_resguardante_unidad }}">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-8 mb-3">
                                    <label for="placas">Nombre del Conductor</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="nombreConductor" name="nombreConductor" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="kmInicial">Kilometro Inicial</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="kmInicial" name="kmInicial" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kmFinal">Kilometro Final</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="kmFinal" name="kmFinal" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="idcatvehiculo" id="idcatvehiculo" readonly value="{{ $catAutomovil->vehiculoId }}">
                            <hr>
                            {{-- botón de agregar elemento de la bitacora --}}
                            <button type="button" name="addRecorrido" id="addRecorrido" class="btn btn-secondary btn-md">
                                <i class="fas fa-route"></i> <b>Agregar Recorrido</b>
                            </button>
                            <br><br>
                            {{-- botón de agregar elemento de la bitacora END --}}
                            <div class="field_wrapper">
                                <table class="table table-bordered" id="recorridotable">
                                    <thead>
                                      <tr>
                                        <th  style="width: 11%;">Fecha</th>
                                        <th  style="width: 13%;">De:</th>
                                        <th  style="width: 13%;">a: </th>
                                        <th style="width: 13%">Tipo:</th>
                                        <th style="width: 7%;">...</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($punto_a_punto as $k => $i)
                                       <tr>
                                            <td>
                                                <input type="date" name="addcomision[{{ $i->id }}][fecha_comision]" class="form-control"/>
                                            </td>
                                            <td>
                                                <textarea name="addcomision[{{ $i->id }}][de_comision]" class="form-control">{{ $i->_de }}</textarea>
                                            </td>
                                            <td>
                                                <textarea name="addcomision[{{ $i->id }}][a_comision]" class="form-control">{{ $i->_a }}</textarea>
                                            </td>
                                            <td>
                                                <select name="addcomision[{{ $i->id }}][tipo]" class="form-control">
                                                    <option value="">-- SELECCIONAR --</option>
                                                    <option value="RECORRIDO" {{ ($i->tipo == 'RECORRIDO') ? 'selected' : ''}}>RECORRIDO</option>
                                                    <option value="PUNTO_A_PUNTO" {{ ($i->tipo == 'PUNTO_A_PUNTO') ? 'selected' : '' }}>PUNTO A PUNTO</option>
                                                </select>
                                            </td>
                                            <td data-label="...">
                                                <button type="button" class="btn btn-danger btn-circle btn-sm remove-tr">
                                                    <i class="fas fa-minus-circle"></i>
                                                </button>
                                            </td>
                                        <tr>
                                      @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            {{-- botón de agregar elemento de la bitacora --}}
                            <button type="button" name="addItemcomision" id="addItemcomision" class="btn btn-secondary btn-md">
                                <i class="fas fa-file-invoice"></i>
                                <b>Agregar Comisión</b>
                            </button>
                            <button type="button" name="calcularComision" id="calcularComision" class="btn btn-warning btn-md">
                                <i class="fas fa-calculator"></i>
                                Calcular Comisión
                            </button>
                            <br><br>
                            {{-- botón de agregar elemento de la bitacora END --}}
                            <div class="table_wrapper">
                                <table class="table table-bordered" id="comisiontable">
                                    <thead>
                                        <tr>
                                          <th  style="width: 11%;">FACTURA</th>
                                          <th  style="width: 13%;">LITROS</th>
                                          <th  style="width: 13%;">PRECIO UNITARIO</th>
                                          <th style="width: 7%;">IMPORTE</th>
                                          <th style="width: 7%;">...</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="table_wrapper">
                                <table class="table table-bordered" id="totalesDinamicos">
                                    <thead>
                                        <tr>
                                            <th>TOTAL DE KILOMETROS</th>
                                            <th>LITROS TOTALES</th>
                                            <th>PRECIO UNITARIO</th>
                                            <th>IMPORTE TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td data-label="TOTAL DE KILOMETROS">
                                            <input type="text" name="km_totales" id="km_totales"   class="form-control" readonly />
                                        </td>
                                        <td data-label="LITROS TOTALES">
                                            <input type="text" name="litros_totales" id="litros_totales" value="0"  class="form-control" readonly />
                                        </td>
                                        <td data-label="PRECIO UNITARIO" >
                                            <input type="text" name="precio_unitario_total" id="precio_unitario_total" class="form-control" readonly value="0">
                                        </td>
                                        <td data-label="IMPORTE TOTAL">
                                            <input type="text" name="importe_total" id="importe_total" value="0"  class="form-control importe" readonly/>
                                        </td>
                                      </tr>
                                    </tbody>
                                </table>
                            </div>
                            {{-- comentarios --}}
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="placas">OBSERVACIONES</label>
                                    <div class="custom-file">
                                        <textarea name="observaciones" id="observaciones" cols="30" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            {{-- comentarios END --}}
                            <hr>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-archive"></i>
                                Archivar
                            </button>
                            <input type="hidden" name="periodo_comision_actual" id="periodo_comision_actual"/>
                            <input type="hidden" name="pre_comision_id" id="pre_comision_id" value="{{ base64_encode($preComision->id) }}">
                           @switch($preComision->rendimiento)
                               @case('RENDIMIENTO_MIXTO')
                                 @php
                                  $rend = $catAutomovil->rendimiento_mixto;
                                 @endphp
                                @break
                               @case('RENDIMIENTO_CIUDAD')
                                 @php
                                  $rend = $catAutomovil->rendimiento_ciudad;
                                 @endphp
                                @break
                                @case('RENDIMIENTO_CARRETERA')
                                 @php
                                    $rend = $catAutomovil->rendimiento_carretera;
                                 @endphp
                                @break
                                @case('RENDIMIENTO_CARGA')
                                 @php
                                    $rend = $catAutomovil->rendimiento_carga;
                                 @endphp
                                @break
                               @default
                           @endswitch
                           <input type="hidden" name="rendimiento_final" id="rendimiento_final" value="{{ $rend }}">
                        </form>
                    </div>
                </div>

            </div>
        {{-- Columna de contenido END --}}
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Seleccionar el Périodo del recorrido...</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="row"></div>
                    <div class="col-lg-12 modal-content-dialog">

                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
              </div>
            </div>
        </div>

       {{-- PRE COMISION MODAL --}}
        <div class="modal fade" id="modelPreComision" tabindex="-1" aria-labelledby="modelPreComisionLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modelPreComisionLabel">INFORMACIÓN PRE COMISIÓN</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       {{-- contenido --}}
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="placas">Placas Vehículos</label>
                                <div class="custom-file">
                                    <label for=""><h5>{{ $preComision->placas_vehiculo }}</h5></label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="placas">Marca Vehículo</label>
                                <div class="custom-file">
                                    <label for=""><h5>{{ $preComision->marca_vehiculo }}</h5></label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="placas">Rendimiento</label>
                                <div class="custom-file">
                                    <label for="">
                                        <h5>
                                           @switch($preComision->rendimiento)
                                               @case('RENDIMIENTO_MIXTO')
                                                    Rendimiento Mixto
                                                @break
                                               @case('RENDIMIENTO_CIUDAD')
                                                   Rendimiento de Ciudad
                                                @break
                                                @case('RENDIMIENTO_CARRETERA')
                                                    Rendimiento de Carretera
                                                @break
                                                @case('RENDIMIENTO_CARGA')
                                                    Rendimiento de Carga
                                                @break

                                                @default

                                           @endswitch
                                        </h5>
                                    </label>
                                </div>
                            </div>
                        </div>
                       {{-- contenido END --}}
                       <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="placas">Costo del Combustible por Litro</label>
                                <div class="custom-file">
                                    <label for=""><h5>{{ $preComision->costo_combustible }} Lts</h5></label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="placas">Kilometros totales</label>
                                <div class="custom-file">
                                    <label for=""><h5>{{ $preComision->km_totales }} Kms</h5></label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="placas">Pejae Total</label>
                                <div class="custom-file">
                                    <label for=""><h5>${{ $preComision->peaje }}.00</h5></label>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="placas">Monto Total de Combustible</label>
                                <div class="custom-file">
                                    <label for=""><h5>${{ $preComision->monto_total }}</h5></label>
                                </div>
                            </div>
                       </div>
                       <div class="form-row">
                          {{-- rendimiento --}}
                            <div class="col-md-4 mb-3">
                                <label for="monto_total_rendimiento">Rendimiento del Vehículo</label>
                                <div class="custom-file">
                                    <label for=""><h5>{{ $preComision->rendimiento }}</h5></label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="monto_total_rendimiento">Monto Total de Rendimiento</label>
                                <div class="custom-file">
                                    <label for=""><h5>${{ $preComision->monto_total_rendimiento }}</h5></label>
                                </div>
                            </div>
                       </div>
                        <div class="table_wrapper">
                            <table class="table table-bordered" id="totalesDinamicos">
                                <thead>
                                    <tr>
                                        <th>DE</th>
                                        <th>A</th>
                                        <th>KMS</th>
                                        <th>PEAJE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($punto_a_punto as $p => $v)
                                    <tr>
                                        <td>{{ $v->_de }}</td>
                                        <td>{{ $v->_a }}</td>
                                        <td>{{ $v->kms }}</td>
                                        <td>{{ $v->peaje }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">SALIR</button>
                    </div>
                </div>
            </div>
        </div>
       {{-- PRE COMISION MODAL END --}}
    </div>
{{-- Content Row END --}}


@endsection

@section('contenidoJavaScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/js_/typehead.min.js') }}"></script>
{{-- agregar assets de javascript --}}
    <script src="{{ asset('assets/jqueryvalidate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/jqueryvalidate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/jqueryvalidate/metodos/validate_comision.js') }}"></script>
{{-- agregar assets de javascritp END --}}
{{-- agregar un método js --}}
    <script type="module" src="{{ asset('assets/jqueryvalidate/metodos/calcular_comision.js') }}"></script>
{{-- agregar un método js END --}}
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $(document).ready(function(){
            // código utilizado
            const month_array = [    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                                     "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                                ];
            var d = new Date();
            var month = d.getMonth();
            var day = d.getDate();
            var year = d.getFullYear();
            $('#exampleModal .modal-body .modal-content-dialog').append(
                    '<button class="btn btn-squared-default btn-success" value="1a Quincena de '+ month_array[month] +' del '+ year +'">'+
                        '<i class="fas fa-calendar fa-4x"></i>'+
                        '<br />'+
                        '<span class="text">1° Quincena de '+ month_array[month] +' del '+ year +'</span>'+
                    '</button>'+
                    '&nbsp;&nbsp;'+
                    '<button class="btn btn-squared-default btn-warning" value="2a Quincena de '+ month_array[month] +' del '+ year +'">'+
                        '<i class="fas fa-calendar fa-4x"></i>'+
                        '<br />'+
                        '<span class="text">2° Quincena de '+ month_array[month] +' del '+ year +'</span>'+
                    '</button>' +
                    '&nbsp;&nbsp;' +
                    '<button class="btn btn-squared-default btn-primary" value="Mes de '+ month_array[month] +' del '+ year +'">'+
                        '<i class="fas fa-calendar fa-4x"></i>'+
                        '<br />'+
                        '<span class="text">Mes de '+ month_array[month] +' del '+ year +'</span>'+
                    '</button>'
            );




            var j = -1; //elemento inicial contador
            var i = -1;
            var max_fields = 200; //maximo elementos permitidos
            var addBitacora = $("#addBitacora");
            var sum = 0;
            var importeTotal = 0;
            var conteo_actual = 0;

            $('#addRecorrido').click(function(){
                if (j < max_fields) {
                    j++;
                    $("#recorridotable").append(
                        '<tr>'+
                            '<td>' +
                                '<input type="date" name="addcomision['+ j +'][fecha_comision]" class="form-control"/>' +
                            '</td>' +
                            '<td>' +
                                '<textarea name="addcomision['+ j +'][de_comision]" class="form-control"></textarea>' +
                            '</td>' +
                            '<td>' +
                                '<textarea name="addcomision['+ j +'][a_comision]" class="form-control"></textarea>' +
                            '</td>' +
                            '<td>' +
                                '<select name="addcomision['+ j +'][tipo]" id="tipo[]" class="form-control" onfocus="this.selectedIndex = 0;">'+
                                    '<option value="">-- SELECCIONAR --</option>'+
                                    '<option value="RECORRIDO">RECORRIDO</option>' +
                                    '<option value="PUNTO_A_PUNTO">PUNTO A PUNTO</option>' +
                                '</select>' +
                            '</td>'+
                            '<td data-label="...">'+
                                '<button type="button" class="btn btn-danger btn-circle btn-sm remove-tr">'+
                                    '<i class="fas fa-minus-circle"></i>'+
                                '</button>'+
                            '</td>'+
                        '<tr>'
                    );
                }
            });

            $('#addItemcomision').click(function(){
                if (i < max_fields) {
                    i++;
                    $('#comisiontable').append(
                        '<tr>' +
                            '<td>' +
                                '<input type="text" class="form-control" name="addcomisiones['+ i +'][factura]" id="facturas[]"/>' +
                            '</td>' +
                            '<td>' +
                                '<input type="text" name="addcomisiones[' + i +'][litros]" id="litros[]" class="form-control lts_comision" autocomplete="off"/>' +
                            '</td>' +
                            '<td>' +
                                '<input type="text" class="form-control unitario_precio" name="addcomisiones[' + i +'][pu]" id="precioUnitario[]" autocomplete="off"/>' +
                            '</td>' +
                            '<td>' +
                                '<input type="text" class="form-control importe_unitario" name="addcomisiones[' + i +'][importe]" id="totalImporte[]" autocomplete="off"/>' +
                            '</td>' +
                            '<td data-label="...">'+
                                '<button type="button" class="btn btn-danger btn-circle btn-sm remove-tr-comision">'+
                                    '<i class="fas fa-minus-circle"></i>'+
                                '</button>'+
                            '</td>'+
                        '</tr>'
                    );
                }
            });

            //Once remove button is clicked
            $(document).on('click', '.remove-tr', function(e){
                e.preventDefault();
                var totalLitros = $("#litros_totales").val();
                // se remueve la parte de la tabla
                $(this).parents('tr').remove();
                j--; //Decrement field counter
            });

            /**
            *@argument - creacion de función para eliminar elemento de la comisión
            */
            $(document).on('click', '.remove-tr-comision', function(e){
                e.preventDefault();
                var lts_comision = $(this).closest('tr').find('.lts_comision').val();
                var precio_unit = $(this).closest('tr').find('.unitario_precio').val();
                var importes = $(this).closest('tr').find('.importe').val();
                restarLitros(lts_comision);
                restarprecioUnitario(precio_unit);
                restarimporte(importes);
                // se remueve la parte de la tabla
                $(this).parents('tr').remove();
                i--; //Decrement field counter
            });

            $(document).on('keyup', '.numbersOnly', function() {
                if (this.value != this.value.replace(/[^0-9\-,]/g, '')) {
                    this.value = this.value.replace(/[^0-9\-,]/g, '');
                }
            });

            /** @author - Daniel Méndez Cruz
            *   @argument - evt
            */
            $(document).on('input', '#kmFinal', function(){
                if (this.value != this.value.replace(/[^0-9\-,]/g, '')) {
                    this.value = this.value.replace(/[^0-9\-,]/g, '');
                }
            });

            $(document).on('input', '#kmInicial', function(){
                if (this.value != this.value.replace(/[^0-9\-,]/g, '')) {
                    this.value = this.value.replace(/[^0-9\-,]/g, '');
                }
            });

            /**@author - DANIEL MÉNDEZ CRUZ
            */
            $(document).on('input', '.lts_comision', function(){
                if (this.value != this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.')) {
                    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
                }
            });

            $(document).on('input', '#litros', function(){
                if (this.value != this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.')) {
                    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
                }
            });

            $(document).on('input', '.unitario_precio', function(){
                if (this.value != this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.')) {
                    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
                }
            });

            $(document).on('input', '.importe', function(){
                if (this.value != this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.')) {
                    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
                }
            });

            /**@author - DANIEL MÉNDEZ CRUZ
            * MODIFICACIONES DEL TIPO DE DATO QUE PERMITE INGRESAR - denominacion_vales
            */
            $(document).on('input', '.denominacion_vales', function() {
                if (this.value != this.value.replace(/[^0-9\-,]/g, '')) {
                    this.value = this.value.replace(/[^0-9\-,]/g, '');
                }
            });

            /*
            * funcion de javascript para obtener un dato
            */
            $(document).on('keyup', '.denominacion_vales', '.vales_tag', function(){
                //get amt and qty value
                var vales = $(this).closest('tr').find('.vales_tag').val();
                var denominacionVales = $(this).closest('tr').find('.denominacion_vales').val();
                if(check(vales) == true){
                    // Code that needs to execute when none of the above is in the string
                    separadores = ['-',','];
                    textoseparado = vales.split (new RegExp (separadores.join('|'),'g'));
                    var arreglo = [];
                    for ( index = 0; index < textoseparado.length; index++) {
                        arreglo.push(textoseparado[index]);
                    }

                    arreglo.sort(function (a,b) {
                        return b-a;
                    });

                    var sumatoria = calculo(arreglo);

                    var importe = sumatoria * denominacionVales;
                    $(this).closest('tr').find('.importe').val(importe);
                }
            });

            /**@author
             * función Javascript para hacer el calculo directo entre los litros del item
             * y el precio del litro que maneja cada apartado
            */
           $(document).on('keyup', '.unitario_precio', '.lts_comision', function() {
                var ltsComision = $(this).closest('tr').find('.lts_comision').val();
                var unitarioPrecio = $(this).closest('tr').find('.unitario_precio').val();
                if (ltsComision.length > 0 && unitarioPrecio.length > 0) {
                    let importeTotal = ltsComision * unitarioPrecio;
                    $(this).closest('tr').find('.importe_unitario').val(importeTotal);
                }
           });
            /*
            * funcion para checar caracteres especiales
            */
            var specialChars = ",-";
            var check = function(string){
                for(i = 0; i < specialChars.length;i++){
                    if(string.indexOf(specialChars[i]) > -1){
                        return true
                    }
                }
                return false;
            }

            var calculo = (array) => {
                var resultado = 0;
                switch (array.length) {
                    case 2:
                        return resultado =  Math.abs(parseInt(array[0], 10) - parseInt(array[1], 10)) + 1 ;
                        break;
                    case 3:
                        var resultado1 = parseInt(array[0], 10) - parseInt(array[1], 10);
                        var resultado2 = parseInt(array[1], 10) - parseInt(array[2], 10);
                        return resultado = resultado1 + resultado2 + 1;
                        break;
                    default:
                        break;
                }
            }

            // $("#kmFinal").blur(function(){
            //    var kmInicial =  $('#kmInicial').val();
            //    var kmFinal =  $(this).val();
            //    if (kmInicial != '' && kmFinal != '') {
            //         var ki = parseFloat(kmInicial,10);
            //         var kf = parseFloat(kmFinal,10);
            //        if (ki < kf) {
            //             var dk = kf - ki;
            //             var km_totales = document.getElementById("km_totales");
            //             if (km_totales.value == 'NaN') {
            //                 km_totales.value = 0;
            //             }
            //             km_totales.value = dk;
            //        }
            //    } else {
            //         var km_totales = document.getElementById("km_totales");
            //         km_totales.value = 'NaN';
            //    }
	        // });

            $('input#_kilometroInicial').on('input', function() {
                this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..*?)\..*/g, '$1');
            });

            var path = "{{ route('autocomplete') }}";
            $('input.typeahead').typeahead({
                source:  function (query, process) {
                    return $.get(path, { term: query }, function (data) {
                        return process(data);
                    });
                }
            });

            $("input.typeahead").focus(function(){
                if ($('input.typeahead').val().length != 0) {
                    var url = "{{ route('softload') }}";
                    var param = {
                        "type": $('input.typeahead').val()
                    };
                    $.ajax({
                        data:  param,
                        url:   url,
                        type:  'get',
                        beforeSend: function () {
                            console.log('Procesando, espere por favor...');
                        },
                        success:  function (response) {
                            $('#color').val(response[0]['color']);
                            $('#marca_vehiculo').val(response[0]['marca']);
                            $('#modelo').val(response[0]['modelo']);
                            $('#tipo').val(response[0]['tipo']);
                            $('#no_serie').val(response[0]['numero_serie']);
                            $('#responsableUnidad').val(response[0]['resguardante_unidad']);
                            $('#puestoResponsableUnidad').val(response[0]['puesto_resguardante_unidad']);
                            $('#idcatvehiculo').val(response[0]['id']);
                        }
                    });
                } else {

                }
            });

            $('#periodo_comision').click(function () {
                $('#exampleModal').modal('show');
            });

            /** @argument - arg
            * @author - Daniel Méndez Cruz
            */
            $('#_kilometroInicial').on('input', (event) => {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });

            /*
            * funcion para mejorar la iteracción de los datos con el campo de fecha
            */
            $('#fecha_comision').change(function() {
                const nombre_mes = [    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                                        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                                    ];
                var date = new Date($(this).val());
                // obtener el mes en el que nos encontramos
                var otro_mes = date.getMonth() + 1;
                var mes_actual = date.getMonth();
                var anio_actual = date.getFullYear();
                // limpiar el contenido
                $('#exampleModal .modal-body .modal-content-dialog').empty();
                // cargar nuevo contenido
                $('#exampleModal .modal-body .modal-content-dialog').append(
                        '<button class="btn btn-squared-default btn-success" onclick="cargarPeriodo(\'' + '1a Quincena de '+ nombre_mes[mes_actual] +' del '+ anio_actual + '\')" >'+
                            '<i class="fas fa-calendar fa-4x"></i>'+
                            '<br />'+
                            '<span class="text">1° Quincena de '+ nombre_mes[mes_actual] +' del '+ anio_actual +'</span>'+
                        '</button>'+
                        '&nbsp;&nbsp;'+
                        '<button class="btn btn-squared-default btn-warning" onclick="cargarPeriodo(\'' + '2a Quincena de '+ nombre_mes[mes_actual] +' del '+ anio_actual + '\')" >'+
                            '<i class="fas fa-calendar fa-4x"></i>'+
                            '<br />'+
                            '<span class="text">2° Quincena de '+ nombre_mes[mes_actual] +' del '+ anio_actual +'</span>'+
                        '</button>' +
                        '&nbsp;&nbsp;' +
                        '<button class="btn btn-squared-default btn-primary" onclick="cargarPeriodo(\''+ 'Mes de '+ nombre_mes[mes_actual] +' del '+ anio_actual + '\')" >'+
                            '<i class="fas fa-calendar fa-4x"></i>'+
                            '<br />'+
                            '<span class="text">Mes de '+ nombre_mes[mes_actual] +' del '+ anio_actual +'</span>'+
                        '</button>'
                );
            });

            /**
            * @author - Daniel Méndez Cruz
            * @argument - periodo
            */
            $('.btn-squared-default').on('click', function(){
                $('#exampleModal').modal("toggle");
                var periodo = $(this).val();
                // obtener el primer carácter del periodo
                var primerCaracter = periodo.charAt(0);
                $('#periodo_comision').val(periodo);
                $('#periodo_comision_actual').val(primerCaracter);
            });

            /**@author -- DANIEL MÉNDEZ CRUZ
             *@augments - load
             * vamos a ejecutar una función ajax con para autocomplete
            */
            $( "input#nombreConductor" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({

                        url: "{{ route('autocomplete.fetch') }}",
                        method: 'POST',
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                }
            });
        });
        /**
        * funciones javascripts puras
        */

        function calcularLitrosTotales(arg){
            var litrosTotales = 0, lts = 0, ltsanterior = 0;
            var t = arg.parentNode.parentNode;
            var nodos = t.childNodes;
            // generamos el ciclo
            for (let j = 0; j < nodos.length; j++) {
                if (nodos[j].firstChild.id == 'litros[]') {
                    ltsanterior = nodos[j].firstChild.value;
                    litrosTotales = parseFloat(nodos[j].firstChild.value,10);
                    nodos[j].firstChild.value = litrosTotales;
                }
            }

            var ltsTotales = document.getElementById("litros_totales");
            if (ltsTotales.value == 'NaN') {
                ltsTotales.value = 0;
            }
            var litrosTotales = parseFloat(ltsTotales.value) + litrosTotales;
            ltsTotales.value = roundToTwo(litrosTotales);
        }

        function restarLitros(args){
            var element = 0;
            element = parseFloat(args, 2);
            var callts = document.getElementById("litros_totales");
            if (callts.value == 'NaN' || callts.value == 0) {
                callts.value = 0;
            } else {
                callts.value = parseFloat(callts.value).toFixed(2) - element;
            }
        }

        function calcularPrecioUnitario(argumentos){
            var preciototal = 0, precioanterior = 0;
            var f = argumentos.parentNode.parentNode;
            var nods = f.childNodes;
            for (let index = 0; index < nods.length; index++) {
                if (nods[index].firstChild.id == 'precioUnitario[]') {
                    precioanterior = nods[index].firstChild.value;
                    preciototal = parseFloat(nods[index].firstChild.value,10);
                    nods[index].firstChild.value = preciototal;
                }
            }

            var precio_unitario_total = document.getElementById("precio_unitario_total");
            if (precio_unitario_total.value == 'NaN') {
                precio_unitario_total.value = 0;
            }
            var sumatoria_precioUnitario = parseFloat(precio_unitario_total.value) + preciototal;
            precio_unitario_total.value = roundToTwo(sumatoria_precioUnitario);
        }

        function calcularImporteTotal(args)
        {
            var importetotal = 0, importeanterior = 0;
            var ij = args.parentNode.parentNode;
            var nd = ij.childNodes;
            for (let ids = 0; ids < nd.length; ids++) {
                if (nd[ids].firstChild.id == 'totalImporte[]') {
                    importeanterior = nd[ids].firstChild.value;
                    importetotal = parseFloat(nd[ids].firstChild.value, 2);
                    nd[ids].firstChild.value = importetotal;
                    console.log(importetotal);
                }
            }

            var importe_total = document.getElementById("importe_total");
            if (importe_total.value == 'NaN') {
                importe_total.value = 0;
            }
            var valor = parseFloat(importe_total.value) + importetotal;
            importe_total.value = roundToTwo(valor);
        }

        function cargarPeriodo(argumento){
            $('#exampleModal').modal("toggle");
            var periodo = argumento;
            // obtener el primer carácter del periodo
            var primerCaracter = periodo.charAt(0);
            if (isNaN(primerCaracter)) {
                //es verdadero para un valor NaN
                $('#periodo_comision').val(periodo);
                $('#periodo_comision_actual').val(0);
            } else {
                // es falso para un valor numérico válido
                $('#periodo_comision').val(periodo);
                $('#periodo_comision_actual').val(primerCaracter);
            }

        }

        function roundToTwo(num) {
            return +(Math.round(num + "e+2")  + "e-2");
        }

        function round(num, decimales = 2) {
            var signo = (num >= 0 ? 1 : -1);
            num = num * signo;
            if (decimales === 0) //con 0 decimales
                return signo * Math.round(num);
            // round(x * 10 ^ decimales)
            num = num.toString().split('e');
            num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
            // x * 10 ^ (-decimales)
            num = num.toString().split('e');
            return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
        }

        function restarprecioUnitario(args){
            var element = 0;
            element = parseFloat(args, 2);
            var pu = document.getElementById("precio_unitario_total");
            if (pu.value == 'NaN' || pu.value == 0) {
                pu.value = 0;
            } else {
                pu.value = round(parseFloat(pu.value).toFixed(2) - element);
            }
        }

        function restarimporte(arg){
            var element = 0;
            element = parseFloat(arg, 2);
            var importes = document.getElementById("importe_total");
            if (importes.value == 'NaN' || importes.value == 0) {
                importes.value = 0;
            } else {
                importes.value = round(parseFloat(importes.value).toFixed(2) - element);
            }
        }

    </script>
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
