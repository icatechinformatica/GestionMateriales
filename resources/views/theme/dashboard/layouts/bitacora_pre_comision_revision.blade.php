{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Revisión Pre Comisión | SISCOM by ICATECH')

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
                            Revisión de Comisiones
                        </h6>
                    </div>
                    <div class="card-body">
                        {{-- registro de datos --}}
{{-- agregar tabla responsiva --}}
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">Memorandum</th>
                                    <th scope="col">Placas</th>
                                    <th scope="col">Rendimiento</th>
                                    <th scope="col">Revisión</th>
                                    <th scope="col">Generar Documento</th>
                                </tr>
                            </thead>
                            <tbody>
                               @if (count($revisarPreComision) > 0)
                                  @foreach ($revisarPreComision as $itemPreComisionRevisar => $v)
                                    <tr>
                                        <td data-label="Memorandum"><b>{{ $v->memorandum_comision }}</b></td>
                                        <td data-label="Placas">{{ $v->placas_vehiculo }}</td>
                                        <td data-label="Rendimiento">{{ $v->rendimiento }}</td>
                                        <td data-label="Revisión">
                                            @can('revisar comision')
                                               @switch($v->status_seguimiento_id)
                                                   @case(5)
                                                        <a href="{{ route('solicitud.pre.comision.revision.detalle', [base64_encode($v->id), base64_encode($v->status_seguimiento_id)]) }}" class="btn btn-success btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="COMISIÓN LISTA">
                                                            <i class="fas fa-check-circle"></i>
                                                        </a>
                                                    @break
                                                   @default
                                                        <a href="{{ route('solicitud.pre.comision.revision.detalle', [base64_encode($v->id), base64_encode($v->status_seguimiento_id)]) }}" class="btn btn-primary btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="REVISAR LA COMISIÓN">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                               @endswitch
                                            @endcan
                                        </td>
                                        <td data-label="Generar Documento">
                                           @switch($v->status_seguimiento_id)
                                                @case(5)
                                                    <a href="{{ route('generar.reporte.bitacora.pdf', base64_encode($v->solicitud_id)) }}" target="_blank" class="btn btn-danger  btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="GENERAR BITÁCORA">
                                                        <i class="far fa-file-pdf fa-1x"></i>
                                                    </a>
                                                @break
                                               @default
                                                <a href="javascript:;" class="btn btn-primary  btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="GENERAR BITÁCORA">
                                                    <i class="fas fa-unlink"></i>
                                                </a>
                                           @endswitch
                                            
                                        </td>
                                    </tr>
                                  @endforeach
                               @else
                                    <tr>
                                        <td colspan="4"><center><h3> <b>NO HAY REGISTROS PARA MOSTRAR</b> </h3></center></td>
                                    </tr>
                               @endif
                                
                            </tbody>
                        </table>
{{-- agregar table responsiva END --}}
                        
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
