{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('Facturas/ Edición/ Factura '.$getFactura->serie), 'titlePage' => __('SIRMAT | Capturar Factura')])

@section('contenidoCss')
    <link href="{{ asset('css/folioCreateStyle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modalsuccess.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/validateError.css') }}">
    <link rel="stylesheet" href="{{ asset('css/heading.css') }}">
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
    {{-- FORM --}}
    {!! Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'formFactura']) !!}
    {!! Form::token() !!}
        <div class="col-lg-10 md-4 posicionamiento_flotante">
            <span id="success_message"></span>
            <div class="card shadow mb-4">
                <div class="card-header text-white" style="background-color: #621132;"><b>Datos de la Factura</b></div>
                <div class="card-body">
                    {{-- abrimos formulario --}}
                        {{-- toker CSRF --}}
                        <div class="form-row">
                            <div class="col-md-12 mb-2">
                                <p class="text-blk name">CLIENTE: INSTITUTO DE CAPACITACIÓN Y VINCULACIÓN TECNOLÓGICA DEL
                                    ESTADO DE CHIAPAS</p>
                                <p class="text-blk name">RFC: ICV000727K41 <br> USO CFDI: G03</p>
                            </div>
                        </div>

                        <p class="text-blk name">DATOS DE LA FACTURA</p>
                        <hr style="width:100%;">
                        <div class="form-row">
                            <div class="col-md-8 mb-3">
                                {!! Form::label('proveedor', 'Proveedor') !!}
                                <div class="custom-file">
                                    {!! Form::select('proveedor', $proveedores, $getFactura->id_catproveedor,['class' => 'form-control '.($errors->has('proveedor') ? 'is-invalid' : null), 'autocomplete' => 'off', 'id' => 'proveedor', 'placeholder' => 'Selecciona Proveedor...']) !!}
                                    @error('proveedor')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                {!! Form::label('serie_folio', 'Serie/Folio') !!}
                                <div class="custom-file">
                                    {!! Form::text('serie_folio', $getFactura->serie, ['class' => 'form-control '.($errors->has('serie_folio') ? 'is-invalid' : null), 'autocomplete' => 'off', 'id' => 'serie_folio']) !!}
                                    @error('serie_folio')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                {!! Form::label('folio_fiscal', 'Folio Fiscal UUID') !!}
                                <div class="custom-file">
                                    {!! Form::text('folio_fiscal', $getFactura->folio_fiscal, ['class' => 'form-control '.($errors->has('folio_fiscal') ? 'is-invalid' : null), 'autocomplete' => 'off', 'id' => 'folio_fiscal']) !!}
                                    @error('folio_fiscal')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                {!! Form::label('certificado_emisor', 'Certificado Emisor') !!}
                                <div class="custom-file">
                                    {!! Form::text('certificado_emisor', $getFactura->certificado_emisor, ['class' => 'form-control '.($errors->has('certificado_emisor') ? 'is-invalid' : null), 'autocomplete' => 'off', 'id' => 'certificado_emisor']) !!}
                                    @error('certificado_emisor')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                {!! Form::label('certificado_sat', 'Certificado del SAT') !!}
                                <div class="custom-file">
                                    {!! Form::text('certificado_sat', $getFactura->certificado_sat, ['class' => 'form-control '.($errors->has('certificado_sat') ? 'is-invalid' : null), 'autocomplete' => 'off', 'id' => 'certificado_sat']) !!}
                                    @error('certificado_sat')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                {!! Form::label('tipo_comprobante', 'Tipo Comprobante') !!}
                                <div class="custom-file">
                                    {!! Form::text('tipo_comprobante', $getFactura->tipo_comprobante , ['class' => 'form-control '.($errors->has('tipo_comprobante') ? 'is-invalid' : null), 'autocomplete' => 'off', 'id' => 'tipo_comprobante']) !!}
                                    @error('tipo_comprobante')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                {!! Form::label('fecha_emision', 'Fecha de Emisión') !!}
                                <div class="custom-file">
                                    <input type="datetime-local" name="fecha_emision" id="fecha_emision" class="@error('fecha_emision') is-invalid @enderror form-control" autocomplete="off" value="{{ date('Y-m-d\TH:i:s', strtotime($getFactura->fecha_emision)) }}">
                                    @error('fecha_emision')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                {!! Form::label('fecha_certificacion', 'Fecha de Certificación') !!}
                                <div class="custom-file">
                                    <input type="datetime-local" name="fecha_certificacion" id="fecha_certificacion" class="@error('fecha_certificacion') is-invalid @enderror form-control" autocomplete="off" value="{{ date('Y-m-d\TH:i:s', strtotime($getFactura->fecha_certificacion)) }}">
                                    @error('fecha_certificacion')
                                        <div class="alert alert-danger mt-1 mb-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    {{-- cerramos formulario --}}
                </div>
            </div>
        </div>
        <div class="col-lg-12 md-4 posicionamiento_flotante">
            <div class="card shadow mb-4">
                <div class="card-header text-white" style="background-color: #621132;"><b>Detalles de la Factura</b></div>
                <div class="card-body">
                <button class="btn btn-warning" id="addBillingItem" data-toggle="modal" data-target="#modalBillingTheme"><i class="fas fa-plus"></i> Añadir Elemento</button>
                &nbsp;
                <button type="submit" id="submitForm" class="btn btn-success">
                    <i class="fas fa-cloud-upload-alt"></i> Actualizar
                </button>
                <hr>
                <table id="invoiceUpdate">
                    <thead>
                    <tr>
                        <th scope="col">C. Producto</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">C. Unidad</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">V. Unitario</th>
                        <th scope="col">Impuestos</th>
                        <th scope="col">Importe</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                      @if (count($getFactura->facturadetalles))
                        {{-- se ingresa y se realiza un ciclo --}}
                       @foreach ($getFactura->facturadetalles as $k => $v)
                        <tr id="{{ $k + 1 }}">
                            <td data-label="C. Producto">{{ $v->clave_producto }}</td>
                            <td data-label="Cantidad">  {{ $v->cantidad }} </td>
                            <td data-label="C. Unidad">{{ $v->clave_unidad }}</td>
                            <td data-label="Descripción" class="descripcion">{{ $v->descripcion }}</td>
                            <td data-label="V. Unitario">@money($v->valor_unitario)</td>
                            <td data-label="Impuestos">@money($v->impuestos)</td>
                            <td data-label="Importe">@money($v->importe)</td>
                            <td data-label="Eliminar">
                                <a href="javascript:;" class="btn btn-danger btn-circle btn-sm deleteDetalle" data-toggle="modal" id="{{ base64_encode($v->id) }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        <tr>
                       @endforeach
                      @else
                        <tr id="noData">
                          <td colspan="8"><center><h3> <b>NO HAY REGISTROS PARA MOSTRAR</b> </h3></center></td>
                        </tr>
                      @endif
                    </tbody>
                </table>
                <hr>
                <table>
                    <thead>
                        <tr>
                            <th colspan="3" scope="col">Subtotal:</th>
                            <th colspan="3" scope="col">Impuestos Trasladados:</th>
                            <th colspan="2" scope="col">Total:</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" data-label="Subtotal:" id="facturaSubtotal">@money($getFactura->subtotal)</td>
                            <td colspan="3" data-label="Impuestos Trasladados:" id="facturaImpuestoTrasladado">@money($getFactura->impuestos_trasladados)</td>
                            <td colspan="2" data-label="Total:" id="facturaTotal">@money($getFactura->total)</td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        {!! Form::hidden('idfactura', base64_encode($getFactura->id) ,['id' => 'idfactura']) !!}
    {!! Form::close() !!}
    {{-- FORM END --}}
    </div>
    {{-- incluir modal de inserción de datos --}}
    @include('theme.dashboard.layouts.facturas_folio.Forms.modal_billing')


    {{-- modal success --}}
    @include('modals.modaldelete')
    {{-- modal success END --}}
    <hr>
</div>
{{-- tabla END --}}
@endsection

@section('contenidoJavaScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    {{-- agregar assets para validar --}}
    <script src="{{ asset('assets/jqueryvalidate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/jqueryvalidate/additional-methods.min.js') }}"></script>
    <script>
        const detalleFactura = [];
        let subtotal = "{{ $getFactura->subtotal }}";
        let impuestoTrasladado = "{{ $getFactura->impuestos_trasladados }}";
        let totalFactura = "{{ $getFactura->total }}";
        let finalSubtotal = 0;
        let finalImpuestoTrasladado = 0;
        let finalTotalFactura = 0;
        let contador = {{ count($getFactura->facturadetalles) }};
        let idDetalleFactura = $('#idfactura').val();
    </script>
    <script src="{{ asset('assets/jqueryvalidate/metodos/validateModalBillingUpdate.js') }}"></script>
    {{-- agregar assets para validar END --}}
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $(document).ready(function(){
            $('#addBillingItem').on('click', (evt) => {
                evt.preventDefault(); // evitar eventos por defecto
                $('#modalBillingTheme').modal('show');
                $('#idFormDetalleFactura').val(idDetalleFactura);
                activateModal(true);
            });

            /*
            * validacion y submit
            */
           $('#formFactura').validate({
                errorClass: "error",
                rules: {
                    folio_fiscal: {required:true},
                    certificado_emisor: {required:true},
                    certificado_sat: {required:true},
                    tipo_comprobante: {required:true},
                    fecha_emision: {required:true},
                    fecha_certificacion: {required:true},
                    serie_folio:{required:true},
                    proveedor:{required:true}
                },
                messages:{
                    folio_fiscal: {required: "el folio fiscal es requerido"},
                    certificado_emisor:{required: "el certificado emisor es requerido"},
                    certificado_sat:{required: "Certificado del SAT es requerido"},
                    tipo_comprobante:{required: "el Tipo de Comprobante es requerido"},
                    fecha_emision:{required: "la Fecha de Emisión es requerida"},
                    fecha_certificacion:{required: "la Fecha de Certificación es requerida"},
                    serie_folio:{required: "Serie o Folio requerido"},
                    proveedor:{required: "Seleccione Proveedor"}
                },
                highlight: function(element, errorClass) {
                    $(element).addClass(errorClass);
                },
                submitHandler: function(form, event){
                    // manejamos el submiteo del formulario
                    event.preventDefault();
                    const fd = new FormData($('#formFactura')[0]);
                    fd.append('itemsData', JSON.stringify(detalleFactura));
                    fd.append('subtotal', JSON.stringify(finalSubtotal));
                    fd.append('impuestos_trasladados', JSON.stringify(finalImpuestoTrasladado));
                    fd.append('total', JSON.stringify(finalTotalFactura));
                    $.ajax({
                        url: "{{ route('factura.save') }}",
                        method: "POST",
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        data: fd,
                        beforeSend: function()
                        {
                            $('#formFactura').attr('disabled', 'disabled');
                            $('.process').css('display', 'block');
                            // modificamos el botón
                            $('#addBillingItem').prop('disabled', true); // deshabilitar botón
                            $("#submitForm").prop('disabled', true); // deshabilitar submit
                            $("#submitForm")
                                .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');
                        },
                        success: function(data)
                        {
                            $('#modalSuccess').modal('show'); // se abre el modal
                            // manejando porcentaje
                            let percentage = 0;
                            const timer = setInterval(() => {
                                percentage = percentage + 20;
                                spinnerProgress(percentage, timer, data)
                            }, 1000);
                        },
                        error: function(xhr, textStatus, error)
                        {
                            // manejar errores
                            console.log(xhr.statusText);
                            console.log(xhr.responseText);
                            console.log(xhr.status);
                            console.log(textStatus);
                            console.log(error);
                        }
                    })
                }
           });

           const spinnerProgress = (per, time, dat) => {
            if (per > 100) {
                clearInterval(time); // funcion que resetea el intervalo de tiempos
                $('#formFactura').attr('disabled', false); // el formulario se habilita nuevamente
                $('#addBillingItem').prop('disabled', false); // habilitar botón
                $("#submitForm").prop('disabled', false); // habilitar submit
                $("#submitForm")
                 .html('<i class="fas fa-plus"></i> Enviar');
                $('#modalSuccess').modal('hide'); // ocultar modal
                setTimeout(() => {
                    //redireccionar
                        window.location.href = "{{ route('factura.index')}}";
                }, 900);
            }
           };

            const roundToTwo = (num) => {
                return +(Math.round(num + "e+2")  + "e-2");
            }

            const round = (num, decimales = 2) => {
                const signo = (num >= 0 ? 1 : -1);
                num = num * signo;
                if (decimales === 0) //con 0 decimales
                    return signo * Math.round(num);
                // round(x * 10 ^ decimales)
                num = num.toString().split('e');
                num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
                // x * 10 ^ (-decimales)
                num = num.toString().split('e');
                return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
            }

            $(document).on('input', '#subtotal', function(){
                if (this.value != this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.')) {
                    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
                }
            });

            $(document).on('input', '#impuesto_trasladados', function(){
                if (this.value != this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.')) {
                    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
                }
            });

            // function cargar los datos
            $(document).on('keyup', '#subtotal', () => {
                // declaración de variables y constantes
                const subtotal = $(this).find("input[id='subtotal']").val();
                const impuesto = $(this).find("input[id='impuesto_trasladados']").val();
                const total = document.getElementById("total");
                // checamos si los inputs están vacios
                if (subtotal.length === 0) {
                    // subtotal está vacio
                    return true;
                }
                else if (impuesto.length === 0) {
                    // si impuesto está vacio sólo paso el valor del subtotal al total
                    let subt = Number(subtotal);
                    let valor = parseFloat(subt);
                    total.value = roundToTwo(valor);
                } else {
                    // si estamos en este segmento se debe hacer un calcúlo
                    let subt = Number(subtotal);
                    let  impus = Number(impuesto);
                    let valor = parseFloat(subt) + parseFloat(impus);
                    total.value = roundToTwo(valor);
                }
            });

            // calculo de subtotal pero iniciando con
            $(document).on('keyup', '#impuesto_trasladados', () => {
                // declaración de variables
                const subtotal = $(this).find("input[id='subtotal']").val();
                const impuesto = $(this).find("input[id='impuesto_trasladados']").val();
                const total = document.getElementById("total");
                // checamos los inputs vacios
                if (impuesto.length === 0) {
                    // impuesto está vacio
                    return true;
                } else if(subtotal.length === 0){
                    // si subtotal está vacio sólo paso el valor del impuesto al total
                    let impus = Number(impuesto);
                    let valor = parseFloat(impus);
                    total.value = roundToTwo(valor);
                } else {
                    // si estamos en este segmento se debe hacer un calcúlo
                    let subt = Number(subtotal);
                    let  impus = Number(impuesto);
                    let valor = parseFloat(subt) + parseFloat(impus);
                    total.value = roundToTwo(valor);
                }
            });
            /**
             * evento de cambio en un input
            */
           $('#fileup').change(() => {
                // tomamos la extensión del archivo y seteamos un arreglo de extensiones validas
                const res = $('#fileup').val();
                const arr = res.split("\\");
                const filename = arr.slice(-1)[0];
                const filextension = filename.split(".");
                let filext = "."+filextension.slice(-1)[0];
                const valid = [".pdf"];

                // si el archivo no está validado mandamos un error y escondamos el botton submit
                if (valid.indexOf(filext.toLowerCase()) == -1) {
                    $( ".imgupload" ).hide("slow");
                    $( ".imgupload.ok" ).hide("slow");
                    $( ".imgupload.stop" ).show("slow");
                    $('#namefile').css({"color":"red","font-weight":700});
                    $('#namefile').html("El archivo "+filename+" no es un pdf!");
                    // deshabilitar el submit
                    $( "#submitFrm" ).prop( "disabled", true );
                } else {
                    // si el archivo es valido mostramos un alerta verde y cargamos el submit a valido
                    $( ".imgupload" ).hide("slow");
                    $( ".imgupload.stop" ).hide("slow");
                    $( ".imgupload.ok" ).show("slow");
                    $('#namefile').css({"color":"green","font-weight":700});
                    $('#namefile').html(filename);
                    //habilitar
                    $( "#submitFrm" ).prop( "disabled", false );
                }
            });

            const activateModal = (flag = true) => {
                $(document).on('input', '#cantidad', function(){
                    if (this.value != this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.')) {
                        this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
                    }
                });
                // cargar otros inputs para que no puedan sea sólo númerico

                $('#valor_unitario, #impuestos, #importe').keypress(function(event) {
                    if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
                        ((event.which < 48 || event.which > 57) &&
                        (event.which != 0 && event.which != 8))) {
                        event.preventDefault();
                    }

                    var text = $(this).val();

                    if ((text.indexOf('.') != -1) &&
                        (text.substring(text.indexOf('.')).length > 2) &&
                        (event.which != 0 && event.which != 8) &&
                        ($(this)[0].selectionStart >= text.length - 2)) {
                        event.preventDefault();
                    }
                });
            }

            $('a.deleteDetalle').on('click', function(evt){
                evt.preventDefault();
                let id = $(this).attr('id');
                $('#modaldelete').modal('show');
                $('#valorId').val(idDetalleFactura);
                let url = '{{ route("factura.delete.details", ":id") }}';
                url = url.replace(':id', id);
                $('#formDelete').attr("action", url);
            });
        });
    </script>
@endsection
{{--  --}}
