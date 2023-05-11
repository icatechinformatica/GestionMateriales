{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Solicitud de Bitácoras Guardadas | SISCOM by ICATECH')

@section('contenidoCss')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
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
                    <a href="{{ route('solicitud.bitacora.create') }}">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Nueva Solicitud
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-plus-square fa-2x text-gray-300"></i>
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
                            solicitudes de bitácora guardadas previamente
                        </h6>
                    </div>
                    <div class="card-body">
                        {{-- Agregamos Información de una tabla --}}
                        <table>
                            <caption>Bitácora de Recorrido pre-guardados</caption>
                            <thead>
                              <tr>
                                <th scope="col">Periodo</th>
                                <th scope="col">Placas</th>
                                <th scope="col">Elaboró</th>
                                <th scope="col">Seguir Escribiendo</th>
                              </tr>
                            </thead>
                            <tbody>
                                @if (count($solicitud) > 0)
                                    @foreach ($solicitud as $itemSolicitud => $v)
                                        <tr>
                                            <td data-label="periodo">{{ $v->periodo }}</td>
                                            <td data-label="Placas">{{ $v->placas }}</td>
                                            <td data-label="elaboro">{{ $v->nombre_elabora }}</td>
                                            <td data-label="Seguir Escribiendo">
                                                <a href="{{ route('bitacora.detalle.pre.guardado', base64_encode($v->id)) }}" class="btn btn-warning btn-circle btn-sm">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </td>
                                      </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3"><center><h3> <b>NO HAY REGISTROS PARA MOSTRAR</b> </h3></center></td>
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
