{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Revisión de Bitácora | SISCOM by ICATECH')

@section('contenidoCss')
    <link href="{{ asset('css/generalStyles.css') }}" rel="stylesheet">
    <link href="{{ asset('css/folioStyle.css') }}" rel="stylesheet">
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
                    <a href="{{ route('solicitud.catalogo.vehiculo') }}">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Nuevo Vehículo
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-car-side"></i>
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
                    <div class="card-header text-white" style="background-color: #621132;"><b>Catálogo de Vehículos</b></div>
                    <div class="card-body">
                        {{--  --}}
                        <div class="form-row">
                            <table>
                                <caption>Lista de Asignaciones</caption>
                                <thead>
                                  <tr>
                                    <th scope="col">Vehículos</th>
                                    <th scope="col">Placas</th>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Modelo</th>
                                    <th scope="col">Editar</th>
                                  </tr>
                                </thead>
                                <tbody>
                                   @if (count($catalogo) > 0)
                                    @foreach ($catalogo as $itemCat => $v)
                                        <tr>
                                            <td>
                                                <a rel="noopener noreferrer" class="btn btn-success btnModalShow">
                                                    <i class="fas fa-car-alt"></i>
                                                </a>
                                            </td>
                                            <td>{{ $v->placas }}</td>
                                            <td>{{ $v->marca }}</td>
                                            <td>{{ $v->tipo." ".$v->modelo }}</td>
                                            <td>
                                                @can('revisar bitacora')
                                                    <a rel="noopener noreferrer" href="{{ route('solicitud.cat.automovil.edit', base64_encode($v->id)) }}" class="btn btn-warning btnModalShow" data-toggle="tooltip" data-placement="top" title="CHECAR DETALLE DE LA SOLICITUD">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                   @else
                                        <tr>
                                            <td colspan="5"><center><h3> <b>NO HAY REGISTROS</b> </h3></center></td>
                                        </tr>
                                   @endif
                                </tbody>
                            </table>
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
