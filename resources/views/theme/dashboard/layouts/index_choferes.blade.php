{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Solicitud de Bitácoras Guardadas | SISCOM by ICATECH')

@section('contenidoCss')
    <link href="{{ asset('css/generalStyles.css') }}" rel="stylesheet">
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
        @if (auth()->user()->can('crear catalogo resguardante'))
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <a href="{{ route('solicitud.cat.chofer.create') }}">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Chofer
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-id-card-alt fa-2x text-gray-300"></i>
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
                            <i class="fas fa-id-card-alt"></i>
                            Registro de Choferes
                        </h6>
                    </div>
                    <div class="card-body">
                        {{-- Agregamos Información de una tabla --}}
                        <table>
                            <caption>Catálogo de Choferes</caption>
                            <thead>
                              <tr>
                                <th scope="col">Chofer</th>
                                <th scope="col">Detalles</th>
                              </tr>
                            </thead>
                            <tbody>
                                @if (count($getAllChoferes) > 0)
                                    @foreach ($getAllChoferes as $itemchofer => $v)
                                        <tr>
                                            <td data-label="Chofer">{{ $v->nombre }}</td>
                                            <td data-label="Detalles">
                                                <a href="{{ route('solicitud.cat.chofer.edit', base64_encode($v->id)) }}" class="btn btn-info btn-circle btn-sm fa-2x">
                                                    <i class="fas fa-id-card-alt"></i>
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
