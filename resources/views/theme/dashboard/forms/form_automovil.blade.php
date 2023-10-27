{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Formulario de Vehiculos | SISCOM by ICATECH')

@section('contenidoCss')
    <link href="{{ asset('css/generalStyles.css') }}" rel="stylesheet">
@endsection

@section('contenido')



    {{-- Content Row --}}
    <div class="row">
        {{-- Columna de contenido --}}
        <div class="col-lg-12 mb-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div> <br>
            @endif
            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-car"></i> Vehiculos </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('solicitud.catalogo.store') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="fecha">Marca</label>
                                <div class="custom-file">
                                    <input type="text" name="marca" id="marca"
                                        class="@error('marca') is-invalid @enderror form-control">
                                    @error('marca')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="periodo">Modelo</label>
                                <div class="custom-file">
                                    <input type="text"
                                        class="form-control @error('rendimiento_ciudad') is-invalid @enderror"
                                        id="modelo" name="modelo" autocomplete="off">
                                    @error('placas')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="placas">Placas</label>
                                <div class="custom-file">
                                    <input type="text" class="@error('placas') is-invalid @enderror form-control"
                                        id="placas" name="placas" autocomplete="off">
                                    @error('placas')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="placas">Color</label>
                                <div class="custom-file">
                                    <input type="text" class="@error('color') is-invalid @enderror form-control"
                                        id="color" name="color" autocomplete="off">
                                    @error('color')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="placas">Número Motor</label>
                                <div class="custom-file">
                                    <input type="text" class="@error('numero_motor') is-invalid @enderror form-control"
                                        id="numero_motor" name="numero_motor" autocomplete="off">
                                    @error('numero_motor')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="placas">Tipo</label>
                                <div class="custom-file">
                                    <input type="text" class="@error('tipo') is-invalid @enderror form-control"
                                        id="tipo" name="tipo" autocomplete="off">
                                    @error('tipo')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="placas">Número de Serie</label>
                                <div class="custom-file">
                                    <input type="text" class="@error('numero_serie') is-invalid @enderror form-control"
                                        id="numero_serie" name="numero_serie" autocomplete="off">
                                    @error('numero_serie')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="placas">Resguardante</label>
                                <div class="custom-file">
                                    <input type="text"
                                        class="@error('resguardante') is-invalid @enderror typeahead form-control"
                                        id="resguardante" name="resguardante" autocomplete="off">
                                    @error('resguardante')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="numero_economico">Número Económico</label>
                                <div class="custom-file">
                                    <input type="text"
                                        class="@error('numero_economico') is-invalid @enderror form-control"
                                        id="numero_economico" name="numero_economico" autocomplete="off">
                                    @error('numero_economico')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="km_recorrido">Kilometros Recorridos</label>
                                <div class="custom-file">
                                    <input type="text" class="@error('km_recorrido') is-invalid @enderror form-control"
                                        id="km_recorrido" name="km_recorrido" autocomplete="off"
                                        onkeypress="return valideKey(event);">
                                    @error('km_recorrido')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <span class="d-block g-mb-3 g-font-size-22 g-color-gray-dark-v1 g-font-secondary">
                            <b>RENDIMIENTOS</b>
                        </span>
                        <hr class="g-brd-gray-light-v4">
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="rendimiento_ciudad">Rendimiento de la ciudad</label>
                                <div class="custom-file">
                                    <input type="text" name="rendimiento_ciudad" id="rendimiento_ciudad"
                                        class="form-control" autocomplete="off"
                                        onkeypress="return isNumberKey(event, this);">
                                    @error('rendimiento_ciudad')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- rendimiento en carretera --}}
                            <div class="col-md-3 mb-3">
                                <label for="rendimiento_carretera">Rendimiento en Carretera</label>
                                <div class="custom-file">
                                    <input type="text" name="rendimiento_carretera" id="rendimiento_carretera"
                                        class="form-control" autocomplete="off"
                                        onkeypress="return isNumberKey(event, this);">
                                    @error('rendimiento_carretera')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- rendimiento en carretera END --}}
                            {{--  rendimiento Mixto --}}
                            <div class="col-md-3 mb-3">
                                <label for="rendimiento_mixto">Rendimiento en Mixto</label>
                                <div class="custom-file">
                                    <input type="text" name="rendimiento_mixto" id="rendimiento_mixto"
                                        class="form-control" autocomplete="off"
                                        onkeypress="return isNumberKey(event, this);">
                                    @error('rendimiento_mixto')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- rendimiento Mixto END --}}
                            {{-- rendimiento carga --}}
                            <div class="col-md-3 mb-3">
                                <label for="rendimiento_carga">Rendimiento de Carga</label>
                                <div class="custom-file">
                                    <input type="text" name="rendimiento_carga" id="rendimiento_carga"
                                        class="form-control" autocomplete="off"
                                        onkeypress="return isNumberKey(event, this);">
                                    @error('rendimiento_carga')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- rendimiento carga END --}}
                        </div>
                        <hr>

                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-save"></i>
                            Guardar
                        </button>
                        <input type="hidden" name="periodo_actual" id="periodo_actual" value="">
                        <input type="hidden" name="resguardante_id" id="resguardante_id">
                    </form>
                </div>
            </div>

        </div>
        {{-- Columna de contenido END --}}

    </div>
    {{-- Content Row END --}}


@endsection

@section('contenidoJavaScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/js_/typehead.min.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $(document).ready(function() {
            const path = "{{ route('search.resguardante') }}";
            $('input.typeahead').typeahead({
                source: function(query, process) {
                    return $.get(path, {
                        term: query
                    }, function(data) {
                        return process(data);
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        console.log(`error ${jqXHR.responseText}`);
                    });
                }
            });

            $('input.typeahead').focus(async function() {
                if ($('input.typeahead').val().length != 0) {
                    const url = "{{ route('assign.resguardante.load') }}";
                    const param = {
                        "type": $('input.typeahead').val()
                    };
                    // checar el valor
                    const result = await $.ajax({
                        data: param,
                        url: url,
                        type: 'POST',
                        beforeSend: function() {
                            console.log('Procesando, espere por favor...');
                        },
                        success: function(response) {
                            /*
                             * para argumentos a los inputs
                             */
                            $('#resguardante_id').val(response.id);
                        },
                        error: function(request, status, error) {
                            console.log(request.responseText);
                        }
                    })

                    return result;
                }
            });
        });

        function valideKey(evt) {

            // code is the decimal ASCII representation of the pressed key.
            var code = (evt.which) ? evt.which : evt.keyCode;

            if (code == 8) { // backspace.
                return true;
            } else if (code >= 48 && code <= 57) { // is a number.
                return true;
            } else { // other keys.
                return false;
            }
        }

        function isNumberKey(evt, element) {
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
                    if (CharAfterdot > 3) {
                        return false;
                    }
                }
            }
            return true;
        }
    </script>
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
