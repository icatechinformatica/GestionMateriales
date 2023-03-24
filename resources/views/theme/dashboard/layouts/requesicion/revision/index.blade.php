{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('REQUISICIÓN DE MATERIALES / Revisión - Indice'), 'titlePage' => __('SIRMAT | Revisión de las solicitudes de Requisición')])

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

@section('contenido')
    <div class="row">
        <div class="col-lg-1 mb-4">
        </div>
        <div class="col-lg-10 mb-4">
            <div class="bd-example">
                <table>
                    <caption>Solicitud Para Revisión</caption>
                    <thead>
                        <tr>
                            <th scope="col">Partida Presupuestal</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Fecha de Envio</th>
                            <th scope="col">Validar</th>
                            <th scope="col">Retornar</th>
                            <th scope="col">Enviar</th>
                        </tr>
                    </thead>
                    <tbody>
                       @if (count($requisicion_por_revisar) > 0)
                        @php
                            $meses = [
                                            "Enero","Febrero","Marzo","Abril",
                                            "Mayo","Junio","Julio","Agosto",
                                            "Septiembre","Octubre","Noviembre","Diciembre"
                                ];
                        @endphp
                          @foreach ($requisicion_por_revisar as $k => $v)
                            @php
                                // variable para pasar a español la fecha que tilizamos
                                $fecha = Carbon\Carbon::parse($v->created_at);
                                $mes = $meses[($fecha->format('n')) - 1];
                            @endphp
                            <tr>
                                <td data-label="Partida Presupuestal">
                                    @foreach ($v->partidapresupuestal as $item => $val)
                                        <b>{{ $val['partida_presupuestal'].", " }}</b><br/>
                                    @endforeach
                                </td>
                                <td data-label="Departamento">{{ strtoupper($v->area->nombre) }}</td>
                                <td data-label="Fecha de Envio">{{ $fecha->format('d') . ' DE ' . strtoupper($mes) . ' DE ' . $fecha->format('Y') }}</td>
                                <td data-label="Validar">
                                    <a href="{{ route('requisicion.revision.check', ['id' => base64_encode($v->id)]) }}" class="btn btn-info btn-circle btn-sm">
                                        <i class="fas fa-check"></i>
                                    </a>
                                </td>
                              @if ($v->id_estado === 2)
                                {{-- aquí vamos a cargar los datos si la condición se cumple --}}
                                <td data-label="Retornar">
                                    <button type="button" @class(['btn btn-danger btn-circle btn-sm', 'font-bold' => true ]) data-toggle="modal" data-target="#modalRevision-" data-opcion="{{ $MyValue = 'RETURN' }}" data-valorid="{{ base64_encode($v->id) }}">
                                        <i @class(['fas fa-undo', 'font-bold' => true])></i>
                                    </button>
                                </td>
                                <td data-label="Enviar">
                                    <button type="button" @class(['btn btn-success btn-circle btn-sm', 'font-bold' => true]) data-toggle="modal" data-target="#modalRevision-" data-opcion="{{ $MyValue = 'SEND' }}" data-valorid={{ base64_encode($v->id) }}>
                                        <i @class(['fas fa-paper-plane'])></i>
                                    </button>
                                </td>
                              @else
                                <td data-label="Retornar"></td>
                                <td data-label="Enviar"></td>
                              @endif
                            </tr>
                          @endforeach
                       @else
                            <tr>
                                <td colspan="5"><center><h3> <b>NO HAY REGISTROS PARA MOSTRAR</b> </h3></center></td>
                            </tr>
                       @endif
                    </tbody>
                </table>
                {{-- incluir mensaje --}}
                @include('theme.dashboard.messages.flash_message')
                {{-- incluir mensaje END --}}
            </div>
        </div>
        <div class="col-lg-1 mb-4"></div>
       @include('theme.dashboard.layouts.requesicion.modal.modal_revision')
    </div>
@endsection

@section('contenidoJavaScript')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        /**
         * cargarmos jQuery en el dom
        */
       (() => {
            // funcion anonima

       })();

       $('#modalRevision-').on('show.bs.modal', function (event){
            var boton = $(event.relatedTarget); //botón que activó el modal
            var opcion = boton.data('opcion'); //extraer la información
            var idRequisicion = boton.data('valorid');
            // checamos el valor de la variable
            switch (opcion) {
                case 'RETURN':
                    var titulo = 'REGRESAR LA SOLICITUD';
                    var cuerpo = '¿DESEA REGRESAR LA SOLICITUD A SU REMITENTE?';
                    var variable_envio = 1;
                    break;
                case 'SEND':
                    var titulo = 'ENVIAR LA SOLICITUD';
                    var cuerpo = '¿DESEA ENVIAR LA SOLICITUD A LA ENCARGADA DE ASIGNAR LA REQUISICIÓN?';
                    var variable_envio = 2;
                    break;
                default:
                    break;
            }
            var modal = $(this);
            modal.find('.modal-title').text(titulo);
            modal.find('.modal-body').text(cuerpo);
            modal.find('.modal-footer input#variable').val(variable_envio);
            modal.find('.modal-footer input#valor').val(idRequisicion);
       })
    </script>
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
