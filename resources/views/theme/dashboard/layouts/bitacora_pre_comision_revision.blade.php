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
                        <div class="form-row">
                            @if (count($revisarPreComision) > 0)
                                @foreach ($revisarPreComision as $itemPreComisionRevisar => $v)
                                    <div class="col-md-4">
                                        <div class="card text-black bg-light bg-gradient mb-3" style="max-width: 18rem;">
                                            <div class="card-body">
                                                <h5 class="card-title">PLACAS: {{ $v->placas_vehiculo }}</h5>
                                                <p class="card-text">RENDIMIENTO: {{ $v->rendimiento }}</p>
                                                @can('revisar comision')
                                                    <a href="{{ route('solicitud.pre.comision.revision.detalle', base64_encode($v->id)) }}" class="btn btn-primary btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="CHECAR DE LA COMISIÓN">
                                                        <i class="fas fa-search"></i>
                                                    </a>
                                                @endcan
                                                <a href="{{ route('generar.reporte.bitacora.pdf', base64_encode($v->id)) }}" target="_blank" class="btn btn-danger  btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="CHECAR DETALLE DE LA SOLICITUD">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4"><h3> <b>NO HAY REGISTROS PARA MOSTRAR</b> </h3></td>
                                </tr>
                            @endif
                        </div>
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
