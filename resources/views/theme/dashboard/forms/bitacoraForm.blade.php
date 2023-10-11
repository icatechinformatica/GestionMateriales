{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __(' Inicio /Bitácora / Generar'), 'titlePage' => __('SIRMAT | BITÁCORA DE RECORRIDO - GUARDADO')])


@section('contenidoCss')
    <link rel="stylesheet" href="{{ asset('css/generalStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/validateError.css') }}">
    <link href="{{ asset('css/folioCreateStyle.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/heading.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loaderspinner.css') }}">
    <link href="{{ asset('css/folioStyle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modalsuccess.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/js/scripts/multipleselect/multiple-select.min.css') }}">
@endsection

@section('contenido')

    <div class="container-fluid dark-nav">
        <div class="row">
            <div class="col-lg-12 md-4 posicionamiento_flotante">
                <div id="cover-spin"></div>
                <div class="card shadow mb-4">
                    <div class="card-header text-white" style="background-color: #621132;"><i
                            class="fas fa-map-marked-alt"></i> <b>Seguimiento de la Bitácora de recorrido</b></div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="bg-light form-inline"
                                style="padding:15px 0 15px 0; text-indent:1.8em; line-height: 2.1em;">
                                <span>N° de Motor:&nbsp;<strong>{{ $solDetalle->numero_motor }}</strong></span>
                                <span>Color:&nbsp;<strong>{{ $solDetalle->color }}</strong></span>
                                <span>Fecha:&nbsp;<strong></strong></span>

                                <span>Período&nbsp;<strong></strong></span>
                                <span>Vehículo Marca:&nbsp;<strong>{{ $solDetalle->marca }}</strong></span>

                                <span>Modelo:&nbsp;<strong>{{ $solDetalle->modelo }}</strong></span>
                                <span>Tipo:&nbsp;<strong>{{ $solDetalle->tipo }}</strong></span>

                                <span>Placas:&nbsp;<strong>{{ $solDetalle->placas }}</strong></span>
                                <span>Serie:&nbsp;<strong>{{ $solDetalle->numero_serie }}</strong></span>

                                <span>Resguardante:&nbsp;<strong>{{ $solDetalle->resguardante_unidad }}</strong></span>
                                <span>Puesto
                                    Resguardante:&nbsp;<strong>{{ $solDetalle->puesto_resguardante_unidad }}</strong></span>

                                <span>Kilometraje Inicial:&nbsp;<strong>{{ $solDetalle->km_final }}</strong></span>
                                <span>N° de Factura de Compra:&nbsp;<strong>{{ $solDetalle->facturaserie }}</strong></span>
                            </div>
                        </div>
                        <hr>
                        <div class="alert alert-danger alertMessage" style="display: none" role="alert">
                            Los Importes de Gasolina y Folios deben ser exactos!
                        </div>
                        {{-- abrir formulario --}}
                        {!! Form::open([
                            'method' => 'POST',
                            'enctype' => 'multipart/form-data',
                            'id' => 'frmBitacoraRecorrido',
                            'autocomplete' => 'off',
                        ]) !!}
                        <div class="form-row">
                            <div class="col-md-2">
                                {!! Form::label('chkcomisionLabel', '¿Es comisionado?', ['id' => 'chkcomisionLabel']) !!}
                                <div class="custom-file">
                                    <div class="form-switch">
                                        <input class="form-check-input" name="chkcomision" type="checkbox" role="switch"
                                            id="chkcomision" {{ $esComision == 1 ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('comisionlabel', 'N° de Comisión', ['id' => 'comisionlabel']) !!}
                                <div class="custom-file">
                                    {!! Form::text('numero_comision', null, [
                                        'class' => 'form-control',
                                        'id' => 'numero_comision',
                                        $esComision == 1 ? '' : 'readonly',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('facturalabel', 'N° Factura', ['id' => 'facturalabel']) !!}
                                <div class="custom-file">
                                    {!! Form::text('numero_factura', null, [
                                        'class' => 'form-control',
                                        'id' => 'numero_factura',
                                        $esComision == 1 ? '' : 'readonly',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                {!! form::label('rendimientovehiculolabel', 'Rendimiento Vehículo (km * lts)', [
                                    'id' => 'rendimientovehiculolabel',
                                ]) !!}
                                <div class="custom-file">
                                    <select name="rendimientovehiculo" id="rendimientovehiculo" class="form-control">
                                        <option value="">-- SELECCIONAR RENDIMIENTO --</option>
                                        @foreach ($rendimientos as $item => $v)
                                            @php
                                                $var = explode('-', $v);
                                            @endphp
                                            <option value="{{ trim($var[1]) }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    {!! Form::label('fechaEntradaLabel', 'Fecha') !!}
                                    {!! Form::date('fechaEntrada', \Carbon\Carbon::now(), ['id' => 'fechaEntrada', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    {!! Form::label('kmInicialLabel', 'Kilométro Inicial') !!}
                                    {!! Form::text('kmInicial', $solDetalle->km_final, ['class' => 'form-control', 'id' => 'kmInicial']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    {!! Form::label('kmFinalLabel', 'Kilométro Final') !!}
                                    {!! Form::text('kmFinal', null, ['class' => 'form-control', 'id' => 'kmFinal']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    {!! Form::label('kmrecorridoLabel', 'Kilométros Recorridos') !!}
                                    {!! Form::text('kmrecorrido', null, ['class' => 'form-control', 'id' => 'kmrecorrido', 'readonly']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    {{ Form::label('delabel', 'Origen:', ['class' => 'control-label']) }}
                                    {{ Form::textarea('de', '', array_merge(['class' => 'form-control'], ['id' => 'de', 'cols' => 10, 'rows' => 2])) }}
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    {{ Form::label('alabel', 'Destino:', ['class' => 'control-label']) }}
                                    {{ Form::textarea('a', '', array_merge(['class' => 'form-control'], ['id' => 'a', 'cols' => 10, 'rows' => 2])) }}
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                {!! Form::label('folio_inicial_finalLabel', 'Folio Inicial -- Final') !!}
                                <select id="folio_inicial_final" name="folio_inicial_final[]" multiple>
                                    @if (count($getFolios) > 0)
                                        @foreach ($getFolios as $key => $value)
                                            <option value="{{ $value->id . '|' . $value->denominacion }}"
                                                {{ $value->utilizado == 1 ? 'selected' : '' }}>
                                                {{ $value->numero_folio }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    {!! Form::label('ltlLabel', 'Litros') !!}
                                    {!! Form::text('litros', '', [
                                        'class' => 'form-control',
                                        'id' => 'litros',
                                        'onkeypress' => 'return isNumberKey(event, this)',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    {!! Form::label('precioporlitroLabel', 'Precio x Litro (gasolina)') !!}
                                    {!! Form::text('precioporlitro', '', [
                                        'class' => 'form-control',
                                        'id' => 'precioporlitro',
                                        'onkeypress' => 'return isNumberKey(event, this)',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    {!! Form::label('importeLabel', 'Importe gasolina') !!}
                                    {!! Form::text('importe', '', [
                                        'class' => 'form-control',
                                        'id' => 'importe',
                                        'onkeypress' => 'return isNumberKey(event, this)',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="form-group">
                                    {!! Form::label('importefoliosLabel', 'Importe folios') !!}
                                    {!! Form::text('importefolios', '', [
                                        'class' => 'form-control',
                                        'id' => 'importefolios',
                                        'onkeypress' => 'return isNumberKey(event, this)',
                                        $esComision == 1 ? '' : 'readonly',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for=""></label>
                                    <p style="text-align: center; font-size: 16px;">
                                    <div id="importes_disponibles">
                                        <b>
                                            {{ $datos[0]->restant == null ? 'IMPORTE DISPONIBLE $ 0.00' : 'IMPORTE DISPONIBLE $ ' . $datos[0]->restant }}
                                        </b>
                                    </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="custom-file">
                            {!! Form::button('<i class="fas fa-plus-square"></i> Agregar Recorrido', [
                                'type' => 'submit',
                                'rel' => 'noopener noreferrer',
                                'class' => 'btn btn-success',
                                'id' => 'frmsubmit',
                            ]) !!}
                        </div>
                        {!! Form::hidden('idCatVehiculo', base64_encode($idSolPre), [
                            'class' => 'form-control',
                            'id' => 'idCatVehiculo',
                        ]) !!}
                        {!! Form::hidden('noFactura', $solDetalle->facturaserie, ['class' => 'form-control', 'id' => 'noFactura']) !!}
                        {!! Form::hidden('escomision', $esComision, ['class' => 'form-control', 'id' => 'escomision']) !!}
                        {!! Form::close() !!}
                        {{-- cerrar formulario --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- bitacora de recorrido --}}
        <div class="row">
            <div class="col-lg-12 md-4 posicionamiento_flotante">
                <div class="card shadow mb-4">
                    <div class="card-header text-white" style="background-color: #7393B3"><i class="fas fa-route"></i>
                        <b>Recorrido</b></div>
                    <div class="card-body">
                        {{-- tabla --}}
                        <table style="font-size: 12px; padding: 2px 2px;" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 80px;">Fecha</th>
                                    <th scope="col" style="width: 60px;">K.M Inicial</th>
                                    <th scope="col" style="width: 150px;">DE:</th>
                                    <th scope="col" style="width: 150px;">A:</th>
                                    <th scope="col">KM. Final</th>
                                    <th scope="col" style="width: 120px;">Vales</th>
                                    <th scope="col">Litros</th>
                                    <th scope="col">D.V.</th>
                                    <th scope="col">Importe</th>
                                    <th scope="col">Importe Recorrido</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $valoresImpresos = []; // declaración de un arreglo
                                @endphp
                                @if (count($getTemporalBitacora) > 0)
                                    @foreach ($getTemporalBitacora as $k => $v)
                                        @php
                                            $fecha = \Carbon\Carbon::parse($v->fecha)->format('d/m/Y');
                                        @endphp
                                        <tr
                                            style="background-color: {{ $v->comision == true ? '#AAB7B8' : '' }}; color: {{ $v->comision == true ? '#FFF' : '' }}">
                                            <td data-label="Fecha" scope="col" style="width: 80px;">{{ $fecha }}</td>
                                            <td data-label="K.M Inicial" scope="col" style="width: 60px;">{{ $v->kilometraje_inicial }}</td>
                                            <td data-label="DE:" scope="col" style="width: 150px;">{{ $v->actividad_inicial }}</td>
                                            <td data-label="A:" scope="col" style="width: 150px;">{{ $v->actividad_final }}</td>
                                            <td data-label="KM. Final" scope="col" style="width: 5px;">{{ $v->kilometraje_final }}</td>
                                            @if (!in_array($v->vales, $valoresImpresos))
                                                {{-- imprimir el registro --}}
                                                <td scope="col" style="width: 120px;">{{ $v->vales }}</td>
                                                <td scope="col" style="width: 5px;">{{ $v->litros }}</td>
                                                <td scope="col" style="width: 5px;">{{ $v->division_vale }}</td>
                                                <td scope="col" style="width: 5px;">{{ $v->importevales }}</td>

                                                @php
                                                    $valoresImpresos[] = $v->vales;
                                                @endphp
                                            @else
                                                {{-- si no hay si se encuentra en el arreglo se agrega --}}
                                                <td scope="col" style="width: 120px;"></td>
                                                <td scope="col" style="width: 5px;"></td>
                                                <td scope="col" style="width: 5px;"></td>
                                                <td scope="col"style="width: 5px;"></td>
                                            @endif
                                            <td scope="col">{{ $v->importe }}</td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal success --}}
        @include('modals.modalsuccess')
        {{-- modal success END --}}
    </div>

@endsection
{{-- seccion javascript --}}
@section('contenidoJavaScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/js/scripts/multipleselect/multiple-select-es.min.js') }}"></script>
    <script src="{{ asset('assets/js/locale/multiple-select-es-ES.min.js') }}"></script>
    <script src="{{ asset('assets/js_/typehead.min.js') }}"></script>
    {{-- agregar assets para validar --}}
    <script src="{{ asset('assets/jqueryvalidate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/jqueryvalidate/additional-methods.min.js') }}"></script>
    <script>
        let esComision = $('#escomision').val();
        let valesArr = $('#folio_inicial_final').val();
        let selectOptionValue; // declaramos la variable
        let importeFolios;
        let check = $('#chkcomision').is(':checked');
        if (valesArr.length > 0) {
            let sum = 0;
            // si el arreglo tiene más de 0 de longitud empezamos a realizar un foreach para
            valesArr.forEach((value, index) => {
                let arg = value.split('|');
                sum = sum + parseInt(arg[1]);
            });
            $('#importefolios').val(sum);
            importeFolios = sum;
        }

        if (check === true) {
            // si está checado
            selectOptionValue = $('#folio_inicial_final option:selected').toArray().map(item => item
            .value); // asignamos la variable
        }
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $(document).ready(function() {

            $('#chkcomision').change(function() {
                let checado = $(this).is(':checked');
                if (checado === true) {

                    // checa si la información es verdadera
                    if (esComision == 1) {
                        if (selectOptionValue?.length > 0) {
                            // if value get lenght mayor to 0 get value from previous selected state
                            $('#folio_inicial_final').multipleSelect('setSelects', selectOptionValue);
                        }


                        $('#importefolios').val(importeFolios);


                    } else {
                        // si hay valores seleccionados  vamos a guardar los las opciones
                        selectOptionValue = $('#folio_inicial_final option:selected').toArray().map(item =>
                            item.value); // asignamos la variable
                        $("#folio_inicial_final").multipleSelect('uncheckAll');
                    }


                    // habilitar texto
                    $('#numero_comision').attr("readonly", false);
                    $('#numero_comision').focus();
                    $('#numero_factura').attr("readonly", false);
                    $('#importefolios').attr("readonly", false);
                    $('#importes_disponibles').hide("linear");
                } else {
                    if (esComision == 1) {
                        $("#folio_inicial_final").multipleSelect('uncheckAll');
                        $('#importefolios').val('');
                    } else {

                        //si hay valores seleccionados en el input se tiene que evitar cargar
                        if ($('#folio_inicial_final').val().length > 0) {
                            // Unselect all options
                            $("#folio_inicial_final").multipleSelect('uncheckAll');
                        }
                        if (selectOptionValue?.length > 0) {
                            // if value get lenght mayor to 0 get value from previous selected state
                            $('#folio_inicial_final').multipleSelect('setSelects', selectOptionValue);
                        }

                        if (importeFolios?.length > 0) {
                            $('#importefolios').val(importeFolios);
                        }
                        $('#importefolios').attr("readonly", true);
                    }

                    // deshabilitar texto
                    $('#numero_comision').attr("readonly", true);
                    $('#numero_comision').val('');
                    $('#numero_factura').attr("readonly", true);
                    $('#numero_factura').val('');
                    $('#importefolios').attr("readonly", true);
                    $('#importes_disponibles').show("linear");
                }
            });

            $('#folio_inicial_final').change(function() {
                const arrayVales = $(this).val();
                let check = $('#chkcomision').is(':checked');

                if (arrayVales.length > 0 && check === false) {
                    let suma = 0;
                    // si el arreglo tiene más de 0 de longitud empezamos a realizar un foreach para
                    arrayVales.forEach((value, index) => {
                        let arg = value.split('|');
                        suma = suma + parseInt(arg[1]);
                    });
                    $('#importefolios').val(suma);
                } else {
                    // se vuelve a modificar el registro del campo
                    $('#importefolios').val('');
                }
            }).multipleSelect({
                width: '100%',
                locale: 'es-ES',
                formatSelectAll: function() {
                    return 'Seleccionar Todo';
                }
            });

            /*
             * modificación de un select rendimientovehiculo
             */
            $('#rendimientovehiculo').on("change", function() {
                let kmFinal = $("#kmFinal").val();
                let kmInicial = $('#kmInicial').val();
                let rendimiento = $(this).val();
                let litros = $('#litros');
                let calculoLts = 0;
                let difKm = 0;

                let res = difKilometros($('#kmInicial'), $('#kmFinal'));

                $('#kmrecorrido').val(res);

                if (kmFinal.length > 0 && kmInicial.length > 0 && rendimiento.length > 0) {
                    difKm = parseInt(kmFinal) - parseInt(kmInicial);
                    calculoLts = difKm / rendimiento;
                    litros.val(parseFloat(calculoLts).toFixed(2));
                }
            });

            /*
             *  cargar sólo números
             */
            $('input#kmFinal').on('input', function() {
                this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..*?)\..*/g, '$1');
            });

            /** @argument - arg
             * @author - Daniel Méndez Cruz
             */
            $('#kmInicial').on('input', function() {
                this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..*?)\..*/g, '$1');
            });

            /**
             * blur - en litros cuándo pierda el foco del input se dispara el método
             */
            $("#litros").on("blur", function() {
                let litros = $(this).val();
                let precioPorLitro = $('#precioporlitro').val();
                let importe = 0;
                // checar si hay un valor en el siguiente input
                if (precioPorLitro) {
                    // si existe se realiza la operacion
                    importe = precioPorLitro * litros;
                    $('#importe').val(parseFloat(importe).toFixed(2)); // asignamos valor al importe
                }
            });

            $('#kmFinal').on("blur", function() {
                let kmFinal = $(this).val();
                let kmInicial = $('#kmInicial').val();
                let rendimiento = $('#rendimientovehiculo').val();
                let litros = $('#litros');
                let calculoLts = 0;
                let difKm = 0;

                let res = difKilometros($('#kmInicial'), $(this));

                $('#kmrecorrido').val(res);

                if (kmFinal.length > 0 && kmInicial.length > 0 && rendimiento.length > 0) {
                    difKm = parseInt(kmFinal) - parseInt(kmInicial);
                    calculoLts = difKm / rendimiento;
                    litros.val(parseFloat(calculoLts).toFixed(2));
                }
            });

            $('#kmInicial').on("blur", function() {
                let kmIni = $(this).val();
                let kmFin = $('#kmFinal').val();

                let res = difKilometros($(this), $('#kmFinal'));

                $('#kmrecorrido').val(res);
            });

            /**
             * blur - en precio cuándo pierda el foco del input se dispara el método
             */
            $('#precioporlitro').on("blur", function() {
                let ppl = $(this).val();
                let lts = $('#litros').val();
                let importe = 0;
                // checar si hay un valor en el siguiente input
                if (lts) {
                    // si existe se realiza la operacion
                    importe = ppl * lts;
                    $('#importe').val(parseFloat(importe).toFixed(2)); // asignamos valor al importe
                }
            });

            $('#frmBitacoraRecorrido').validate({
                errorClass: "error",
                rules: {
                    fechaEntrada: {
                        required: true
                    },
                    kmInicial: {
                        required: true
                    },
                    kmFinal: {
                        required: true
                    },
                    de: {
                        required: true
                    },
                    a: {
                        required: true
                    },
                    folio_inicial_final: {
                        required: true
                    },
                    litros: {
                        required: true
                    },
                    precioporlitro: {
                        required: true
                    }

                },
                messages: {
                    fechaEntrada: {
                        required: "Fecha requerida"
                    },
                    kmInicial: {
                        required: "Kilometro Inicial requerido"
                    },
                    kmFinal: {
                        required: "Kilometro Final requerido"
                    },
                    de: {
                        required: "Origen es requerido"
                    },
                    a: {
                        required: "Destino es requerido"
                    },
                    litros: {
                        required: "Litros es requerido"
                    },
                    precioporlitro: {
                        required: "Precio por Litro requerido"
                    }
                },
                highlight: function(element, errorClass) {
                    $(element).addClass(errorClass);
                },
                submitHandler: async function(frm, evt) {
                    evt.preventDefault();
                    const formData = new FormData($('#frmBitacoraRecorrido')[0]);
                    const urlRoute = "{{ route('solicitud.bitacora.pre.store.send') }}"
                    await $.ajax({
                        url: urlRoute,
                        method: "POST",
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        data: formData,
                        beforeSend: function() {
                            // procesamos la información
                            $('#frmBitacoraRecorrido').attr('disabled',
                            'disabled'); // deshabilitar el formulario
                            $('#frmsubmit').prop('disabled', true); // deshabilitar botón
                            $('#cover-spin').show(0);
                        },
                        success: function(response) {
                            let per = 0;
                            let formularioAsignado = $('#frmBitacoraRecorrido');
                            const timmer = setInterval(() => {
                                per = per + 50;
                                spinnerProgress(per, timmer, formularioAsignado,
                                    response.res, response.message);
                            }, 500);
                        },
                        error: function(xhr, textStatus, error) {
                            // manejar errores
                            console.log(xhr.statusText);
                            console.log(xhr.responseText);
                            console.log(xhr.status);
                            console.log(textStatus);
                            console.log(error);
                        }
                    });
                }
            });


            // spinner progress
            const spinnerProgress = (per, time, form = null, data = false, message = null) => {
                if (per > 100) {
                    clearInterval(time); // funcion que resetea el intervalo de tiempos
                    $('#frmsubmit').prop('disabled', false); // habilitar botón
                    if (form?.length > 0) {
                        form?.attr('disabled', false); // el formulario se habilita nuevamente
                    }
                    $('#cover-spin').hide(0); // ocultamos el spinner
                    if (data == true) {
                        $('#modalSuccess').modal('show'); // se abre el modal
                        setTimeout(() => {
                            $('#modalSuccess').modal('hide'); // ocultar modal
                            form?.trigger("reset"); // resetear formulario
                            let urlGet = "{{ route('bitacora.detalle.pre.guardado', ':id') }}";
                            const idVehiculo = $('#idCatVehiculo').val();
                            urlGet = urlGet.replace(':id', idVehiculo);
                            window.location.replace(urlGet);
                        }, 900);
                    } else {
                        $('.alertMessage').text(message).show();
                    }
                }
            };

            // función diferencia km
            const difKilometros = (kmIni = null, kmFin = null) => {
                if (kmIni?.val().length > 0 && kmFin?.val().length > 0) {
                    if (!isNaN(kmFin?.val()) && !isNaN(kmIni?.val())) {
                        // pasa y realiza la operación
                        let diferenciaKm = parseInt(kmFin?.val()) - parseInt(kmIni?.val());

                        return diferenciaKm;
                    }
                }
            }
        });

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
