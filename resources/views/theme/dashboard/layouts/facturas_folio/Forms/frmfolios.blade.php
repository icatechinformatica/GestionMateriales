{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('Facturas '.$getFactura->serie.'/ Asgnar Folios'), 'titlePage' => __('SIRMAT | Capturar Factura')])

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
        <div class="col-lg-12 md-4 posicionamiento_flotante">
            <span id="success_message"></span>
            <div class="card shadow mb-4">
                <div class="card-header text-white" style="background-color: #621132;"><b>Agregar Folios a la Factura</b></div>
                <div class="card-body">
                    {{-- abrimos formulario --}}
                        <div class="form-row">
                            <div class="col-md-12 mb-2">
                                <p class="text-blk name">CLIENTE: INSTITUTO DE CAPACITACIÓN Y VINCULACIÓN TECNOLÓGICA DEL
                                    ESTADO DE CHIAPAS</p>
                            </div>
                        </div>

                        <p class="text-blk name">N° DE LA FACTURA: {{ $getFactura->serie }}</p>
                        <hr style="width:100%;">
                        {{-- FORM --}}
                        {!! Form::open(['method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'frmfolioasignar']) !!}
                        {!! Form::token() !!}
                        {{-- toker CSRF --}}
                        <div class="form-row">
                            <div class="col-md-8 mb-3">
                                {!! Form::label('denominacion', 'Denominación') !!}
                                <div class="custom-file">
                                    {!! Form::select('denominacion', $descripcionSelect, '',['class' => 'form-control ', 'autocomplete' => 'off', 'id' => 'denominacion', 'placeholder' => 'Selecciona Denominación...']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                {!! Form::label('folio_de', 'Folio Inicio') !!}
                                <div class="custom-file">
                                    {!! Form::text('folio_de','' , ['class' => 'form-control ', 'autocomplete' => 'off', 'id' => 'folio_de']) !!}
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                {!! Form::label('folio_hasta', 'Folio Hasta') !!}
                                <div class="custom-file">
                                    {!! Form::text('folio_hasta','' , ['class' => 'form-control ', 'autocomplete' => 'off', 'id' => 'folio_hasta']) !!}
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success" id="addFolioToFactura">
                            <i class="fas fa-plus-square"></i> Agregar Folio
                        </button>
                        {!! Form::hidden('idFactura', base64_encode($getFactura->id) , ['id' => 'idFactura']) !!}
                        {!! Form::close() !!}
                        {{-- FORM END --}}
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="status" id="status" class="form-control custom-select">
                                       <option value="">ESTADO DEL FOLIO</option>
                                       <option value="active">Active</option>
                                       <option value="inactive">InActive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <b>FOLIOS AGREGADOS: {{ count($getFactura->folios) }}</b>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="serach" id="serach" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table id="invoiceUpdate" class="table table-striped table-bordered">
                                <thead>
                                    <tr style="background-color: #621132; color: #FFFFFF">
                                        <th scope="col" class="sorting" data-sorting_type="asc" data-column_name="folio" style="cursor: pointer">Folio <span id="id_icon"></span></th>
                                        <th scope="col">Denominación</th>
                                        <th scope="col">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($getFactura->folios))
                                        @foreach ($getFactura->folios as $k => $v)
                                            <tr style="background-color: {{ $v->denominacion == '50' ? '#699799' : '#C2D7D8' }}; color: {{ $v->denominacion == '50' ? '#FFFFFF' : '#000000' }}">
                                                <td data-label="Folio"><b>{{ $v->numero_folio }}</b></td>
                                                <td data-label="Denominación">@money($v->denominacion)</td>
                                                <td data-label="Estado"><b>{{ $v->status == null ? 'DISPONIBLE' : $v->status }}</b></td>
                                            <tr>
                                        @endforeach
                                    @else
                                        <tr id="noData">
                                            <td colspan="3"><center><h3> <b>NO HAY REGISTROS PARA MOSTRAR</b> </h3></center></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex">
                                {{ $getFactura->folios->links('pagination.custom') }}
                            </div>
                        </div>

                    {{-- cerramos formulario --}}
                </div>
            </div>
        </div>
    </div>
    {{-- modal success --}}
    @include('modals.modalsuccess')
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
    <script src="{{ asset('assets/jqueryvalidate/metodos/validateModalBilling.js') }}"></script>
    {{-- agregar assets para validar END --}}
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $(document).ready(function(){
            /*
            *   filtros
            */
            //  const fetch_data = (page, status, search_term) => {
            //     if (status === undefined) {
            //         status = "";
            //     }

            //     if (search_term === undefined) {
            //         search_term = "";
            //     }

            //     // $.ajax({
            //     //     url:"?folios="+page+"&status="+status+"&search_term="+search_term,
            //     //     success:function(data){
            //     //         $('tbody').html('');
            //     //         $('tbody').html(data);
            //     //     }
            //     // });
            //  }

            // $('body').on('keyup', '#serach', function(){
            //     let status = $('#status').val();
            //     let search_term = $('#serach').val();
            //     let page = $('#hidden_page').val();
            //     fetch_data(page, status, search_term);
            // });

            // $('body').on('click', '.pagination a', function(event){
            //     event.preventDefault();
            //     let page = $(this).attr('href').split('folios=')[1];
            //     $('#hidden_page').val(page);
            //     let serach = $('#serach').val();
            //     let search_term = $('#status').val();
            //     // fetch_data(page,status, search_term);
            // });
            /*
            *   filtros END
            */
            $('#addBillingItem').on('click', (evt) => {
                evt.preventDefault(); // evitar eventos por defecto
                $('#modalBillingTheme').modal('show');
                activateModal(true);
            });

            /**
             * validación del formulario para envío de datos
            */
           $('#frmfolioasignar').validate({
                errorClass: "error",
                rules: {
                    denominacion: {required: true},
                    folio_de: {required: true, minlength:8, maxlength: 8},
                    folio_hasta: {required: true, minlength:8}
                },
                messages: {
                    denominacion: { required: "La denominación es requerida"},
                    folio_de:{required: "El folio de es requerido", minlength: "Introduzca al menos 8 caracteres.", maxlength: "Por favor ingrese no más de 8 caracteres"},
                    folio_hasta: {required: "El folio hasta es requerido", minlength: "Introduzca al menos 8 caracteres.", maxlength: "Por favor ingrese no más de 8 caracteres"}
                },
                highlight: function(element, errorClass) {
                        $(element).addClass(errorClass);
                },
                submitHandler(form, event) {
                    event.preventDefault();
                    const frmData = new FormData($('#frmfolioasignar')[0]);
                    $.ajax({
                        url: "{{ route('folio.add.factura') }}",
                        method: "POST",
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        data: frmData,
                        beforeSend: function(){
                            $('#frmfolioasignar').attr('disabled', 'disabled'); // deshabilitar el formulario
                                // modificamos el botón
                            $("#addFolioToFactura").prop('disabled', true); // deshabilitar submit
                            $("#addFolioToFactura")
                                .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...');
                        },
                        success: function(data){
                            $('#modalSuccess').modal('show'); // se abre el modal
                            // manejando porcentaje
                            let percentage = 0;
                            const timer = setInterval(() => {
                                percentage = percentage + 25;
                                spinnerProgress(percentage, timer, data)
                            }, 700);
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
                    });
                }
           });

           const spinnerProgress = (per, time, dat) => {
                if (per > 100) {
                    clearInterval(time); // funcion que resetea el intervalo de tiempos
                    $('#frmfolioasignar').attr('disabled', false); // el formulario se habilita nuevamente
                    $("#addFolioToFactura").prop('disabled', false); // habilitar submit
                    $("#addFolioToFactura")
                    .html('<i class="fas fa-plus-square"></i> Agregar Folio');

                    setTimeout(() => {
                        $('#modalSuccess').modal('hide'); // ocultar modal
                        let facturaId = $('#idFactura').val();
                        //redireccionar
                            window.location.href = `/factura/add/folios/${facturaId}`;
                    }, 750);
                }
           };
        });

    </script>
@endsection
{{--  --}}
