{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Formulario de Vehiculos | SISCOM by ICATECH')

@section('contenidoCss')
 <link rel="stylesheet" href="{{ asset('css/cat.css') }}">
@endsection

@section('contenido')



{{-- Content Row --}}
    <div class="row">
        {{-- Columna de contenido --}}
            <div class="col-lg-12 mb-4">
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ $message }}
                    </div>
                @endif
                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-car"></i> VEHICULO CON PLACAS - {{ $getvehiculo->placas }}</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('solicitud.cat.automovil.update', base64_encode($getvehiculo->id)) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="marca_editar">Marca</label>
                                    <div class="custom-file">
                                        <input type="text" name="marca_editar" id="marca_editar" class="@error('marca_editar') is-invalid @enderror form-control" autocomplete="off" value="{{ $getvehiculo->marca }}">
                                        @error('marca_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="modelo_editar">Modelo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="modelo_editar" name="modelo_editar" autocomplete="off" value="{{ $getvehiculo->modelo }}">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="placas_editar">Placas</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('placas_editar') is-invalid @enderror typeahead form-control" id="placas_editar" name="placas_editar" autocomplete="off" value="{{ $getvehiculo->placas }}">
                                        @error('placas_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="color_editar">Color</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('color_editar') is-invalid @enderror typeahead form-control" id="color_editar" name="color_editar" autocomplete="off" value="{{ $getvehiculo->color }}">
                                        @error('color_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="numero_motor_editar">Número Motor</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('numero_motor_editar') is-invalid @enderror typeahead form-control" id="numero_motor_editar" name="numero_motor_editar" autocomplete="off" value="{{ $getvehiculo->numero_motor }}">
                                        @error('numero_motor_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tipo_editar">Tipo</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('tipo_editar') is-invalid @enderror typeahead form-control" id="tipo_editar" name="tipo_editar" autocomplete="off" value="{{ $getvehiculo->tipo }}">
                                        @error('tipo_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="numero_serie_editar">Número de Serie</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('numero_serie_editar') is-invalid @enderror typeahead form-control" id="numero_serie_editar" name="numero_serie_editar" autocomplete="off" value="{{ $getvehiculo->numero_serie }}">
                                        @error('numero_serie_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="placas">Resguardante</label>
                                    <div class="custom-file">
                                        <select name="resguardante_editar" id="resguardante_editar" class="@error('resguardante') is-invalid @enderror typeahead form-control">
                                            @foreach ($resguardante as $res => $j)
                                                <option value="{{ $j->id }}" {{ $j->id == $getvehiculo->resguardante_id ? 'selected': '' }}>{{ $j->resguardante_unidad }}</option>
                                            @endforeach
                                        </select>
                                        @error('resguardante_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="numero_economico">Número Económico</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('numero_economico_editar') is-invalid @enderror typeahead form-control" id="numero_economico_editar" name="numero_economico_editar" autocomplete="off" value="{{ $getvehiculo->numero_economico }}">
                                        @error('numero_economico_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                           {{-- kilometros recorridos --}}
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="km_recorrido_editar">Kilometros Recorridos</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('km_recorrido_editar') is-invalid @enderror typeahead form-control" id="km_recorrido_editar" name="km_recorrido_editar" autocomplete="off" onkeypress="return valideKey(event, this);" value="{{ $getvehiculo->km_final }}">
                                        @error('km_recorrido_editar')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                           {{-- kilomentros recorridos END --}}
                            <span class="d-block g-mb-3 g-font-size-22 g-color-gray-dark-v1 g-font-secondary">
                                <b>RENDIMIENTOS</b>
                            </span>
                            <hr class="g-brd-gray-light-v4">
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="rendimiento_ciudad">Rendimiento de la ciudad</label>
                                    <div class="custom-file">
                                        <input type="text" name="rendimiento_ciudad" id="rendimiento_ciudad" class="form-control" autocomplete="off" onkeypress="return valideKey(event, this);">

                                    </div>
                                </div>
                            {{-- rendimiento en carretera --}}
                                <div class="col-md-3 mb-3">
                                    <label for="rendimiento_carretera">Rendimiento en Carretera</label>
                                    <div class="custom-file">
                                        <input type="text" name="rendimiento_carretera" id="rendimiento_carretera" class="form-control" autocomplete="off" onkeypress="return valideKey(event, this);" value="{{ $getvehiculo->rendimiento_carretera }}">
                                    </div>
                                </div>
                                {{-- rendimiento en carretera END --}}
                                {{--  rendimiento Mixto--}}
                                <div class="col-md-3 mb-3">
                                    <label for="rendimiento_mixto">Rendimiento en Mixto</label>
                                    <div class="custom-file">
                                        <input type="text" name="rendimiento_mixto" id="rendimiento_mixto" class="form-control" autocomplete="off" onkeypress="return valideKey(event, this);" value="{{ $getvehiculo->rendimiento_mixto }}">
                                    </div>
                                </div>
                                {{-- rendimiento Mixto END --}}
                                {{-- rendimiento carga--}}
                                <div class="col-md-3 mb-3">
                                    <label for="rendimiento_carga">Rendimiento de Carga</label>
                                    <div class="custom-file">
                                        <input type="text" name="rendimiento_carga" id="rendimiento_carga" class="form-control" autocomplete="off" onkeypress="return valideKey(event, this);" value="{{ $getvehiculo->rendimiento_carga }}">
                                    </div>
                                </div>
                                {{-- rendimiento carga END --}}
                            </div>
                            <hr>

                            <button class="btn btn-warning" type="submit">
                                <i class="fas fa-edit"></i>
                                MODIFICAR
                            </button>
                            <input type="hidden" name="periodo_actual" id="periodo_actual" value="">
                        </form>
                    </div>
                </div>

            </div>
        {{-- Columna de contenido END --}}

    </div>
{{-- Content Row END --}}


@endsection

@section('contenidoJavaScript')
<script type="text/javascript">

    function valideKey(evt, element){
            let charCode = (evt.wich) ? evt.wich : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57) && !(charCode == 46 || charCode == 8)) {
                return false;
            } else {
                let len = $(element).val().length;
                let index = $(element).val().indexOf('.');
                if (index > 0 && charCode == 46) {
                    return false;
                }
                if (index > 0) {
                    let CharAfterdot = (len + 1) - index;
                    if (CharAfterdot > 2) {
                        return false;
                    }
                }
            }
            return true;
    }
</script>
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
