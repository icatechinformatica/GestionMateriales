{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Indice de Pre Comisión | SISCOM by ICATECH')

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

    <!-- Content Row -->
    <div class="row">

        {{-- nueva solicitud  sólo pueden accesar los que tienen el permiso de publicar bitacora--}}
        @if (auth()->user()->can('publicar bitacora'))
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <a href="{{ route('solicitud.pre.comision.create') }}">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        PRE COMISIÓN
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-ad fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endif
    </div>

{{-- Content Row --}}
    <div class="row">
        {{-- Columna de contenido --}}
            <div class="col-lg-12 mb-4">

                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-layer-group"></i>
                            SOLICITUDES DEL PRE COMISIÓN
                        </h6>
                    </div>
                    <div class="card-body">
                        {{-- Agregamos Información de una tabla --}}
                        <table>
                            <caption>Solicitud pre comisión</caption>
                            <thead>
                              <tr>
                                <th scope="col">Placa Vehículo</th>
                                <th scope="col">Marca Vehículo</th>
                                <th scope="col">rendimiento</th>
                                <th scope="col">...</th>
                              </tr>
                            </thead>
                            <tbody>
                               @if (count($getprecomision) > 0)
                                   @foreach ($getprecomision as $item => $v)
                                       <tr>
                                        <td data-label="Placa Vehículo">{{ $v->placas_vehiculo }}</td>
                                        <td data-label="Marca Vehículo">{{ $v->marca_vehiculo }}</td>
                                        <td data-label="rendimiento">{{ $v->rendimiento }}</td>
                                        <td data-label="...">
                                           @if ($v->comisionado == true)
                                                <a href="{{ route('solicitud.pre.comision.continue', base64_encode($v->id)) }}" class="btn btn-danger btn-circle btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                           @else
                                                <a href="{{ route('solicitud.pre.comision.details', base64_encode($v->id)) }}" class="btn btn-info btn-circle btn-sm">
                                                    <i class="fas fa-link"></i>
                                                </a>
                                           @endif
                                            
                                        </td>
                                       </tr>
                                   @endforeach
                               @else
                                <tr>
                                    <td colspan="4"><h3> <b>NO HAY REGISTROS PARA MOSTRAR</b> </h3></td>
                                </tr>
                               @endif
                            </tbody>
                        </table>
                        {{-- Agregamos Información de una tabla END --}}
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