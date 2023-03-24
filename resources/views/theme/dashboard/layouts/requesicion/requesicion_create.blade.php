{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('REQUISICIÓN DE MATERIALES / INDICE'), 'titlePage' => __('SIRMAT | Inidice Requisición de Materiales')])

@section('title', 'Formato de Requesición | SISCOM by ICATECH')

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
                <p>
                    <a href="{{ route('requisicion.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i>
                        Nueva Requisición
                    </a>
                </p>
                <table>
                    <caption>Requisiciones</caption>
                    <thead>
                        <tr>
                            <th scope="col">Partida Presupuestal</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Ver/Modificación</th>
                            <th scope="col">Memo</th>
                            <th scope="col">Enviar</th>
                        </tr>
                    </thead>
                    <tbody>
                       @if (count($requisiciones) > 0)
                          @foreach ($requisiciones as $k => $v)
                            <tr>
                                <td data-label="Partida Presupuestal">
                                    @foreach ($v->partidapresupuestal as $item => $val)
                                        {{ $val['partida_presupuestal']."," }}<br>
                                    @endforeach
                                </td>
                                <td data-label="Departamento">{{ $v->area->nombre }}</td>
                                <td data-label="Ver/Modificación">
                                    <a  href="{{ route('requisicion.show', ['id' => base64_encode($v->id)]) }}" class="btn btn-info btn-circle btn-sm">
                                        <i class="fas fa-keyboard fa-1x"></i>
                                    </a>
                                </td>

                               @if (isset($v->memorandum))
                                    @if ($v->memorandum->cargado == true)
                                        <td data-label="Memo">
                                            <a href="{{ ($v->memorandum->cargado == true) ? route('requisicion.memo.edit', ['id' => base64_encode($v->id)]) : ''}}" class="btn btn-primary btn-circle btn-sm">
                                                <i class="fas fa-file-alt fa-1x"></i>
                                            </a>
                                        </td>
                                    @endif
                               @else
                                    <td data-label="Memo">
                                        <a href="{{ route('requisicion.memo.create', ['idrequisicion' => base64_encode($v->id)]) }}" class="btn btn-success btn-circle btn-sm">
                                            <i class="fas fa-file-alt fa-1x"></i>
                                        </a>
                                    </td> 
                               @endif
                                
                                <td data-label="Enviar">

                                   @if (isset($v->memorandum->cargado))
                                       <a class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#exampleModal-{{ $v->id }}">
                                            <i class="fas fa-paper-plane fa-1x"></i>
                                        </a>
                                   @else
                                    <a class="btn btn-dark btn-circle btn-sm">
                                        <i class="fas fa-paper-plane fa-1x" ></i>
                                    </a>
                                   @endif
                                </td>
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
       @include('theme.dashboard.layouts.requesicion.modal.requisicion_enviar_moda')
    </div>
@endsection

@section('contenidoJavaScript')
    
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
