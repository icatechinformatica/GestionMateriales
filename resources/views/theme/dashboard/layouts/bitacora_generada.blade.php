{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Bitácoras Terminadas | SISCOM by ICATECH')

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

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Bien Hecho!</strong> {{ $message }}
        </div>
    @endif

{{-- Content Row --}}
    <div class="row">
        {{-- Columna de contenido --}}
            <div class="col-lg-12 mb-4">
                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-passport"></i>
                            Bitácoras Terminadas
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="marca_vehiculo">FILTRAR MES</label>
                                <div class="custom-file">
                                    <select class="form-control" name="mes_filtrado" id="mes_filtrado">
                                        <option value="">---- SELECCIONAR ----</option>
                                        @foreach ($meses as $k => $v)
                                         <option value="{{ $v }}">{{ $k }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="marca_vehiculo">FILTRAR PERIODO</label>
                                <div class="custom-file">
                                    <select class="form-control" name="periodo_filtrado" id="periodo_filtrado">
                                        <option value="">---- SELECCIONAR ----</option>
                                        <option value="1">PRIMER PERIODO</option>
                                        <option value="2">SEGUNDO PERIODO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="modelo">&nbsp;</label>
                                <div class="custom-file">
                                    <button class="btn btn-info">
                                        <i class="fas fa-filter"></i>
                                        Filtrar
                                    </button>
                                </div>
                            </div>
                        </div>
{{-- contenido de la tabla de Bitácora terminada --}}
                        <div class="form-row">
                            <table>
                                <thead>
                                    <tr>
                                        <th scope="col">Placas</th>
                                        <th scope="col">Periodo</th>
                                        <th scope="col">Detalle</th>
                                        <th scope="col">Imprimir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if (count($bitacoraTerminada) > 0)
                                      @foreach ($bitacoraTerminada as $itemSolicitud => $v)
                                          <tr>
                                            <td data-label="Placas">
                                                <b>{{ $v->placas }}</b>
                                            </td>
                                            <td data-label="Periodo">
                                                {{ $v->periodo }}
                                            </td>
                                            <td data-label="Detalle">
                                                @can('revisar bitacora')
                                                    <a href="{{ route('solicitud.bitacora.terminado', base64_encode($v->id)) }}" class="btn {{ $v->estado == 'FINALIZADO' ? 'btn-success' : 'btn-danger'}}  btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="CHECAR DETALLE DE LA SOLICITUD">
                                                        <i class="fas fa-traffic-light"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                            <td data-label="Imprimir">
                                                <a href="{{ route('generar.reporte.bitacora.pdf', base64_encode($v->id)) }}" target="_blank" class="btn btn-primary  btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="CHECAR DETALLE DE LA SOLICITUD">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </td>
                                          </tr>
                                      @endforeach
                                   @else
                                        <tr>
                                            <td colspan="4">
                                                <center>
                                                    <h3>
                                                        <b>NO HAY REGISTROS PARA MOSTRAR</b>
                                                    </h3>
                                                </center>
                                            </td>
                                        </tr>
                                   @endif
                                </tbody>
                            </table>
                        </div>
{{-- contenido de la tabla de bitácora terminada END --}}
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
