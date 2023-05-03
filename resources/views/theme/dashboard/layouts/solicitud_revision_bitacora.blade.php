{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Revisión de Bitácora | SISCOM by ICATECH')

@section('contenidoCss')
    <link href="{{ asset('css/generalStyles.css') }}" rel="stylesheet">
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
                            <i class="fas fa-search-location"></i>
                            Revisión de Bitácora
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="marca_vehiculo">FILTRAR MES</label>
                                <div class="custom-file">
                                    <select class="form-control" name="mes_filtrado" id="mes_filtrado">
                                        <option value="">---- SELECCIONAR ----</option>
                                        @foreach ($meses as $k => $v)
                                         <option value="{{ $v }}">{{ $k }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="marca_vehiculo">FILTRAR PERIODO</label>
                                <div class="custom-file">
                                    <select class="form-control" name="periodo_filtrado" id="periodo_filtrado">
                                        <option value="">---- SELECCIONAR ----</option>
                                        <option value="1">PRIMER PERIODO</option>
                                        <option value="2">SEGUNDO PERIODO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="modelo">&nbsp;</label>
                                <div class="custom-file">
                                    <button class="btn btn-info">
                                        <i class="fas fa-filter"></i>
                                        Filtrar
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{--  --}}
                        <div class="form-row">
{{-- tabla de chequeo de bitácora de recorrido --}}
                            <table>
                                <thead>
                                    <tr>
                                        <th scope="col">Placas</th>
                                        <th scope="col">Periodo</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">...</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if (count($solicitudRevision) > 0)
                                      @foreach ($solicitudRevision as $itemSolicitud => $v)
                                        <tr>
                                          <td data-label="Placas">{{ $v->placas }}</td>
                                          <td data-label="Periodo">{{ $v->periodo }}</td>
                                          <td data-label="Tipo">
                                            @switch($v->es_comision)
                                                @case(1)
                                                    BITÁCORA DE <b>COMISIONADO</b>
                                                @break
                                                @default
                                                    BITÁCORA DE <b>RECORRIDO</b>
                                            @endswitch
                                          </td>
                                          <td data-label="...">
                                            @can('revisar bitacora')
                                                @switch($v->estado)
                                                    @case('ENVIADO')
                                                        {{-- btn-danger --}}
                                                        <a href="{{ route('revision.bitacora.detalle', base64_encode($v->id)) }}" class="btn btn-danger btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="CHECAR DETALLE DE LA SOLICITUD">
                                                    @break
                                                    @case('REVISION')
                                                        {{-- btn-warning --}}
                                                        <a href="{{ route('revision.bitacora.detalle', base64_encode($v->id)) }}" class="btn btn-warning btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="CHECAR DETALLE DE LA SOLICITUD">
                                                        @break
                                                    @case('REVISADO')
                                                        {{-- btn-warning --}}
                                                        <a href="{{ route('revision.bitacora.detalle', base64_encode($v->id)) }}" class="btn btn-warning btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="CHECAR DETALLE DE LA SOLICITUD">
                                                        @break
                                                    @case('FINALIZADO')
                                                        {{-- btn-success --}}
                                                        <a href="{{ route('revision.bitacora.detalle', base64_encode($v->id)) }}" class="btn btn-success btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="CHECAR DETALLE DE LA SOLICITUD">
                                                    @break

                                                @endswitch
                                                        <i class="fas fa-traffic-light"></i>
                                                    </a>
                                            @endcan
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
{{-- tabla de chequeo de bitácora de recorrido END --}}
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
