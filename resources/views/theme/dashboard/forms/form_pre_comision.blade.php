{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'SOLICITUD BITÁCORA DE COMISIÓN - GUARDADO | SIRMAT by ICATECH')

@section('contenidoCss')
 <style>
    .custom-file-label::after { content: "Seleccionar";}
    table {
        border: 1px solid #ccc;
        border-collapse: collapse;
        margin: 0;
        padding: 0;
        width: 100%;
        table-layout: fixed;
    }

    table caption {
        font-size: 1.5em;
        margin: .5em 0 .75em;
    }

    table tr {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        padding: .35em;
    }

    table th,
    table td {
        padding: .625em;
        text-align: center;
    }

    table th {
        font-size: .70em;
        letter-spacing: .09em;
        text-transform: uppercase;
    }
    /*
    * square buttons effects
    */
    .btn-squared-default
    {
        width: 100px !important;
        height: 100px !important;
        font-size: 10px;
    }

    .btn-squared-default:hover
    {
        border: 3px solid white;
        font-weight: 700;
    }

    .btn-squared-default-plain
    {
        width: 100px !important;
        height: 100px !important;
        font-size: 10px;
    }

    .btn-squared-default-plain:hover
    {
        border: 0px solid white;
    }

    .ui-autocomplete {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        float: left;
        display: none;
        min-width: 160px;
        padding: 4px 0;
        margin: 0 0 10px 25px;
        list-style: none;
        background-color: #ffffff;
        border-color: #ccc;
        border-color: rgba(0, 0, 0, 0.2);
        border-style: solid;
        border-width: 1px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        *border-right-width: 2px;
        *border-bottom-width: 2px;
    }

    .ui-menu-item > a.ui-corner-all {
        display: block;
        padding: 3px 15px;
        clear: both;
        font-weight: normal;
        line-height: 18px;
        color: #555555;
        white-space: nowrap;
        text-decoration: none;
    }

    .ui-state-hover, .ui-state-active {
        color: #ffffff;
        text-decoration: none;
        background-color: #0088cc;
        border-radius: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        background-image: none;
        cursor: pointer;
    }

    @media screen and (max-width: 600px) {
        table {
                border: 0;
        }

        table caption {
                font-size: 1.3em;
        }

        table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }

        table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }

        table td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
        }

        table td::before {
            /*
            * aria-label has no advantage, it won't be read inside a table
            content: attr(aria-label);
            */
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }

        table td:last-child {
            border-bottom: 0;
        }
    }
 </style>
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
                @elseif ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Bien Hecho!</strong> {{ $message }}
                    </div>
                @endif
               {{-- contenido principal --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-route"></i>&nbsp;  COMISIONES PRE-BITÁCORA</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('solicitud.pre.comision.store') }}">
                            @csrf
                            <div class="form-row">
                               {{-- placas de vehiculo --}}
                               <div class="col-md-6 mb-3">
                                    <label for="placas_comision">Placas de Vehiculo</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('placas_comision') is-invalid @enderror typeahead form-control" id="placas_comision" name="placas_comision" placeholder="Placas de Vehiculo" autocomplete="off">
                                        @error('placas_comision')
                                            <div class="alert alert-danger mt-1 mb-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                               {{-- placas de vehiculo END --}}
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="placas_comision">Rendimiento</label>
                                    <select name="rendimiento_vehiculo" id="rendimiento_vehiculo" class="form-control">
                                        <option value="">--SELECCIONAR--</option>
                                        @foreach ($array_rendimiento as $k => $v)
                                            <option value="{{ $k }}" {{ $k == 'rendimiento_mixto' ? 'selected': '' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="marca_vehiculo">Marca del Vehiculo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control " id="marca_vehiculo" name="marca_vehiculo" placeholder="Marca del Vehiculo"  readonly>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="placas_comision">Rendimiento del Vehículo</label>
                                    <input type="text" class="form-control" id="rendimiento_valor" placeholder="Rendimiento Vehículo" name="rendimiento_valor" autocomplete="off" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="placas_comision">Costo de Combustible</label>
                                    <input type="text" class="form-control" id="costo_combustible" placeholder="costo de combustible" name="costo_combustible" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="placas_comision">Kilometraje Total</label>
                                    <input type="text" class="form-control" id="km_total" placeholder="Kilometraje Total" name="km_total" autocomplete="off">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="placas_comision">Monto Total de Combustible (Aproximado)</label>
                                    <input type="text" class="form-control" id="monto_total_rendimiento" placeholder="Monto Total de Combustible" name="monto_total_rendimiento" autocomplete="off" readonly>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="idcatvehiculo" id="idcatvehiculo">
                            <input type="hidden" name="rendimiento_ciudad" id="rendimiento_ciudad">
                            <input type="hidden" name="rendimiento_carretera" id="rendimiento_carretera">
                            <input type="hidden" name="rendimiento_mixto" id="rendimiento_mixto">
                            <input type="hidden" name="rendimiento_carga" id="rendimiento_carga">
                            <hr>
                            <div class="form-row">
                                <div class="col-md-2 mb-1">
                                    {{-- botón de agregar elemento de la bitacora --}}
                                    <button type="button" name="addpuntoapunto" id="addpuntoapunto" class="btn btn-secondary btn-md">
                                        <i class="fas fa-route"></i> <b>Agregar Recorrido</b>
                                    </button>
                                </div>
                                <div class="col-md-2 mb-1">
                                    <a href="https://www.google.com/maps/dir/" class="btn btn-primary" target="_blank">
                                        <i class="fas fa-map-marked-alt"></i>
                                        Mapa de Recorrido
                                    </a>
                                </div>
                                <div class="col-md-3 mb-1">
                                    <a href="http://app.sct.gob.mx/sibuac_internet/ServletManager" class="btn btn-primary" target="_blank">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                        Calculadora de Peaje
                                    </a>
                                </div>
                            </div>
                            <br>
                            {{-- botón de agregar elemento de la bitacora END --}}
                            <div class="table_wrapper">
                                <table class="table table-bordered" id="puntoapunto">
                                    <thead>
                                        <tr>
                                          <th  style="width: 16.5%;">DE</th>
                                          <th  style="width: 16.5%;">A</th>
                                          <th  style="width: 16.5%;">KMS</th>
                                          <th style="width: 16.5%;">PEAJE</th>
                                          <th style="width: 16.5%">TIPO</th>
                                          <th style="width: 16.5%;">...</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table_wrapper">
                                <table class="table table-bordered" id="totalesDinamicos">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>KM TOTALES</th>
                                            <th>PEAJE</th>
                                            <th>MONTO TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td></td>
                                        <td data-label="KM TOTALES">
                                            <input type="text" name="km_totales" id="km_totales"   class="form-control" readonly value="0"/>
                                        </td>
                                        <td data-label="PEAJE">
                                            <input type="text" name="peaje_total" id="peaje_total"  class="form-control importe" readonly value="0"/>
                                        </td>
                                        <td data-label="MONTO TOTAL">
                                            <input type="text" name="monto_total" id="monto_total"  class="form-control" readonly  value="0"/>
                                        </td>
                                      </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <button class="btn btn-success" type="submit" name="ejecutar" value="update">
                                <i class="fas fa-save"></i>
                                Archivar
                            </button>
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
    <script type="module" src="{{ asset('assets/jqueryvalidate/metodos/CalcularMonto.js') }}"></script>
    <script type="text/javascript">
        // import { getRendimiento } from "{{ asset('assets/jqueryvalidate/metodos/CalcularMonto.js') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $(document).ready(function(){
            // código utilizado

            var j = -1; //elemento inicial contador
            var i = -1;
            var max_fields = 200; //maximo elementos permitidos
            var addBitacora = $("#addBitacora");
            var sum = 0;
            var importeTotal = 0;
            var conteo_actual = 0;

            $('#addpuntoapunto').click(function(){
                if (j < max_fields) {
                    j++;
                    $("#puntoapunto").append(
                        '<tr>'+
                            '<td>' +
                                '<textarea name="puntoapunto['+ j +'][de]" id="de[]" class="form-control"></textarea>' +
                            '</td>' +
                            '<td>' +
                                '<textarea name="puntoapunto['+ j +'][a]" id="a[]" class="form-control"></textarea>' +
                            '</td>' +
                            '<td>' +
                                '<input type="text" name="puntoapunto['+ j +'][kms]" id="kms[]" onchange="calculoKmTotal(this);" autocomplete="off" class="form-control kmsitems"/>' +
                            '</td>' +
                            '<td>' +
                                '<input type="text" name="puntoapunto['+ j +'][peaje]" id="peaje[]" onchange="calcularPeaje(this);" autocomplete="off"  class="form-control importes_item"/>' +
                            '</td>' +
                            '<td>' +
                                '<select name="puntoapunto['+ j +'][tipo]" id="tipo[]" class="form-control" onfocus="this.selectedIndex = 0;">'+
                                    '<option value="">-- SELECCIONAR --</option>' +
                                    '<option value="RECORRIDO">RECORRIDO</option>' +
                                    '<option value="PUNTO_A_PUNTO">PUNTO A PUNTO</option>' +
                                '</select>' +
                            '</td>' +
                            '<td data-label="...">'+
                                '<button type="button" class="btn btn-danger btn-circle btn-sm remove-tr">'+
                                    '<i class="fas fa-minus-circle"></i>'+
                                '</button>'+
                            '</td>'+
                        '<tr>'
                    );
                }
            });

            //Once remove button is clicked
            $(document).on('click', '.remove-tr', function(e){
                e.preventDefault();
                var importes = $(this).closest('tr').find('.importes_item').val();
                var kms = $(this).closest('tr').find('.kmsitems').val();
                restarimporte(importes);
                let resultadorkmTotales = restarKmTotales(kms);
                // obtener los datos para restar el monto
                montoTotalFunction(resultadorkmTotales);
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
            $(document).on('input', '#kmFinal', function(){
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
            $(document).on('input', '.lts_comision', function(){
                if (this.value != this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.')) {
                    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
                }
            });

            /**@author - DANIEL MÉNDEZ CRUZ
            * MODIFICACIONES DEL TIPO DE DATO QUE PERMITE INGRESAR - denominacion_vales
            */
            $(document).on('input', '#costo_combustible', function() {
                if (this.value != this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.')) {
                    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
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

            $("#kmFinal").blur(function(){
               var kmInicial =  $('#kmInicial').val();
               var kmFinal =  $(this).val();
               if (kmInicial != '' && kmFinal != '') {
                    var ki = parseFloat(kmInicial,10);
                    var kf = parseFloat(kmFinal,10);
                   if (ki < kf) {
                        var dk = kf - ki;
                        var km_totales = document.getElementById("km_totales");
                        if (km_totales.value == 'NaN') {
                            km_totales.value = 0;
                        }
                        km_totales.value = dk;
                   }
               } else {
                    var km_totales = document.getElementById("km_totales");
                    km_totales.value = 'NaN';
               }
	        });

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

            /**@argument
             *
             * función para autocompletar el campo placa de vehículo con la información
             * que está filtrando en el campo
            */
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
                            $('#rendimiento_ciudad').val(response[0]['rendimiento_ciudad']);
                            $('#marca_vehiculo').val(response[0]['marca']+' '+response[0]['tipo']+' '+response[0]['linea']);
                            $('#idcatvehiculo').val(response[0]['id']);
                            $('#rendimiento_carretera').val(response[0]['rendimiento_carretera']);
                            $('#rendimiento_mixto').val(response[0]['rendimiento_mixto']);
                            $('#rendimiento_carga').val(response[0]['rendimiento_carga']);

                            /*
                            * vamos a utilizar un switch para hacer un cambio con el rendimiento
                            */
                           let valor_rendimiento_vehiculo = $('#rendimiento_vehiculo').val();
                           switch (valor_rendimiento_vehiculo) {
                                case 'rendimiento_carretera':
                                    $('#rendimiento_valor').val(response[0]['rendimiento_carretera']);
                                break;
                                case 'rendimiento_ciudad':
                                    $('#rendimiento_valor').val(response[0]['rendimiento_ciudad']);
                                break;
                                case 'rendimiento_mixto':
                                    $('#rendimiento_valor').val(response[0]['rendimiento_mixto']);
                                break;
                                case 'rendimiento_carga':
                                    $('#rendimiento_valor').val(response[0]['rendimiento_carga']);
                                break;
                               default:
                                break;
                           }
                        }
                    });
                } else {

                }
            });

            $('#periodo_comision').click(function () {
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
            $('#fecha_comision').change(function() {
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
                // obtener el primer carácter del periodo
                var primerCaracter = periodo.charAt(0);
                $('#periodo_comision').val(periodo);
                $('#periodo_comision_actual').val(primerCaracter);
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
            var litrosTotales = parseFloat(ltsTotales.value) + litrosTotales;
            ltsTotales.value = roundToTwo(litrosTotales);
            calcularrendimiento(ltsTotales.value);
        }

        function restarLitros(args){
            if (args.length != 0) {
                var element = 0;
                element = parseFloat(args, 2);
                var callts = document.getElementById("litros_totales");
                if (callts.value == 'NaN' || callts.value == 0) {
                    callts.value = 0;
                } else {
                    callts.value = parseFloat(callts.value).toFixed(2) - element;
                }
            }
        }

        function calcularPrecioUnitario(argumentos){
            var preciototal = 0, precioanterior = 0;
            var f = argumentos.parentNode.parentNode;
            var nods = f.childNodes;
            for (let index = 0; index < nods.length; index++) {
                if (nods[index].firstChild.id == 'precioUnitario[]') {
                    precioanterior = nods[index].firstChild.value;
                    preciototal = parseFloat(nods[index].firstChild.value,10);
                    nods[index].firstChild.value = preciototal;
                }
            }

            var precio_unitario_total = document.getElementById("precio_unitario_total");
            if (precio_unitario_total.value == 'NaN') {
                precio_unitario_total.value = 0;
            }
            var sumatoria_precioUnitario = parseFloat(precio_unitario_total.value) + preciototal;
            precio_unitario_total.value = roundToTwo(sumatoria_precioUnitario);
        }

        function calcularImporteTotal(args)
        {
            var importetotal = 0, importeanterior = 0;
            var ij = args.parentNode.parentNode;
            var nd = ij.childNodes;
            for (let ids = 0; ids < nd.length; ids++) {
                if (nd[ids].firstChild.id == 'totalImporte[]') {
                    importeanterior = nd[ids].firstChild.value;
                    importetotal = parseFloat(nd[ids].firstChild.value, 2);
                    nd[ids].firstChild.value = importetotal;
                    console.log(importetotal);
                }
            }

            var importe_total = document.getElementById("importe_total");
            if (importe_total.value == 'NaN') {
                importe_total.value = 0;
            }
            var valor = parseFloat(importe_total.value) + importetotal;
            importe_total.value = roundToTwo(valor);
        }

        function cargarPeriodo(argumento){
            $('#exampleModal').modal("toggle");
            var periodo = argumento;
            // obtener el primer carácter del periodo
            var primerCaracter = periodo.charAt(0);
            $('#periodo_comision').val(periodo);
            $('#periodo_comision_actual').val(primerCaracter);
        }

        function calcularrendimiento(argto)
        {
            var kmTotal = document.getElementById("km_totales");
            var ltsTotal = argto;
            if (kmTotal.value.length != 0) {
                // si se puede realizar la operación
                // division
                var resultado = kmTotal.value/ltsTotal;
                var rendimiento_litros = document.getElementById("rendimiento_litros");
                rendimiento_litros.value = Math.round(round(resultado));
            }

        }

        function calculoKmTotal(argumento){
            /**
             *  pasamos los argumentos para calcular el km total y obtener el km de ese nodo en el momento.
            */
            var km_actual = 0, kmsanterior = 0;
            var montoTotal = 0, rendimiento = 0;
            var t = argumento.parentNode.parentNode;
            var nods = t.childNodes;
            for (let index = 0; index < nods.length; index++) {
                if (nods[index].firstChild.id == 'kms[]') {
                    kmsanterior = nods[index].firstChild.value;
                    km_actual = parseFloat(nods[index].firstChild.value,10);
                    nods[index].firstChild.value = km_actual;
                }
            }

            var km_totales = document.getElementById("km_totales");
            var rendimiento_vehiculo = document.getElementById("rendimiento_vehiculo");
            switch (rendimiento_vehiculo.value) {
                case 'rendimiento_mixto':
                    var rendimiento_mixto = document.getElementById("rendimiento_mixto");
                    rendimiento = rendimiento_mixto.value;
                    break;
                case 'rendimiento_carga':
                    var rendimiento_carga = document.getElementById("rendimiento_carga");
                    rendimiento = rendimiento_carga.value;
                break;
                default:
                    break;
            }
            var costo_combustible = document.getElementById("costo_combustible");
            if (km_totales.value == 'NaN') {
                km_totales.value = 0;
            }
            // checamos si está vacio o es nullo tanto el costo_combustible como km_total
            km_totales.value = parseFloat(km_actual) + parseFloat(km_totales.value);
            montoTotal = parseFloat(km_totales.value) / parseFloat(rendimiento) * parseFloat(costo_combustible.value);

            var monto_total = document.getElementById("monto_total");
            if (monto_total.value == 'NaN') {
                monto_total.value = 0;
            }
            monto_total.value = parseFloat(montoTotal).toFixed(2);
        }
        /*
        * calcular peaje
        */
        function calcularPeaje(ars)
        {
            var peaje = 0, peajeAnterior = 0;
            var i = ars.parentNode.parentNode;
            var nodos = i.childNodes;
            for (let j = 0; j < nodos.length; j++) {
                if (nodos[j].firstChild.id == 'peaje[]') {
                    peajeAnterior = nodos[j].firstChild.value;
                    peaje = parseFloat(nodos[j].firstChild.value, 10);
                    nodos[j].firstChild.value = peaje;
                }
            }
            var importe_total = document.getElementById("peaje_total");
            if (importe_total.value == 'NaN') {
                importe_total.value = 0;
            }
            importe_total.value = parseFloat(peaje) + parseFloat(importe_total.value);
        }

        function roundToTwo(num) {
            return +(Math.round(num + "e+2")  + "e-2");
        }

        function round(num, decimales = 2) {
            var signo = (num >= 0 ? 1 : -1);
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

        /*
        * restar peaje
        */
        function restarimporte(arg){
            if (arg.length != 0) {
                var element = 0;
                element = parseFloat(arg, 2);
                var importes = document.getElementById("peaje_total");
                if (importes.value == 'NaN' || importes.value == 0) {
                    importes.value = 0;
                } else {
                    importes.value = round(parseFloat(importes.value).toFixed(2) - element);
                }
            }
        }
        /*
        * restar km totales
        */
        function restarKmTotales(args){
            if (args.length != 0) {
                var element = 0;
                element = parseFloat(args, 2);
                var kmTotales = document.getElementById("km_totales");
                if (kmTotales.value == 'NaN' || kmTotales.value == 0) {
                    kmTotales.value = 0;
                } else {
                    let kmTotal = round(parseFloat(kmTotales.value).toFixed(2) - element); // asignación de un resultado a la variable
                    kmTotales.value = kmTotal; // asignación de la variable que contiene el resultado de la operación al valor de un input
                    return kmTotal; // retorno de una variable
                }
            }
        }
        /*
        * restar importe o monto_total
        */
        const montoTotalFunction = (resultadoRestaKmT) => {
            // declaración de variables
            let  performance = 0, montoTotal = 0;
            //obtener el rendimiento del vehiculo
            let rendimientoVehiculo = document.getElementById("rendimiento_vehiculo");
            switch (rendimientoVehiculo.value) {
                case 'rendimiento_mixto':
                    let rmixto = document.getElementById("rendimiento_mixto");
                    performance = rmixto.value;
                    break;
                case 'rendimiento_carga':
                    let rcarga = document.getElementById("rendimiento_carga");
                    performance = rcarga.value;
                    break;
                default:
                    break;
            }

            // obtener el costo combustible
            let costoCombustible = document.getElementById("costo_combustible");
            // checar si el kilometro total está vacio o no
            if (resultadoRestaKmT === 'NaN' || resultadoRestaKmT === "") {
                resultadoRestaKmT = 0
            }
            montoTotal = parseFloat(resultadoRestaKmT) / parseFloat(performance) * parseFloat(costoCombustible.value);
            //llamar a monto total input
            let montoTotalInput = document.getElementById("monto_total");
            if (montoTotalInput.value === 'NaN') {
                montoTotalInput.value = 0;
            }
            montoTotalInput.value = parseFloat(montoTotal).toFixed(2);
        }
    </script>
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
