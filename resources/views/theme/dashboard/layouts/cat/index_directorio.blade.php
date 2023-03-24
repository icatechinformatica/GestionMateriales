{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('REQUISICIÓN DE MATERIALES / CATÁLOGO DIRECTORIO / INDICE'), 'titlePage' => __('SIRMAT | Inidice de Catalogo de Directorio')])

{{-- @section('title', 'Formato de Requesición | SISCOM by ICATECH') --}}

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
                <div class="row g-2">
                    <div class="col-md-3">
                        <p>
                            <a href="{{ route('cat.directorio.create') }}" class="btn btn-success">
                                <i class="fas fa-user-plus"></i>
                                Nueva Entrada
                            </a>
                        </p>
                    </div>
                    <form method="GET" class="mb-5">
                        <div class="input-group col-mb-4">
                            
                                <input 
                                type="text" 
                                name="busqueda" 
                                class="form-control" 
                                placeholder="BUSCAR..." 
                                aria-label="Search" 
                                aria-describedby="button-addon2"
                                autocomplete="off"
                                value="{{ request()->get('busqueda') }}"/>
                                <button class="btn btn-primary" type="submit" id="button-addon2">
                                    <i class="fas fa-search"></i>
                                </button>
                        </div>
                    </form>
                    <table>
                        <caption>Directorio de Funcionarios</caption>
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Puesto</th>
                                <th scope="col">Área de adscripción</th>
                                <th scope="col">Activo</th>
                                <th scope="col">Modificar</th>
                            </tr>
                        </thead>
                        <tbody>
                           @if (count($getDirectorio) > 0)
                                {{-- si hay registros --}}
                               @foreach ($collection as $k => $v)
                                    <tr>
                                        <td data-label="Nombre">fdfsdsfdfds</td>
                                        <td data-label="Puesto">fdsdfs</td>
                                        <td data-label="Área de adscripción">sdfsdffds</td>
                                        <td data-label="Activo">sfdsdffd</td>
                                        <td data-label="Modificar">dsfdsffsd</td>
                                    </tr>
                               @endforeach
                           @else
                               {{-- si no hay registros --}}
                                <tr>
                                    <td colspan="5"><center><h3> <b>NO HAY REGISTROS PARA MOSTRAR</b> </h3></center></td>
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
       {{-- @include('theme.dashboard.layouts.requesicion.modal.requisicion_enviar_moda') --}}
    </div>
@endsection

@section('contenidoJavaScript')
    
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}