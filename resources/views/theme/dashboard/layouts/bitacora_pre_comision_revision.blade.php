{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Revisión Pre Comisión | SISCOM by ICATECH')

@section('contenidoCss')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
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
{{-- agregar tabla responsiva --}}
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">Memorandum</th>
                                    <th scope="col">Placas</th>
                                    <th scope="col">Rendimiento</th>
                                    <th scope="col">Revisión</th>
                                    <th scope="col">Generar Documento</th>
                                </tr>
                            </thead>
                            <tbody>
                               @if (count($revisarPreComision) > 0)
                                  @foreach ($revisarPreComision as $itemPreComisionRevisar => $v)
                                    <tr>
                                        <td data-label="Memorandum"><b>{{ $v->memorandum_comision }}</b></td>
                                        <td data-label="Placas">{{ $v->placas_vehiculo }}</td>
                                        <td data-label="Rendimiento">{{ $v->rendimiento }}</td>
                                        <td data-label="Revisión">
                                            @can('revisar comision')
                                               @switch($v->status_seguimiento_id)
                                                   @case(5)
                                                        <a href="{{ route('solicitud.pre.comision.revision.detalle', [base64_encode($v->id), base64_encode($v->status_seguimiento_id)]) }}" class="btn btn-success btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="COMISIÓN LISTA">
                                                            <i class="fas fa-check-circle"></i>
                                                        </a>
                                                    @break
                                                   @default
                                                        <a href="{{ route('solicitud.pre.comision.revision.detalle', [base64_encode($v->id), base64_encode($v->status_seguimiento_id)]) }}" class="btn btn-primary btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="REVISAR LA COMISIÓN">
                                                            <i class="fas fa-search"></i>
                                                        </a>
                                               @endswitch
                                            @endcan
                                        </td>
                                        <td data-label="Generar Documento">
                                           @switch($v->status_seguimiento_id)
                                                @case(5)
                                                    <a href="{{ route('generar.reporte.bitacora.pdf', base64_encode($v->solicitud_id)) }}" target="_blank" class="btn btn-danger  btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="GENERAR BITÁCORA">
                                                        <i class="far fa-file-pdf fa-1x"></i>
                                                    </a>
                                                @break
                                               @default
                                                <a href="javascript:;" class="btn btn-primary  btn-circle btn-md" data-toggle="tooltip" data-placement="top" title="GENERAR BITÁCORA">
                                                    <i class="fas fa-unlink"></i>
                                                </a>
                                           @endswitch

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
{{-- agregar table responsiva END --}}

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
