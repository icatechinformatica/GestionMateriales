{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Solicitud Bitácora Terminada | ICATECH')

@section('contenidoCss')
    <style>
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
        font-size: .85em;
        letter-spacing: .1em;
        text-transform: uppercase;
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
                font-size: .7em;
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
                <!-- Collapsable Card Example -->
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#collapseCardExample" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info"></i>
                            Detalle de Solicitud de Bitácora
                        </h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="collapseCardExample">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-md-5 mb-3">
                                    <h2>ESTADO DE LA SOLICITUD:</h2>
                                </div>
                                <div class="col-md-1 mb-3">
                                    @switch($solicitud_terminada->estado)
                                        @case('ENVIADO')
                                            <a href="#" class="btn btn-danger">
                                                <i class="fas fa-traffic-light"></i>&nbsp; Enviado
                                            </a>
                                            @break
                                        @case('REVISION')
                                            <a href="#" class="btn btn-warning">
                                                <i class="fas fa-traffic-light"></i>&nbsp; En Revisión
                                            </a>
                                            @break
                                        @case('REVISADO')
                                            <a href="#" class="btn btn-secundary">
                                                <i class="fas fa-traffic-light"></i>&nbsp; Enviado
                                            </a>
                                        @break
                                        @case('FINALIZADO')
                                            <span class="badge bg-secondary">TERMINADO</span>
                                        @break
                                        @default
                                            
                                    @endswitch
                                </div>
                                <div class="col-md-5 mb-3">
                                    <a href="{{  url()->previous() }}" class="btn btn-info">
                                        <i class="fas fa-arrow-circle-left"></i>&nbsp; Regresar
                                    </a>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Fecha</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->fecha }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Periodo</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->periodo }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Placa</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->placas }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Marca Vehículo</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->marca }}</label>
                                    </div>
                                </div>
                            </div>
                            {{-- otro intervalo --}}
                            <div class="form-row">

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Modelo</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->modelo }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Tipo de Vehículo</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->tipo }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Color</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->color }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">N° de Serie</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->numero_serie }}</label>
                                    </div>
                                </div>
                            </div>
                            {{-- otro intervalo de datos --}}
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Número de Motor</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->numero_motor }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Kilometro Inicial</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->km_inicial }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Número de Factura de compra</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->numero_factura_compra }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Nombre del Conductor</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->conductor }}</label>
                                    </div>
                                </div>
                            </div>
                            {{-- otro invervalo de datos --}}
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha">Responsable de la Unidad</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->resguardante_unidad }}</label>
                                    </div>
                                </div><div class="col-md-6 mb-3">
                                    <label for="fecha">Puesto del responsable de la unidad</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_terminada->puesto_resguardante_unidad }}</label>
                                    </div>
                                </div>
                            </div>
                            {{-- división --}}
                            <hr>
                        </div>
                    </div>
                </div>

            </div>
        {{-- Columna de contenido END --}}
            <div class="col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#bitacoraRecorrido" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="bitacoraRecorrido">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-route"></i>
                            Bitácora de Recorrido
                        </h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="bitacoraRecorrido">
                        <div class="card-body">
                            @switch($solicitud_terminada->es_comision)
                                @case(true)
                                   @php
                                       $i = 0;
                                       $j = 0;
                                       $contador = 0;
                                   @endphp
                                   {{-- es comision --}}
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>KM inicial</th>
                                                <th>De:</th>
                                                <th>A:</th>
                                                <th>KM final</th>
                                                <th>Factura</th>
                                                <th>Litros</th>
                                                <th>P.U</th>
                                                <th>Importe</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach ($recorridoComision as $k => $v)
                                            @php
                                                $i ++;
                                                $j ++;
                                                $contador ++;
                                            @endphp
                                           <tr>
                                                <td data-label="KM inicial">
                                                    {{ $v->fecha_comision }}
                                                </td>
                                                <td data-label="KM inicial">
                                                   @if ($i  == 1)
                                                      {{ $solicitud_terminada->km_inicial }} 
                                                   @endif
                                                </td>
                                                <td data-label="De:">
                                                    {{ $v->de_comision }}
                                                </td>
                                                <td data-label="A:">
                                                    {{ $v->a_comision }}
                                                </td>
                                                <td data-label="KM final">
                                                   @if ($j == 1)
                                                        {{ $solicitud_terminada->km_final_antes_cargar_combustible }}
                                                   @endif
                                                </td>
                                                @if ($contador <= count($bitacoraComision))
                                                        @foreach ($bitacoraComision as $l => $k)
                                                            <td>{{ $k->factura_comision }}</td>
                                                            <td>{{ $k->litros_comision }}</td>
                                                            <td>{{ $k->precio_unitario_comision }}</td>
                                                            <td>{{ $k->importe_comision }}</td> 
                                                        @endforeach 
                                                @else
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                            </tr>
                                           @endforeach
                                        </tbody>
                                    </table>
                                @break
                                @case(false)
                                   {{-- no es comisión --}}
                                    <table class="table table-bordered" id="dynamicTable">
                                        <thead>
                                        <tr>
                                            <th  style="width: 11.11%;">Fecha</th>
                                            <th  style="width: 10%;">KM inicial</th>
                                            <th  style="width: 18%;">De:</th>
                                            <th  style="width: 18%;">a: </th>
                                            <th  style="width: 10%;">KM final</th>
                                            <th  style="width: 15%;">Vales</th>
                                            <th  style="width: 11%;">Litros</th>
                                            <th  style="width: 7%;">DV</th>
                                            <th  style="width: 12%;">Importe</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bitacora_recorrido_terminado as $k => $v)
                                            <tr>
                                                <td data-label="Fecha">
                                                    {{ $v->fecha }}
                                                </td>
                                                <td data-label="KM inicial">
                                                    {{ $v->kilometraje_inicial }}
                                                </td>
                                                <td data-label="De:">
                                                    {{ $v->actividad_inicial }}
                                                </td>
                                                <td data-label="a:">
                                                    {{ $v->actividad_final }}
                                                </td>
                                                <td data-label="KM final">
                                                    {{ $v->kilometraje_final }}
                                                </td>
                                                <td data-label="Vales">
                                                    {{ $v->vales }}
                                                </td>
                                                <td data-label="Litros">
                                                    {{ $v->litros }}
                                                </td>
                                                <td data-label="DV">
                                                    {{ $v->division_vale }}
                                                </td>
                                                <td data-label="Importe">
                                                    {{ $v->importe }}
                                                </td>
                                            </tr> 
                                            @endforeach
                                        </tbody>
                                    </table>
                                @break
                                @default
                            @endswitch
                            <hr>
                            <table class="table table-bordered" id="totalesDinamicos">
                                <thead>
                                    <tr>
                                      <th  style="width: 57%; text-align: right;" colspan="4">KM TOTALES:</th>
                                      <th  style="width: 10%;"></th>
                                      <th  style="width: 15%; text-align: right;">LITROS TOTALES:</th>
                                      <th  style="width: 11%;" colspan="2">Litros</th>
                                      <th  colspan="2" style="width: 19%;">Importe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td data-label="KM TOTALES:" style="width: 57%; text-align: right;" colspan="4">
                                    </td>
                                    <td data-label="" style="width: 10%;">
                                        <h4><b>{{ $solicitud_terminada->total_km_recorridos }}</b></h4>
                                    </td>
                                    <td data-label="LITROS TOTALES:" style="width: 15%; text-align: right;">
                                        <h3><b>Litros Totales:</b></h3>
                                    </td>
                                    <td data-label="Litros" style="width: 11%;" colspan="2">
                                        <h4><b>{{ $solicitud_terminada->litros_totales }}</b></h4>
                                    </td>
                                    <td data-label="Importe" colspan="2" style="width: 19%;">
                                        <h4><b>Importe Total: <br> $ {{ $solicitud_terminada->importe_total }}</b></h4>
                                    </td>
                                  </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
{{-- Content Row END --}}


@endsection

@section('contenidoJavaScript')
    
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}