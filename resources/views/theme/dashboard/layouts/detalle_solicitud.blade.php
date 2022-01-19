{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Solicitud Presupuestal Indice | ICATECH')

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
                                <div class="col-md-2 mb-3">
                                    @switch($solicitud_detalle->estado)
                                        @case('ENVIADO')
                                            <a href="#" class="btn btn-danger">
                                                <i class="fas fa-traffic-light"></i>&nbsp; ENVIADO
                                            </a>
                                            @break
                                        @case('REVISION')
                                            <a href="#" class="btn btn-warning">
                                                <i class="fas fa-traffic-light"></i>&nbsp; EN REVISIÓN
                                            </a>
                                            @break
                                        @case('REVISADO')
                                            <a href="#" class="btn btn-secundary">
                                                <i class="fas fa-traffic-light"></i>&nbsp; REVISADO
                                            </a>
                                        @break
                                        @case('FINALIZADO')
                                            <a href="#" class="btn btn-success">
                                                <i class="fas fa-traffic-light"></i>&nbsp; FINALIZADO
                                            </a>
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
                                        <label for="">{{ $solicitud_detalle->fecha }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Periodo</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_detalle->periodo }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Placa</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_detalle->placas }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Marca Vehículo</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_detalle->marca }}</label>
                                    </div>
                                </div>
                            </div>
                            {{-- otro intervalo --}}
                            <div class="form-row">

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Modelo</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_detalle->modelo }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Tipo de Vehículo</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_detalle->tipo }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Color</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_detalle->color }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">N° de Serie</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_detalle->numero_serie }}</label>
                                    </div>
                                </div>
                            </div>
                            {{-- otro intervalo de datos --}}
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Número de Motor</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_detalle->numero_motor }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Kilometro Inicial</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_detalle->km_inicial }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Número de Factura de compra</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_detalle->numero_factura_compra }}</label>
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="fecha">Nombre del Conductor</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_detalle->conductor }}</label>
                                    </div>
                                </div>
                            </div>
                            {{-- otro invervalo de datos --}}
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha">Responsable de la Unidad</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_detalle->resguardante_unidad }}</label>
                                    </div>
                                </div><div class="col-md-6 mb-3">
                                    <label for="fecha">Puesto del responsable de la unidad</label>
                                    <div class="custom-file">
                                        <label for="">{{ $solicitud_detalle->puesto_resguardante_unidad }}</label>
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
                                    @foreach ($bitacora_recorrido as $k => $v)
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
                                        <h4><b>{{ $solicitud_detalle->total_km_recorridos }}</b></h4>
                                    </td>
                                    <td data-label="LITROS TOTALES:" style="width: 15%; text-align: right;">
                                        <h3><b>Litros Totales:</b></h3>
                                    </td>
                                    <td data-label="Litros" style="width: 11%;" colspan="2">
                                        <h4><b>{{ $solicitud_detalle->litros_totales }}</b></h4>
                                    </td>
                                    <td data-label="Importe" colspan="2" style="width: 19%;">
                                        <h4><b>Importe Total: <br> $ {{ $solicitud_detalle->importe_total }}</b></h4>
                                    </td>
                                  </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- columna de comentarios --}}
            <div class="col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    {{-- card header - Accordion --}}
                    <a href="#observacionRecorrido" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="observacionRecorrido">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-comment"></i>
                            OBSERVACIONES
                        </h6>
                    </a>
                    {{-- card content - Collapse --}}
                    <div class="collapse show" id="observacionRecorrido">
                        <div class="card-body">
                            <b>{{ $solicitud_detalle->observacion }}</b>                            
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