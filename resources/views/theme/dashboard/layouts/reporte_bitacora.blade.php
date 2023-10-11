{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __(' Inicio /Bitácora / Reporte'), 'titlePage' => __('SIRMAT | REPORTE BITÁCORA DE RECORRIDO')])


@section('contenidoCss')
    <link rel="stylesheet" href="{{ asset('css/generalStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/validateError.css') }}">
    <link href="{{ asset('css/folioCreateStyle.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/heading.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loaderspinner.css') }}">
    <link href="{{ asset('css/folioStyle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modalsuccess.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css_/tokenfield/bootstrap-tokenfield.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css_/tokenfield/tokenfield-typeahead.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
@endsection

@section('contenido')
    <div class="container-fluid dark-nav">
        <div class="row">
            <div class="col-lg-12 md-4 posicionamiento_flotante">
                <div id="cover-spin"></div>
                <div class="card shadow mb-4">
                    <div class="card-header text-white" style="background-color: #621132;"><i class="fas fa-search"></i>
                        <b>Busqueda por Factura</b>
                    </div>
                    <div class="card-body">
                        {{-- abrir formulario --}}
                        {!! Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'frmBitacoraReporte']) !!}
                        <div class="alert alert-danger d-none" role="alert"></div>
                        <div class="form-row">
                            <div class="col-md-3">
                                {!! Form::label('facturalabel', 'N° de Factura', ['id' => 'facturalabel']) !!}
                                <div class="custom-file">
                                    {!! Form::text('facturas', '', ['class' => 'form-control', 'id' => 'facturas']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('fechaini', 'Fecha Inicio', ['id' => 'fechaini']) !!}
                                <div class="custom-file">
                                    {!! Form::date('fechaInicio', \Carbon\Carbon::now(), ['class' => 'form-control', 'id' => 'fechaInicio']) !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('fechafin', 'Fecha Fin', ['id' => 'fechafin']) !!}
                                <div class="custom-file">
                                    {!! Form::date('fechaFinal', '', ['class' => 'form-control', 'id' => 'fechaFinal']) !!}
                                </div>
                            </div>
                        </div>
                        <br>
                        {!! Form::button('<i class="fas fa-filter"></i> Filtrar', [
                            'rel' => 'noopener noreferrer',
                            'class' => 'btn btn-info',
                            'id' => 'frmsubmit',
                        ]) !!}
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
                    <div class="card-header text-white" style="background-color: #621132"><i class="fas fa-layer-group"></i>
                        <b>Bitácora</b>
                    </div>
                    <div class="card-body">
                        {{-- tabla --}}
                        <table id="log">
                            <caption>Reporte de Bitácora</caption>
                            <thead>
                                <tr>
                                    <th scope="col">N° Factura</th>
                                    <th scope="col">Placas</th>
                                    <th scope="col">Comentarios</th>
                                    <th scope="col">Generar Reporte</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
{{-- incluir modal --}}
{{-- modal success --}}
@include('modals.modalsuccess')
{{-- modal success END --}}

@include('modals.modalcomments')
@endsection
{{-- seccion javascript --}}
@section('contenidoJavaScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/js_/typehead.min.js') }}"></script>
    {{-- agregar assets para validar --}}
    <script src="{{ asset('assets/jqueryvalidate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/jqueryvalidate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/js/tokenfield/bootstrap-tokenfield.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        function myfunction(id) {
            $('#temporalId').val(id);
            $('#staticBackdrop').modal('show'); // se abre el modal
        }

        $(document).ready(function() {
            /*
             *   cargar el valor del input con jquery
             */
            $('#facturas').tokenfield({
                autocomplete: {
                    source: function(request, response) {
                        let routesUrl = "{{ route('filter.get.facturas') }}";
                        $.get(routesUrl, {
                            query: request.term
                        }, function(data) {
                            data = $.parseJSON(data);
                            response(data);
                        });
                    },
                    delay: 100,
                },
                showAutocompleteOnFocus: false,
                beautify: true,
            });

            // click button
            $('#frmsubmit').on('click', function(event) {
                event.preventDefault();
                const urlRoute = "{{ route('solicitud.reporte.bitacora.obtener.vinculados') }}";
                const formData = new FormData($('#frmBitacoraReporte')[0]);
                const factura = $('#facturas').val();
                if (factura.length > 0) {
                    $(".alert").addClass('d-none');
                    $.ajax({
                        url: urlRoute,
                        method: "POST",
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        data: formData,
                        beforeSend: function() {
                            // procesar antes de enviar
                            $('#frmBitacoraReporte').attr('disabled',
                                'disabled'); // deshabilitar el formulario
                            $('#cover-spin').show(0);
                        },
                        success: function(response) {
                            let percentage = 0;
                            let formularioReporte = $('#frmBitacoraReporte');
                            const timmer = setInterval(() => {
                                percentage = percentage + 50;
                                spinnerProgress(percentage, timmer, formularioReporte,
                                    response.success, response.message);
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
                    })
                } else {
                    // mostramos un mensaje
                    let mensaje = 'Se necesita el N° de Factura para realizar la operación!';
                    $(".alert").removeClass('d-none').html(`${mensaje}`);
                }
            });

            // spinner progress
            const spinnerProgress = (per, time, form = null, data = false, res = null) => {
                if (per > 100) {
                    clearInterval(time); // funcion que resetea el intervalo de tiempos
                    if (form?.length > 0) {
                        form?.attr('disabled', false); // el formulario se habilita nuevamente
                    }
                    $('#cover-spin').hide(0); // ocultamos el spinner
                    if (data == true) {
                        let contenidoTabla = '';
                        setTimeout(() => {
                            $('#log tbody').empty(); // limpiar contenido de la tabla
                            // cargamos los datos
                            // obtenemos el objeto
                            let objeto = res;
                            // urlReq = urlReq.replace(':id', id);

                            Object.entries(objeto).forEach(([key, value]) => {
                                let urlReq =
                                    "{{ route('generar.reporte.bitacora.pdf', ':id') }}";
                                urlReq = urlReq.replace(':id', value['id']);
                                /**
                                 * iterando el objeto por foreach
                                 */
                                contenidoTabla += `<tr>` +
                                    `<td data-label="N° Factura"><b>${value['numero_factura_compra']}</b></td>` +
                                    `<td data-label="Placas"><b>${value['placas']}</b></td>` +
                                    `<td data-label="Comentarios">` +
                                    `<a class="btn btn-warning" id="onpenModalComents" onclick="myfunction(${value['id']})">` +
                                    `<i class="fas fa-th-list"></i>` +
                                    `</a>` +
                                    `</td>` +
                                    `<td data-label="Generar Reporte">` +
                                    `<a href="${urlReq}" class="btn btn-danger" target="_blank">` +
                                    `<i class="fas fa-file-pdf"></i>` +
                                    `</a>` +
                                    `</td>` +
                                    `<tr>`;
                            });
                            $("#log tbody").append(contenidoTabla);
                        }, 500);
                    } else {
                        $('.alertMessage').show();
                    }
                }
            };


            // type head
            const path = "{{ route('solicitud.search.driver') }}";
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

            $('#submitmodaladdcomment').on('click', function(e) {
                e.preventDefault();
                const formData = new FormData($('#frmModal')[0]);
                const urlData = "{{ route('reporte.solicitud.bitacora.save') }}";
                $.ajax({
                    url: urlData,
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data: formData,
                    beforeSend: function() {
                        // procesar antes de enviar
                        $('#frmModal').attr('disabled',
                            'disabled'); // deshabilitar el formulario
                        $('#cover-spin').show(0);
                    },
                    success: function(res) {
                        let percent = 0;
                        let formModal = $('#frmModal');
                        const timmer = setInterval(() => {
                            percent = percent + 50;
                            progressSpinn(percent, timmer, formModal,
                                res.success);
                        }, 500);
                    },
                    error: function(xhr, textStatus, error) {
                        console.log(xhr.statusText);
                        console.log(xhr.responseText);
                        console.log(xhr.status);
                        console.log(textStatus);
                        console.log(error);
                    }
                });
            });

            // spinner progress
            const progressSpinn = (per, time, form = null, data = false) => {
                if (per > 100) {
                    clearInterval(time); // funcion que resetea el intervalo de tiempos
                    if (form?.length > 0) {
                        form?.attr('disabled', false); // el formulario se habilita nuevamente
                    }
                    $('#cover-spin').hide(0); // ocultamos el spinner
                    if (data == true) {
                        $('#modalSuccess').modal('show'); // se abre el modal
                        $('#staticBackdrop').modal('hide');
                        setTimeout(() => {
                            $('#modalSuccess').modal('hide'); // ocultar modal
                            form?.trigger("reset"); // resetear formulario
                        }, 900);
                    }
                }
            };
        });
    </script>
@endsection
