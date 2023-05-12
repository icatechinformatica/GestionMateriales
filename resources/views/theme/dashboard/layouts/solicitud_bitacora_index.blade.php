{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Indice de Solicitud de Bitácora | SISCOM by ICATECH')

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
            {{-- <div class="col-xl-3 col-md-6 mb-4">
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
            </div> --}}
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
                            <i class="fas fa-route"></i>
                            Solicitud Bitácora de Recorrido
                        </h6>
                    </div>
                    <div class="card-body">
                        {{-- Agregamos Información de una tabla --}}
                        <table>
                            <caption>Bitácora de Recorrido</caption>
                            <thead>
                              <tr>
                                <th scope="col">Tipo de Vehículo</th>
                                <th scope="col">Factura de Compra</th>
                                <th scope="col">Periodo</th>
                                <th scope="col">Placas</th>
                                <th scope="col">Detalles</th>
                              </tr>
                            </thead>
                            <tbody>
                                @if (count($solicitud) > 0)
                                    @foreach ($solicitud as $itemSolicitud => $v)
                                        <tr>
                                            <td data-label="Tipo de Vehículo">{{ $v->tipo }}</td>
                                            <td data-label="Factura de Compra">{{ $v->numero_factura_compra }}</td>
                                            <td data-label="Fecha">{{ $v->periodo }}</td>
                                            <td data-label="Comisionado">{{ $v->placas }}</td>
                                            <td data-label="Detalles">
                                                @switch($v->status_seguimiento_id)
                                                    @case(1)
                                                        {{-- enviado --}}
                                                        <a href="{{ route('solicitud.bitacora.detalle', base64_encode($v->id)) }}" class="btn btn-danger btn-circle btn-sm">
                                                        @break
                                                    @case(2)
                                                        <a href="{{ route('solicitud.bitacora.detalle', base64_encode($v->id)) }}" class="btn btn-warning btn-circle btn-sm">
                                                        @break
                                                    @case(3)
                                                        <a href="{{ route('solicitud.bitacora.detalle', base64_encode($v->id)) }}" class="btn btn-warning btn-circle btn-sm">
                                                    @break

                                                @endswitch
                                                    <i class="fas fa-traffic-light"></i>
                                                </a>
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
