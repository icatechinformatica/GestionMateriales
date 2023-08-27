{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('Folios / Asignación'), 'titlePage' => __('SIRMAT | Asignación de Folios')])

@section('contenidoCss')
    <link href="{{ asset('css/folioCreateStyle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modalsuccess.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/validateError.css') }}">
    <link rel="stylesheet" href="{{ asset('css/heading.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loaderspinner.css') }}">
@endsection

@section('contenido')
{{-- tabla --}}
<div class="container-fluid dark-nav">
    <div class="row">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="col-lg-12 md-4 posicionamiento_flotante">
            <div id="cover-spin"></div>
            <span id="success_message"></span>
            <div class="card shadow mb-4">
                <div class="card-header text-white" style="background-color: #621132;"><b>Asignación de Folios de combustibles</b></div>
                <div class="card-body">
                    {{-- abrimos formulario --}}
                        {{-- FORM --}}
                        {!! Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'frmfolioasignar']) !!}
                        {!! Form::token() !!}
                        {{-- toker CSRF --}}
                            <div class="form-row">
                                <div class="col-md-9 mb-3">
                                    {!! Form::label('busqueda_resguardo_placas', 'Buscar por resguardo o placas') !!}
                                    <div class="custom-file">
                                        {!! Form::text('busqueda_resguardo_placas','' , ['class' => 'form-control typeahead', 'autocomplete' => 'off', 'id' => 'busqueda_resguardo_placas']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    {!! Form::label('factura', 'Factura')!!}
                                    <div class="custom-file">
                                        {!! Form::select('factura', $chkFactura,'',['class' => 'form-control', 'placeholder' => '-- SELECCIONA --', 'id' => 'factura']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    {!! Form::label('checkReasignar', 'Reasignar', ['id' => 'chkReasignarLabel'])!!}
                                    <div class="custom-file">
                                        <div class=" form-switch">
                                            <input class="form-check-input" name="checkReasignar" type="checkbox" role="switch" id="checkReasignar" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    {!! Form::label('cantidad', 'Cantidad')!!}
                                    <div class="custom-file">
                                        {!! Form::number('cantidad', '', ['class' => 'form-control', 'min'=> '1', 'id' => 'cantidad']) !!}
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    {!! Form::label('denominacion', 'Denominación')!!}
                                    <div class="custom-file">
                                        {!! Form::select('denominacion', $getDenominacion ,'', ['class' => 'form-control', 'placeholder' => '-- SELECCIONA --', 'id' => 'denominacion']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    {!! Form::label('valeDe', 'Vale De:')!!}
                                    <div class="custom-file">
                                        {!! Form::text('valeDe','', ['class' => 'form-control', 'id' => 'valeDe', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    {!! Form::label('valeHasta', 'Vale Hasta:')!!}
                                    <div class="custom-file">
                                        {!! Form::text('valeHasta','', ['class' => 'form-control', 'id' => 'valeHasta', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    {!! Form::label('asginar', 'Asignar Vales', ['id' => 'buttonsubmit']) !!}
                                    <div class="custom-file">
                                        {!! Form::button('<i class="fas fa-layer-group"></i>',['type'=>'submit', 'rel' =>'noopener noreferrer', 'class' => 'btn btn-info', 'id' => 'frmsubmit']) !!}
                                    </div>
                                </div>
                            </div>
                            {!! Form::hidden('vehiculo_id','' , ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'vehiculo_id', 'readonly']) !!}
                            {!! Form::hidden('resguardante_id','' , ['class' => 'form-control', 'autocomplete' => 'off', 'id' => 'resguardante_id', 'readonly']) !!}
                            {!! Form::hidden('foliosArray', '', ['class' => 'form-control', 'id' => 'foliosArray', 'readonly']) !!}
                            {!! Form::hidden('reasignarInput', '0', ['class' => 'form-control', 'id' => 'reasignarInput', 'readonly']) !!}
                        {!! Form::close() !!}
                        {{-- FORM END --}}
                        <hr width=100%  align="right">
                        <table>
                            <thead>
                                <tr>
                                    <th scope="col">Denomiación</th>
                                    <th scope="col">De:</th>
                                    <th scope="col">Hasta:</th>
                                    <th scope="col">Remover</th>
                                </tr>
                                <tbody id="vales_agregados">
                                </tbody>
                            </thead>
                        </table>
                        <br>
                    {{-- cerramos formulario --}}
                </div>
            </div>
        </div>
    </div>
    {{-- modal add folio --}}
    @include('modals.modaladdFolio')
    {{-- modal add folio END --}}
    {{-- modal success --}}
    @include('modals.modalsuccess')
    {{-- modal success END --}}
    <hr>
</div>
{{-- tabla END --}}
@endsection

@section('contenidoJavaScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/js_/typehead.min.js') }}"></script>
    {{-- agregar assets para validar --}}
    <script src="{{ asset('assets/jqueryvalidate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/jqueryvalidate/additional-methods.min.js') }}"></script>
    <script>
        const objetoVales = @json($getFoliosDisponibles);
        // console.log(objetoVales);
    </script>
    {{-- agregar assets para validar END --}}
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $(document).ready(function(){

            const path = "{{ route('assign.search') }}";
            $('input.typeahead').typeahead({
                source:  function (query, process) {
                    return $.get(path, { term: query }, function (data) {
                        return process(data);
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        console.log(`error ${jqXHR.responseText}`);
                    });
                }
            });

            $('input.typeahead').focus(async function(){
                if ($('input.typeahead').val().length != 0) {
                    const url = "{{ route('assign.load') }}";
                    const param = {
                        "type": $('input.typeahead').val()
                    };
                    // checar el valor
                    const result = await $.ajax({
                        data: param,
                        url: url,
                        type: 'POST',
                        beforeSend: function () {
                            console.log('Procesando, espere por favor...');
                        },
                        success: function(response){
                            /*
                            * para argumentos a los inputs
                            */
                           $('#resguardante_id').val(response['resguardante'].id);
                           $('#vehiculo_id').val(response['id']);
                        },
                        error: function (request, status, error) {
                            console.log(request.responseText);
                        }
                    })

                    return result;
                }
            });

            $('#cargarFolios').on('click', () => {
                let valorSeleccionado = $("#selectedFolio").find(":selected").val();
                //checamos la longitud del objeto vales
                const longitud = objetoVales.length;
                let contador = 1;
                let inf = {
                    cargado: 'SI'
                }
                if (valorSeleccionado.length != 0) {
                    // si hay valor se trabaja
                    Object.entries(objetoVales).forEach(([key, value]) => {
                        if (value['denominacion'] == valorSeleccionado) {
                            // se encuentra en la seleccion
                            if (!value['cargado']) {
                                Object.assign(objetoVales[key],inf);
                                $('#vales_agregados').append(
                                    `<tr id=${key}>`+
                                        '<td>' +
                                            `${value['denominacion'].toUpperCase()}` +
                                        '</td>' +
                                        '<td>' +
                                            `<input type="text" name="foliode[${key}][foliode]" id="foliode[${key}]" class="form-control" autocomplete="off" value="${value['folios']}" />` +
                                        '</td>' +
                                        '<td>' +
                                            `<input type="text" name="foliohasta[${key}][foliohasta]" id="foliohasta[${key}]" class="form-control" autocomplete="off" />`+
                                        '</td>' +
                                        '<td>'+
                                            '<button type="button" class="btn btn-danger btn-circle btn-sm remove-tr">'+
                                                '<i class="fas fa-minus-circle"></i>'+
                                            '</button>'+
                                        '</td>'+
                                    '<tr>'
                                );
                            }
                            // cerrar modal
                            $('#addFolios').modal('hide');
                        }
                    });
                }
            });

            // cargar registros en base a un cambio de estado en un select
            $('select#factura').on('change', async function(evt) {
                evt.preventDefault();
                const facturaValue = $(this).find(":selected").val();
                if (facturaValue.length > 0) {
                    let urlGet = "{{ route('facturagetReasignarStatus', ':id') }}";
                    urlGet = urlGet.replace(':id', facturaValue);
                    // si hay algún valor realizamos la consulta
                    const resultados = await $.ajax({
                        url: urlGet,
                        method: "GET",
                        dataType: 'json',
                        beforeSend: function(){
                            $('#frmsubmit').prop('disabled', true); // deshabilitar un boton
                            $('#cover-spin').show(0);
                        },
                        success: function(res){
                            if (res.res == true) {
                                // si es verdadero habilitamos el checkbox o switch
                                $( "#checkReasignar" ).prop( "disabled", false );
                                $('label#chkReasignarLabel').css("color", "#6495ED");
                            } else {
                                $( "#checkReasignar" ).prop( "disabled", true );
                                $('label#chkReasignarLabel').css("color", "#858796");
                            }
                            $('#frmsubmit').prop('disabled', false);
                            $('#cover-spin').hide(0); // ocultamos el spinner
                        },
                        error: function(xhr, textStatus, error){
                            // manejar errores
                            console.log(xhr.statusText);
                            console.log(xhr.responseText);
                            console.log(xhr.status);
                            console.log(textStatus);
                            console.log(error);
                        }

                    });
                }
            })

            // seleccionar factura
            $('select#denominacion').on('change', async function(event){
                event.preventDefault();
                // lanzar input change event on async awit method
                const valueDen = $(this).find(":selected").val();
                const facturaVal = $('#factura').find(":selected").val();
                const cantidadval = $('#cantidad').val();
                let isChecked = $('#checkReasignar')[0].checked
                const reasignar = $('#checkReasignar').is( ":checked" );
                // checar
                if (facturaVal.length > 0 && cantidadval.length > 0 && valueDen.length > 0) {
                    // tengo los valores de los 3 inputs
                    const getURL = "{{ route('getVales.load') }}";
                    const param = {
                        denominacion: valueDen,
                        factura: facturaVal,
                        cantidad: cantidadval,
                        reasignar: reasignar
                    };
                    const result = await $.ajax({
                        url: getURL,
                        method: "POST",
                        dataType: 'json',
                        data: param,
                        beforeSend: function(){
                            $('#frmsubmit').prop('disabled', true); // deshabilitar un boton
                            $('#cover-spin').show(0);
                        },
                        success: function(res){
                             // manejando porcentaje
                            let percentage = 0;
                            const timer = setInterval(() => {
                                percentage = percentage + 50;
                                spinnerProgress(percentage, timer)

                                if (res.response.length > 1) {
                                    let primero = $(res.response).get(0); // obtener el primer elemento del arreglo
                                    let ultimo = res.response[res.response.length - 1]; // obtener el último elemento del arreglo
                                    $('#valeDe').val(primero.numero_folio);
                                    $('#valeHasta').val(ultimo.numero_folio);
                                    $('#foliosArray').val(JSON.stringify(res.response)); // envíamos toda la respuesta a un input
                                } else if(res.response.length == 1) {
                                    let primeroUltimo = $(res.response).get(0); // obtener el único elemento del arreglo
                                    $('#valeDe').val(primeroUltimo.numero_folio);
                                    $('#valeHasta').val(primeroUltimo.numero_folio);
                                    $('#foliosArray').val(JSON.stringify(res.response)); // envíamos toda la respuesta a un input
                                }
                            }, 500);
                        },
                        error: function(xhr, textStatus, error){
                            // manejar errores
                            console.log(xhr.statusText);
                            console.log(xhr.responseText);
                            console.log(xhr.status);
                            console.log(textStatus);
                            console.log(error);
                        }
                    });

                    return result;
                } else {
                    // si no se cumple la condición tenemos que envíar un mensaje al cliente
                }
            });

            /**
             * validación del formulario
            **/
           $('#frmfolioasignar').validate({
             errorClass: "error",
             rules:{
                factura: {required: true},
                cantidad:{required: true, number: true},
                denominacion: {required: true},
                busqueda_resguardo_placas: {required: true}
             },
             messages: {
                factura: {required: "Campo requerido"},
                cantidad: {required: "Campo requerido", number: "Ingresar una cantidad"},
                denominacion: {required: "Campo requerido"},
                busqueda_resguardo_placas: {required: "Campo requerido"}
             },
             highlight: function(element, errorClass) {
                $(element).addClass(errorClass);
             },
             submitHandler: function(frm, evt){
                // manejamos el submiteo del formulario
                evt.preventDefault();
                const frmData = new FormData($('#frmfolioasignar')[0]);
                const urlStore = "{{ route('assign.folio.store.vehicle') }}"
                $.ajax({
                    url: urlStore,
                    method: "POST",
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data: frmData,
                    beforeSend: function () {
                        // procesamos la información
                        $('#frmfolioasignar').attr('disabled', 'disabled'); // deshabilitar el formulario
                        $('#frmsubmit').prop('disabled', true); // deshabilitar botón
                        $('#cover-spin').show(0);
                    },
                    success: function(response){
                        let per = 0;
                        let formularioAsignado = $('#frmfolioasignar');
                        const timmer = setInterval(() =>{
                            per = per + 50;
                            spinnerProgress(per, timmer, formularioAsignado, response.res);
                        }, 500);
                    },
                    error: function(xhr, textStatus, error){
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
           const spinnerProgress = (per, time, form = null, data = false) => {
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
                        }, 900);
                    }
                }
           };

           /*
           * checar información del switch y forzar a mostrar la cantidad sólo de uno
           */
          $('#checkReasignar').change(function(){
            if (this.checked) {
                // si fue checado
                $("#cantidad").val(1); // sólo podremos reasignar una vale por vez
                $('#cantidad').attr('readonly', true); // poner un input en sólo lectura
                $('label#buttonsubmit').text("Reasignar Vales");
                $('#frmsubmit').html('<i class="fas fa-retweet"></i>');
                $('#reasignarInput').val(1); // asignado
                $("#frmsubmit").removeClass('btn btn-info').addClass('btn btn-success'); // ELIMINAR CLASE ANTERIOR Y AGREGAR LA NUEVA CLASE
            } else {
                // si no fue checado
                $("#cantidad").val(''); // regresamos a su estado base
                $('#cantidad').attr('readonly', false); // regresarlo a su estado normal
                $('label#buttonsubmit').text("Asignar Vales");
                $('#frmsubmit').html('<i class="fas fa-layer-group"></i>');
                $('#reasignarInput').val(0); // no asignado
                $("#frmsubmit").removeClass('btn btn-success').addClass('btn btn-info');
            }
          });
        });
        let cantidadInput = document.getElementById('cantidad');
        cantidadInput.onkeydown = (e) => {
            var k = e.which;

            if ( (k < 48 || k > 57) && (k < 96 || k > 105) && k!=8) {
                e.preventDefault();
                return false;
            }
        }
    </script>
@endsection
{{--  --}}
