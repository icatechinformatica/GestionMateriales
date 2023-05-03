{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('REQUISICIÓN DE MATERIALES / CATÁLOGO DIRECTORIO / INDICE'), 'titlePage' => __('SIRMAT | Inidice de Catalogo de Directorio')])

{{-- @section('title', 'Formato de Requesición | SISCOM by ICATECH') --}}

@section('contenidoCss')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
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
