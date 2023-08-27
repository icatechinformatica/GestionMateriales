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

{{-- Content Row --}}
    <div class="row">
        {{-- Columna de contenido --}}
            <div class="col-lg-12 mb-4">

                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-layer-group"></i>
                            Solicitud de Bitácora
                        </h6>
                    </div>
                    <div class="card-body">
                        {{-- Agregamos Información de una tabla --}}
                        <table>
                            <caption>Bitácora de Recorrido pre-guardados</caption>
                            <thead>
                              <tr>
                                <th scope="col">Placa</th>
                                <th scope="col">Módelo</th>
                                <th scope="col">Número de Serie</th>
                                <th scope="col">Generar Bitácora</th>
                              </tr>
                            </thead>
                            <tbody>
                                @if (count($solicitud) > 0)
                                    @foreach ($solicitud as $itemSolicitud => $v)
                                        <tr>
                                            <td data-label="Placa"><i class="fas fa-tag"></i> {{ $v->placas }}</td>
                                            <td data-label="Módelo">{{ $v->marca." ".$v->tipo." ".$v->modelo }}</td>
                                            <td data-label="Número de Serie">{{ $v->numero_serie }}</td>
                                            <td data-label="Generar Bitácora">
                                                <a href="{{ route('bitacora.detalle.pre.guardado', base64_encode($v->id)) }}" class="btn btn-success">
                                                    <i class="fas fa-route"></i>
                                                </a>
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
