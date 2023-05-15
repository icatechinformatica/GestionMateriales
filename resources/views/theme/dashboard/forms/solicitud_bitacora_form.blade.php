{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Formulario de Solictud Recorrido de Bitácora | SISCOM by ICATECH')

@section('contenidoCss')
    <link rel="stylesheet" href="{{ asset('css/generalStyles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/validateError.css') }}">
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
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-map-marked-alt"></i> Bitacora de Recorrido</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('solicitud.bitacora.store') }}" name="form_bitacora_recorrido" id="form_bitacora_recorrido">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="fecha">Fecha</label>
                                    <div class="custom-file">
                                        <input type="date" name="fecha" id="fecha" class="@error('fecha') is-invalid @enderror form-control">
                                        @error('fecha')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="periodo">Periodo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="periodo" name="periodo" placeholder="click aquí" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="placas">Placas de Vehiculo</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('placas') is-invalid @enderror typeahead form-control" id="placas" name="placas" placeholder="Placas de Vehiculo" autocomplete="off">
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
                                    <label for="marca_vehiculo">Marca del Vehiculo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control " id="marca_vehiculo" name="marca_vehiculo" placeholder="Marca del Vehiculo"  readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="modelo">Modelo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control " id="modelo" name="modelo" placeholder="Modelo"  readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tipo">Tipo de Vehiculo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control " id="tipo" name="tipo" placeholder="Tipo de Vehiculo"  readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="color">Color</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control " id="color" name="color" placeholder="Color"  readonly>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="no_serie">N° de Serie</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="no_serie" name="no_serie" placeholder="N° de Serie" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="no_motor">N° de Motor</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('no_motor') is-invalid @enderror form-control " id="no_motor" name="no_motor" placeholder="N° de Motor" readonly>
                                        @error('no_motor')
                                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="numero_economico">Número Económico</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="numero_economico" name="numero_economico" placeholder="N° Económico" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="_kilometroInicial">Kilometro Inicial</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('_kilometroInicial') is-invalid @enderror  form-control " id="_kilometroInicial" name="_kilometroInicial" autocomplete="off">
                                        @error('_kilometroInicial')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="no_factura_compra">N° de Factura de Compra</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="no_factura_compra" name="no_factura_compra" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-8 mb-3">
                                    <label for="placas">Nombre del Conductor</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="nombreConductor" name="nombreConductor" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="placas">Responsable de la Unidad</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="responsableUnidad" name="responsableUnidad" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="placas">Puesto del responsable de la unidad</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="puestoResponsableUnidad" readonly name="puestoResponsableUnidad" readonly>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="idcatvehiculo" id="idcatvehiculo" readonly>
                            <hr>
                            {{-- botón de agregar elemento de la bitacora --}}
                            <button type="button" name="addBitacora" id="addBitacora" class="btn btn-success btn-md">
                                <i class="fas fa-plus-circle"></i> <b>Agregar Recorrido</b>
                            </button>
                           {{-- botón para calcular --}}
                           <button type="button" class="btn btn-warning btn-md" onclick="calculoTotal()">
                                <i class="fas fa-calculator"></i> <b>Calcular</b>
                           </button>
                           {{-- botón para calcular --}}
                            <br><br>
                            {{-- botón de agregar elemento de la bitacora END --}}
                            <div class="field_wrapper">
                                <table class="table table-bordered" id="dynamicTable">
                                    <thead>
                                      <tr>
                                        <th  style="width: 11.11%;">Fecha</th>
                                        <th  style="width: 7%;">KM inicial</th>
                                        <th  style="width: 15%;">De:</th>
                                        <th  style="width: 15%;">a: </th>
                                        <th  style="width: 7%;">KM final</th>
                                        <th  style="width: 15%;">Vales</th>
                                        <th  style="width: 7%;">Litros</th>
                                        <th  style="width: 7%;">DV</th>
                                        <th  style="width: 9%;">Importe</th>
                                        <th style="width: 7%;">...</th>
                                      </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="table_wrapper">
                                <table class="table table-bordered" id="totalesDinamicos">
                                    <tbody>
                                      <tr>
                                        <td data-label="a:" style="width: 45%; text-align: right;" colspan="4">
                                            <h3><b>KM TOTALES:</b></h3>
                                        </td>
                                        <td data-label="KM final" style="width: 10%;">
                                            <input type="text" name="km_totales" id="km_totales" value="0"  class="form-control" readonly/>
                                        </td>
                                        <td data-label="Vales" style="width: 12%; text-align: right;">
                                            <h3><b>LITROS:</b></h3>
                                        </td>
                                        <td data-label="Litros" style="width: 10%;">
                                            <input type="text" name="litros_totales" id="litros_totales" value="0"  class="form-control" readonly/>
                                        </td>
                                        <td data-label="DV" style="width: 7%;">
                                            &nbsp;
                                        </td>
                                        <td data-label="Importe" colspan="2" style="width: 16%;">
                                            <input type="text" name="importe_total" id="importe_total" value="0"  class="form-control importe" readonly/>
                                        </td>
                                      </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-archive"></i>
                                Archivar
                            </button>
                            <input type="hidden" name="periodo_actual" id="periodo_actual" value="">
                        </form>
                    </div>
                </div>

            </div>
        {{-- Columna de contenido END --}}
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Seleccionar el Périodo del recorrido...</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="row"></div>
                    <div class="col-lg-12 modal-content-dialog">

                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
              </div>
            </div>
        </div>
    </div>
{{-- Content Row END --}}


@endsection

@section('contenidoJavaScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/js_/typehead.min.js') }}"></script>
{{-- agregar assets de javascript para la validación --}}
    <script src="{{ asset('assets/jqueryvalidate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/jqueryvalidate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/jqueryvalidate/metodos/validate_bitacora_recorrido.js') }}"></script>
{{-- agregar assets de javascript para la validación END --}}
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $(document).ready(function(){

            // código utilizado
            const month_array = [   "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                                    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                                ];
            var d = new Date();
            var month = d.getMonth();
            var day = d.getDate();
            var year = d.getFullYear();
            $('#exampleModal .modal-body .modal-content-dialog').append(
                    '<button class="btn btn-squared-default btn-success" value="1a Quincena de '+ month_array[month] +' del '+ year +'">'+
                        '<i class="fas fa-calendar fa-4x"></i>'+
                        '<br />'+
                        '<span class="text">1° Quincena de '+ month_array[month] +' del '+ year +'</span>'+
                    '</button>'+
                    '&nbsp;&nbsp;'+
                    '<button class="btn btn-squared-default btn-warning" value="2a Quincena de '+ month_array[month] +' del '+ year +'">'+
                        '<i class="fas fa-calendar fa-4x"></i>'+
                        '<br />'+
                        '<span class="text">2° Quincena de '+ month_array[month] +' del '+ year +'</span>'+
                    '</button>'
            );




            var j = -1; //elemento inicial contador
            var max_fields = 200; //maximo elementos permitidos
            var addBitacora = $("#addBitacora");
            var sum = 0;
            var importeTotal = 0;

            $(addBitacora).click(function(){
                //Check maximum number of input fields
                if (j < max_fields) {
                    j ++ ; // incrementando el contador
                    if (j == 0) {
                        $("#dynamicTable").append(
                            '<tr>'+
                                '<td data-label="Fecha">'+
                                    '<input type="date" name="agregarItem[' + j + '][fecha_bitacora]"  class="form-control" />'+
                                '</td>'+
                                '<td data-label="KM inicial">'+
                                    '<input type="text" name="agregarItem[' + j + '][kminicial]" id="kmInicial"  class="form-control km_inicial_recorrido" />'+
                                '</td>'+
                                '<td data-label="De:">'+
                                    '<textarea name="agregarItem[' + j + '][de]"  class="form-control"></textarea>'+
                                '</td>'+
                                '<td data-label="a:">'+
                                    '<textarea name="agregarItem[' + j + '][a]"   class="form-control"></textarea>'+
                                '</td>'+
                                '<td data-label="KM final">'+
                                    '<input type="text" name="agregarItem[' + j + '][kmfinal]" id="kmFinal['+j+']" class="form-control kmFinal" autocomplete="off" />'+
                                '</td>'+
                                '<td data-label="Vales">'+
                                    '<textarea name="agregarItem[' + j + '][vales]" id="vales['+j+']" class="form-control numbersOnly vales_tag"></textarea>'+
                                '</td>'+
                                '<td data-label="Litros">'+
                                    '<input type="text" name="agregarItem[' + j + '][litros]" id="litros['+j+']"  class="form-control inst_litros" autocomplete="off" />'+
                                '</td>'+
                                '<td data-label="DV">'+
                                    '<input type="text" name="agregarItem[' + j + '][dv]" id="dv['+j+']" class="form-control denominacion_vales" autocomplete="off"/>'+
                                '</td>'+
                                '<td data-label="Importe">'+
                                    '<input type="text" name="agregarItem[' + j + '][importe]" id="importes['+j+']"  class="form-control importe total_importe" readonly />'+
                                '</td>'+
                                '<td data-label="Acción">'+
                                    '<button type="button" class="btn btn-danger btn-circle btn-sm remove-tr">'+
                                        '<i class="fas fa-minus-circle"></i>'+
                                    '</button>'+
                                '</td>'+
                            '</tr>'
                        );

                        var km_inicial = $('#_kilometroInicial');
                        if (km_inicial.val() == 'NaN' || km_inicial.val() == 0) {
                            $('#kmInicial').val(0);
                        } else {
                            $('#kmInicial').val(km_inicial.val());
                        }
                    } else {
                        var km_recorrido_anterior = $('#dynamicTable tr').last().find('.kmFinal').val();
                        if (km_recorrido_anterior == 'NaN' || km_recorrido_anterior == 0) {
                            km_recorrido_anterior = 0;
                        }

                        $("#dynamicTable").append(
                            '<tr>'+
                                '<td data-label="Fecha">'+
                                    '<input type="date" name="agregarItem[' + j + '][fecha_bitacora]"  class="form-control" />'+
                                '</td>'+
                                '<td data-label="KM inicial">'+
                                    '<input type="text" name="agregarItem[' + j + '][kminicial]" id="kmInicial" value="'+km_recorrido_anterior+'" class="form-control km_inicial_recorrido" />'+
                                '</td>'+
                                '<td data-label="De:">'+
                                    '<textarea name="agregarItem[' + j + '][de]"  class="form-control"></textarea>'+
                                '</td>'+
                                '<td data-label="a:">'+
                                    '<textarea name="agregarItem[' + j + '][a]"   class="form-control"></textarea>'+
                                '</td>'+
                                '<td data-label="KM final">'+
                                    '<input type="text" name="agregarItem[' + j + '][kmfinal]" id="kmFinal['+j+']" class="form-control kmFinal" autocomplete="off" />'+
                                '</td>'+
                                '<td data-label="Vales">'+
                                    '<textarea name="agregarItem[' + j + '][vales]" id="vales['+j+']" class="form-control numbersOnly vales_tag"></textarea>'+
                                '</td>'+
                                '<td data-label="Litros">'+
                                    '<input type="text" name="agregarItem[' + j + '][litros]" id="litros['+j+']"  class="form-control inst_litros" autocomplete="off" />'+
                                '</td>'+
                                '<td data-label="DV">'+
                                    '<input type="text" name="agregarItem[' + j + '][dv]" id="dv['+j+']" class="form-control denominacion_vales" autocomplete="off" />'+
                                '</td>'+
                                '<td data-label="Importe">'+
                                    '<input type="text" name="agregarItem[' + j + '][importe]" id="importes['+j+']"  class="form-control importe total_importe" readonly />'+
                                '</td>'+
                                '<td data-label="Acción">'+
                                    '<button type="button" class="btn btn-danger btn-circle btn-sm remove-tr">'+
                                        '<i class="fas fa-minus-circle"></i>'+
                                    '</button>'+
                                '</td>'+
                            '</tr>'
                        );
                    }
                }
            });

            //Once remove button is clicked
            $(document).on('click', '.remove-tr', function(e){
                e.preventDefault();
                var itemRemoved = $(this).closest('tr').find('.inst_litros').val();
                var totalLitros = $("#litros_totales").val();
                var importeitem = $(this).closest('tr').find('.importe').val();
                restarImporte(importeitem);
                restarLitros(itemRemoved);
                // se remueve la parte de la tabla
                $(this).parents('tr').remove();
                j--; //Decrement field counter
            });

            $(document).on('keyup', '.numbersOnly', function() {
                if (this.value != this.value.replace(/[^0-9\-,]/g, '')) {
                    this.value = this.value.replace(/[^0-9\-,]/g, '');
                }
            });

            /** @author - Daniel Méndez Cruz
            *   @argument - evt
            */
            $(document).on('input', '.kmFinal', function(){
                if (this.value != this.value.replace(/[^0-9\-,]/g, '')) {
                    this.value = this.value.replace(/[^0-9\-,]/g, '');
                }
            });

            $(document).on('input', '#kmInicial', function(){
                if (this.value != this.value.replace(/[^0-9\-,]/g, '')) {
                    this.value = this.value.replace(/[^0-9\-,]/g, '');
                }
            });

            /**@author - DANIEL MÉNDEZ CRUZ
            */
            $(document).on('input', '.inst_litros', function(){
                if (this.value != this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.')) {
                    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
                }
            });

            /**@author - DANIEL MÉNDEZ CRUZ
            * MODIFICACIONES DEL TIPO DE DATO QUE PERMITE INGRESAR - denominacion_vales
            */
            $(document).on('input', '.denominacion_vales', function() {
                if (this.value != this.value.replace(/[^0-9\-,]/g, '')) {
                    this.value = this.value.replace(/[^0-9\-,]/g, '');
                }
            });

            /*
            * funcion de javascript para obtener un dato
            */
            $(document).on('keyup', '.denominacion_vales', '.vales_tag', function(){
                //get amt and qty value
                var vales = $(this).closest('tr').find('.vales_tag').val();
                var denominacionVales = $(this).closest('tr').find('.denominacion_vales').val();
                if(check(vales) == true){
                    // Code that needs to execute when none of the above is in the string
                    separadores = ['-',','];
                    textoseparado = vales.split (new RegExp (separadores.join('|'),'g'));
                    var arreglo = [];
                    for ( index = 0; index < textoseparado.length; index++) {
                        arreglo.push(textoseparado[index]);
                    }

                    arreglo.sort(function (a,b) {
                        return b-a;
                    });

                    var sumatoria = calculo(arreglo);

                    var importe = sumatoria * denominacionVales;
                    $(this).closest('tr').find('.importe').val(importe);
                }
            });

            /*
            * funcion para checar caracteres especiales
            */
            var specialChars = ",-";
            var check = function(string){
                for(i = 0; i < specialChars.length;i++){
                    if(string.indexOf(specialChars[i]) > -1){
                        return true
                    }
                }
                return false;
            }

            var calculo = (array) => {
                var resultado = 0;
                switch (array.length) {
                    case 2:
                        return resultado =  Math.abs(parseInt(array[0], 10) - parseInt(array[1], 10)) + 1 ;
                        break;
                    case 3:
                        var resultado1 = parseInt(array[0], 10) - parseInt(array[1], 10);
                        var resultado2 = parseInt(array[1], 10) - parseInt(array[2], 10);
                        return resultado = resultado1 + resultado2 + 1;
                        break;
                    default:
                        break;
                }
            }

            $('input#_kilometroInicial').on('input', function() {
                this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..*?)\..*/g, '$1');
            });

            var path = "{{ route('autocomplete') }}";
            $('input.typeahead').typeahead({
                source:  function (query, process) {
                    return $.get(path, { term: query }, function (data) {
                        return process(data);
                    });
                }
            });

            $("input.typeahead").focus(function(){
                if ($('input.typeahead').val().length != 0) {
                    var url = "{{ route('softload') }}";
                    var param = {
                        "type": $('input.typeahead').val()
                    };
                    $.ajax({
                        data:  param,
                        url:   url,
                        type:  'get',
                        beforeSend: function () {
                            console.log('Procesando, espere por favor...');
                        },
                        success:  function (response) {
                            $('#color').val(response[0]['color']);
                            $('#marca_vehiculo').val(response[0]['marca']);
                            $('#modelo').val(response[0]['modelo']);
                            $('#tipo').val(response[0]['tipo']);
                            $('#no_serie').val(response[0]['numero_serie']);
                            $('#responsableUnidad').val(response[0]['resguardante_unidad']);
                            $('#puestoResponsableUnidad').val(response[0]['puesto_resguardante_unidad']);
                            $('#idcatvehiculo').val(response[0]['id']);
                            $('#no_motor').val(response[0]['numero_motor']);
                            $('#numero_economico').val(response[0]['numero_economico']);
                        }
                    });
                } else {

                }
            });

            $('#periodo').click(function () {
                $('#exampleModal').modal('show');
            });

            /** @argument - arg
            * @author - Daniel Méndez Cruz
            */
            $('#_kilometroInicial').on('input', (event) => {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });

            /*
            * funcion para mejorar la iteracción de los datos con el campo de fecha
            */
            $('#fecha').change(function() {
                const nombre_mes = [    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                                        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                                    ];
                var date = new Date($(this).val());
                // obtener el mes en el que nos encontramos
                var otro_mes = date.getMonth() + 1;
                var mes_actual = date.getMonth();
                var anio_actual = date.getFullYear();
                // limpiar el contenido
                $('#exampleModal .modal-body .modal-content-dialog').empty();
                // cargar nuevo contenido
                $('#exampleModal .modal-body .modal-content-dialog').append(
                        '<button class="btn btn-squared-default btn-success" onclick="cargarPeriodo(\'' + '1a Quincena de '+ nombre_mes[mes_actual] +' del '+ anio_actual + '\')" >'+
                            '<i class="fas fa-calendar fa-4x"></i>'+
                            '<br />'+
                            '<span class="text">1° Quincena de '+ nombre_mes[mes_actual] +' del '+ anio_actual +'</span>'+
                        '</button>'+
                        '&nbsp;&nbsp;'+
                        '<button class="btn btn-squared-default btn-warning" onclick="cargarPeriodo(\'' + '2a Quincena de '+ nombre_mes[mes_actual] +' del '+ anio_actual + '\')" >'+
                            '<i class="fas fa-calendar fa-4x"></i>'+
                            '<br />'+
                            '<span class="text">2° Quincena de '+ nombre_mes[mes_actual] +' del '+ anio_actual +'</span>'+
                        '</button>'
                );
            });

            /**
            * @author - Daniel Méndez Cruz
            * @argument - periodo
            */
            $('.btn-squared-default').on('click', function(){
                $('#exampleModal').modal("toggle");
                var periodo = $(this).val();
                console.log(periodo);
                // obtener el primer carácter del periodo
                var primerCaracter = periodo.charAt(0);
                $('#periodo').val(periodo);
                $('#periodo_actual').val(primerCaracter);
            });

            /**@author -- DANIEL MÉNDEZ CRUZ
             *@augments - load
             * vamos a ejecutar una función ajax con para autocomplete
            */
            $( "input#nombreConductor" ).autocomplete({
                source: function( request, response ) {
                    $.ajax({

                        url: "{{ route('autocomplete.fetch') }}",
                        method: 'POST',
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function( data ) {
                            response( data );
                        }
                    });
                }
            });

        });
        /**
        * funciones javascripts puras
        */
        function calcularImporte(valor){
            var cantidad = 0, precunit = 0, totalitem = 0 ;
            var tr = valor.parentNode.parentNode;
            var nodes = tr.childNodes;
            // ciclo
            for (let x = 0; x < nodes.length; x++) {
                if (nodes[x].firstChild.id == 'importes[]') {
                    anterior = nodes[x].firstChild.value;
                    totalitem = parseFloat(nodes[x].firstChild.value,10);
                    nodes[x].firstChild.value = totalitem;
                }
            }
            var importeTotal = document.getElementById("importe_total");
            if (importeTotal.vale == 'NaN') {
                importeTotal.value = 0;
                //
            }
            importeTotal.value = parseFloat(importeTotal.value) + totalitem;
        }

        function restarImporte(argument){
            var elemento = 0;
            elemento = parseFloat(argument,10);
            var impTotal = document.getElementById("importe_total");
            if (impTotal.value == 'NaN' || impTotal.value == 0) {
                impTotal.value = 0;
                //
            } else {
                impTotal.value = parseFloat(impTotal.value) - elemento;
            }

        }

        function calcularLitrosTotales(arg){
            var litrosTotales = 0, lts = 0, ltsanterior = 0;
            var t = arg.parentNode.parentNode;
            var nodos = t.childNodes;
            // generamos el ciclo
            for (let j = 0; j < nodos.length; j++) {
                if (nodos[j].firstChild.id == 'litros[]') {
                    ltsanterior = nodos[j].firstChild.value;
                    litrosTotales = parseFloat(nodos[j].firstChild.value,10);
                    nodos[j].firstChild.value = litrosTotales;
                }
            }

            var ltsTotales = document.getElementById("litros_totales");
            if (ltsTotales.value == 'NaN') {
                ltsTotales.value = 0;
            }
            ltsTotales.value = parseFloat(ltsTotales.value) + litrosTotales;
        }
        function restarLitros(args){
            var element = 0;
            element = parseFloat(args, 2);
            var callts = document.getElementById("litros_totales");
            if (callts.value == 'NaN' || callts.value == 0) {
                callts.value = 0;
            } else {
                callts.value = parseFloat(callts.value).toFixed(2) - element;
            }
        }
        function calcularKmTotales(ag) {
            var km_actual = 0, kmsanterior = 0;
            var t = ag.parentNode.parentNode;
            var nods = t.childNodes;
            var km_inicial = $('#_kilometroInicial').val();
            for (let i = 0; i < nods.length; i++) {
                if (nods[i].firstChild.id == 'kmFinal[]') {
                    kmsanterior = nods[i].firstChild.value;
                    km_actual = parseFloat(nods[i].firstChild.value,10);
                    nods[i].firstChild.value = km_actual;
                }
            }
            var km_totales = document.getElementById("km_totales");
            if (km_totales.value == 'NaN') {
                km_totales.value = 0;
            }
            km_totales.value = parseFloat(km_actual - km_inicial);
        }

        function cargarPeriodo(argumento){
            $('#exampleModal').modal("toggle");
            var periodo = argumento;
            console.log(argumento);
            // obtener el primer carácter del periodo
            var primerCaracter = periodo.charAt(0);
            $('#periodo').val(periodo);
            $('#periodo_actual').val(primerCaracter);
        }

        /**@argument
         * calculo total
         */
        function calculoTotal(){
            // primero checamos si hay alguna grilla para ver si podemos hacer el calculo de contenido
            var km_actual = 0;
            var length = $('.kmFinal').length;
            var km_inicial = $('#_kilometroInicial').val();
            var km_totales = document.getElementById("km_totales");
            var ltsclass = $('.inst_litros');
            var operacion = 0;
            var litrosTotales = 0
            var ltsTotales = document.getElementById("litros_totales");
            var importe = $('.total_importe');
            var importeTotal = 0;
            $('.kmFinal').each(function(index, element){
                var valor = this.value;
                // si existe algún valor re realizará la sumatoria
                if (valor) {
                    if (index === (length - 1)) {
                        // si tengo el último elemento
                        valor = parseInt(valor);
                        km_actual = km_actual + valor;
                        operacion = parseInt(km_actual - km_inicial);
                    }
                } else {
                    operacion = 0;
                }
            });

            if (km_actual > 0) {
                km_totales.value = operacion;
            } else {
                km_totales.value = 0;
            }

            /*
            *   calcular litros totales
            */
            ltsclass.each(function(index, element){
                var val = this.value;
                // si existe valores se realizará la sumatoria
                if (val) {
                    if (val > 0) {
                        litrosTotales += parseFloat(val , 2);
                    }
                }
                else {
                    // si no hay registros vamos a ponerle un valor de 0
                    litrosTotales = 0;
                }
            });
            // mostrar los litros totales
            ltsTotales.value = litrosTotales.toFixed(2);

            /*
            * calcular importe
            */
            importe.each(function(i, e){
                var val_importe = this.value;
                // si existen los valores se realizará la sumatoria
                if (val_importe) {
                    if (val_importe > 0) {
                        importeTotal += parseInt(val_importe);
                    }
                } else{
                    importeTotal = 0;
                }
            });

            var impTotal = document.getElementById("importe_total");
            if (impTotal.value == 'NaN') {
                impTotal.value = 0;
                //
            }
            impTotal.value = importeTotal;

        }
    </script>
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ ÚLITMA MODIFICACIÓN 11/NOVIEMBRE/2021 --}}
