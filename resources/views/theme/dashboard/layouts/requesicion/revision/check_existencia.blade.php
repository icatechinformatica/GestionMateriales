@extends('theme.dashboard.main', ['breadcrum' => __( 'SIRMAT / REVISIÓN EXISTENCIA EN REQUISICIÓN'), 'titlePage' => __( 'SIRMAT | Revisión de existencias de las requisiciones')])
{{-- CONTENIDO CSS --}}
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

        .bd-example {
            --bd-example-padding: 1rem;
            position: relative;
            padding: 1.5rem;
            margin: 0 -1.5rem;
            border: solid hsla(215, 30%, 92%, 0.877);
            border-width: 1px 0;
            background-color: #f8f8f8;
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

        @media (min-width: 768px)
        {
            .bd-example {
                --bd-example-padding: 1.5rem;
                margin-right: 0;
                margin-left: 0;
                border-width: 1px;
                border-top-left-radius: 0.375rem;
                border-top-right-radius: 0.375rem;
                background-color: #ffffff;
            }
        }
    </style>    
@endsection
{{-- CONTENIDO CSS END --}}
 {{-- CONTENIDO --}}
@section('contenido')
    <div class="row">
        <div class="col-lg-1 mb-4">
        </div>
        <div class="col-lg-10 mb-4">
            <div class="bd-example">
                <div class="row g-2">
                    <table>
                        <caption>Existencia de Requisiciones</caption>
                        <thead>
                            <tr>
                                <th scope="col">Partida Presupuestal</th>
                                <th scope="col">Departamento</th>
                                <th scope="col">Fecha Envio</th>
                                <th scope="col">Checar Existencia</th>
                            </tr>
                        </thead>
                        <tbody>
                           @if (count($requisicion_por_existencia) > 0)
                                @php
                                    $meses = [
                                        "Enero","Febrero","Marzo","Abril",
                                        "Mayo","Junio","Julio","Agosto",
                                        "Septiembre","Octubre","Noviembre","Diciembre"
                                    ];
                                @endphp
                                @foreach ($requisicion_por_existencia as $item => $i)
                                    @php
                                        // variable para pasar a español la fecha que tilizamos
                                        $fecha = Carbon\Carbon::parse($i->created_at);
                                        $mes = $meses[($fecha->format('n')) - 1];
                                    @endphp
                                    <tr>
                                        <td data-label="Partida Presupuestal">
                                            @foreach ($i->partidapresupuestal as $j => $k)
                                                <b>{{ $k['partida_presupuestal'].", " }}</b><br/>
                                            @endforeach
                                        </td>
                                        <td data-label="Departamento">{{ strtoupper($i->area->nombre) }}</td>
                                        <td data-label="Fecha de Envio">{{ $fecha->format('d') . ' DE ' . strtoupper($mes) . ' DE ' . $fecha->format('Y') }}</td>
                                        <td data-label="Checar Existencia">
                                            <a href="{{ route('requisiciones.revision.existencia.edit', base64_encode($i->id)) }}" class="btn btn-info btn-circle btn-sm">
                                                <i class="fas fa-clipboard-check fa-1x"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                           @else
                                {{-- si no hay registros --}}
                                <tr>
                                    <td colspan="4"><center><h3> <b>NO HAY REGISTROS PARA MOSTRAR</b> </h3></center></td>
                                </tr>
                           @endif
                        </tbody>
                    </table>
                </div>
                {{-- incluir mensaje --}}
                @include('theme.dashboard.messages.flash_message')
                {{-- incluir mensaje END --}}
            </div>
        </div>
        <div class="col-lg-1 mb-4"></div>
    </div>
@endsection
{{-- CONTENIDO END --}}
{{-- CONTENIDO JAVASCRIPT --}}
@section('contenidoJavaScript')
    
@endsection
{{-- CONTENIDO JAVASCRIPT END --}}