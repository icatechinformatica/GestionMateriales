{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Formulario de Solictud Recorrido de Bitácora | SISCOM by ICATECH')

@section('contenidoCss')
 <style>
    .custom-file-label::after { content: "Seleccionar";}
    #spinner-roller { display: none;}
    body.busy .spinner { display:block !important; }
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
                @endif
                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-map-marked-alt"></i> Bitácora de Recorrido</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                @switch($solicitud_por_id->status_proceso)
                                    @case(1)
                                        <a href="{{ route('solicitud.bitacora.get.review', ['review' => base64_encode($idSol)]) }}" class="btn btn-warning">
                                            <i class="fas fa-eye"></i> Activar Revisión
                                        </a>
                                        @break
                                    @case(2)
                                        <a href="{{ route('solicitud.bitacora.get.review', ['review' => base64_encode($idSol)]) }}" class="btn btn-warning">
                                            <i class="fas fa-eye"></i> Activar Revisión
                                        </a>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">En Revisión</span>
                                @endswitch
                            </div>
                            <div class="col-md-8 mb-3">
                                <div class="custom-file">
                                    <div class=" form-switch">
                                        <input class="form-check-input" value="true" name="habilitado" id="habilitado" type="checkbox" id="flexSwitchCheckDefault">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">Deshabilitar / Habilitar Formulario</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form method="POST" id="form1" name="form1" action="{{ route('solicitud.done.bitacora') }}">
                            @csrf
                            {{-- habilitar y deshabilitar END --}}
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="fecha">Fecha</label>
                                    <div class="custom-file">
                                        <input type="date" name="fecha" id="fecha" class="@error('fecha') is-invalid @enderror form-control myClass" value="{{ $solicitud_por_id->fecha }}">
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
                                        <input type="text" class="form-control" id="periodo" name="periodo" placeholder="click aquí" readonly value="{{ $solicitud_por_id->periodo }}">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="placas">Placas de Vehiculo</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('placas') is-invalid @enderror typeahead form-control myClass" id="placas" name="placas" placeholder="Placas de Vehiculo" autocomplete="off" value="{{ $solicitud_por_id->placas }}">
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
                                        <input type="text" class="form-control " id="marca_vehiculo" name="marca_vehiculo" placeholder="Marca del Vehiculo"  readonly value="{{ $solicitud_por_id->marca }}">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="modelo">Modelo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control " id="modelo" name="modelo" placeholder="Modelo"  readonly value="{{ $solicitud_por_id->modelo }}">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="tipo">Tipo de Vehiculo</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control " id="tipo" name="tipo" placeholder="Tipo de Vehiculo"  readonly value="{{ $solicitud_por_id->tipo }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="color">Color</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control " id="color" name="color" placeholder="Color"  readonly value="{{ $solicitud_por_id->color }}">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="no_serie">N° de Serie</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="no_serie" name="no_serie" placeholder="N° de Serie" readonly value="{{ $solicitud_por_id->numero_serie }}">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="no_motor">N° de Motor</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('no_motor') is-invalid @enderror form-control " id="no_motor" name="no_motor" placeholder="N° de Motor" readonly value="{{ $solicitud_por_id->numero_motor }}">
                                        @error('no_motor')
                                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="_kilometroInicial">Kilometro Inicial</label>
                                    <div class="custom-file">
                                        <input type="text" class="@error('_kilometroInicial') is-invalid @enderror  form-control myClass" id="_kilometroInicial" name="_kilometroInicial" autocomplete="off" value="{{ $solicitud_por_id->km_inicial }}">
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
                                        <input type="text" class="form-control myClass" id="no_factura_compra" name="no_factura_compra" value="{{ $solicitud_por_id->numero_factura_compra }}">
                                    </div>
                                </div> 
                            </div>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-8 mb-3">
                                    <label for="placas">Nombre del Conductor</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control myClass" id="nombreConductor" name="nombreConductor" value="{{ $solicitud_por_id->conductor }}">
                                    </div> 
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="placas">Responsable de la Unidad</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="responsableUnidad" name="responsableUnidad" readonly value="{{ $solicitud_por_id->resguardante_unidad }}">
                                    </div> 
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="placas">Puesto del responsable de la unidad</label>
                                    <div class="custom-file">
                                        <input type="text" class="form-control" id="puestoResponsableUnidad" readonly name="puestoResponsableUnidad" readonly value="{{ $solicitud_por_id->puesto_resguardante_unidad }}">
                                    </div> 
                                </div>
                            </div>
                            <input type="hidden" class="form-control" name="idcatvehiculo" id="idcatvehiculo" readonly>
                            <hr>
                            {{-- botón de agregar elemento de la bitacora --}}
                            <button type="button" name="addBitacora" id="addBitacora" class="btn btn-success btn-md">
                                <i class="fas fa-plus-circle"></i> <b>Agregar Recorrido</b>
                            </button>
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
                                    <tbody>
                                        @foreach ($recorrido_bitacora as $k => $v)
                                        <tr>
                                            <td data-label="Fecha">
                                                <input type="date" name="agregarItem[{{ $v->id }}][fecha_bitacora]" value="{{ $v->fecha }}"  class="form-control" />
                                            </td>
                                            <td data-label="KM inicial">
                                                <input type="text" name="agregarItem[{{ $v->id }}][kminicial]" id="kmInicial"  class="form-control km_inicial_recorrido" value="{{ $v->kilometraje_inicial }}" />
                                            </td>
                                            <td data-label="De:">
                                                <textarea name="agregarItem[{{ $v->id }}][de]"  class="form-control">{{ $v->actividad_inicial }}</textarea>
                                            </td>
                                            <td data-label="a:">
                                                <textarea name="agregarItem[{{ $v->id }}][a]"   class="form-control">{{ $v->actividad_final }}</textarea>
                                            </td>
                                            <td data-label="KM final">
                                                <input type="text" name="agregarItem[{{ $v->id }}][kmfinal]" id="kmFinal[]" onchange="calcularKmTotales(this);" class="form-control kmFinal" value="{{ $v->kilometraje_final }}" />
                                            </td>
                                            <td data-label="Vales">
                                                <textarea name="agregarItem[{{ $v->id }}][vales]" id="vales[]" class="form-control numbersOnly vales_tag">{{ $v->vales }}</textarea>
                                            </td>
                                            <td data-label="Litros">
                                                <input type="text" name="agregarItem[{{ $v->id }}][litros]" id="litros[]" onchange="calcularLitrosTotales(this);"  class="form-control inst_litros" value="{{ $v->litros }}"/>
                                            </td>
                                            <td data-label="DV">
                                                <input type="text" name="agregarItem[{{ $v->id }}][dv]" id="dv[]" onchange="calcularImporte(this);" class="form-control denominacion_vales" value="{{ $v->division_vale }}"/>
                                            </td>
                                            <td data-label="Importe">
                                                <input type="text" name="agregarItem[{{ $v->id }}][importe]" id="importes[]"  class="form-control importe" readonly value="{{ $v->importe }}" />
                                            </td>
                                            <td data-label="Acción">
                                                <button type="button" class="btn btn-danger btn-circle btn-sm remove-tr">
                                                    <i class="fas fa-minus-circle"></i>
                                                </button>
                                            </td>
                                            <input type="hidden" name="agregarItem[{{ $v->id }}][id]" id="id[]" value="{{ $v->id }}">
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="table_wrapper">
                                <table class="table table-bordered" id="totalesDinamicos">
                                    <tbody>
                                      <tr>
                                        <td data-label="a:" style="width: 48.11%; text-align: right;" colspan="4">
                                            <h3><b>TOTALES:</b></h3>
                                        </td>
                                        <td data-label="KM final" style="width: 7%;">
                                            <input type="text" name="km_totales" id="km_totales"   class="form-control" readonly value="{{ $solicitud_por_id->total_km_recorridos }}"/>
                                        </td>
                                        <td data-label="Vales" style="width: 15%; text-align: right;">
                                            <h3><b>LITROS:</b></h3>
                                        </td>
                                        <td data-label="Litros" style="width: 7%;">
                                            <input type="text" name="litros_totales" id="litros_totales"  class="form-control" readonly value="{{ $solicitud_por_id->litros_totales }}"/>
                                        </td>
                                        <td data-label="DV" style="width: 7%;">
                                            &nbsp;
                                        </td>
                                        <td data-label="Importe" colspan="2" style="width: 16%;">
                                            <input type="text" name="importe_total" id="importe_total"  class="form-control importe" readonly value="{{ $solicitud_por_id->importe_total }}"/>
                                        </td>
                                      </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="form-row">
                                <label for="observaciones"><h5><b>OBSERVACIONES</b></h5></label>
                                <div class="col-md-12 mb-3">
                                    <textarea name="observaciones" id="observaciones" class="form-control" readonly cols="30" rows="5">{{ $solicitud_por_id->observacion }}</textarea>
                                </div>
                            </div>
                            <button class="btn btn-success" type="submit">
                                <i class="fas fa-check-double"></i>
                                Enviar a Firma
                            </button>
                            <input type="hidden" name="periodo_actual" id="periodo_actual" value="{{ $solicitud_por_id->periodo_actual }}">
                            <input type="hidden" name="solicitud_id" id="solicitud_id" value="{{ base64_encode($solicitud_por_id->id) }}">
                            <input type="hidden" name="catalogo_vehiculo_id" id="catalogo_vehiculo_id" value="{{ $solicitud_por_id->catalogo_vehiculo_id }}">
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
                    <div class="col-lg-12">
                        <button class="btn btn-squared-default btn-success" value="1a Quincena de ">
                            <i class="fas fa-calendar fa-4x"></i>
                            <br />
                            <span class="text">1° Quincena de </span>
                        </button>
                        &nbsp;&nbsp;
                        <button class="btn btn-squared-default btn-warning" value="2a Quincena de ">
                            <i class="fas fa-calendar fa-4x"></i>
                            <br />
                            <span class="text">2° Quincena de </span>
                        </button>
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
    <script src="{{ asset('assets/js_/typehead.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            //triger change event in case checkbox checked when user accessed page
            $("#habilitado").trigger("change")
            $('#form1 input').attr('readonly', 'readonly');

            $("#habilitado").change(function() {
                if (!this.checked) {
                    // $("#form1 input").attr('disabled', 'disabled');
                    // $("#form1 input").attr('readonly', 'true');
                    setTimeout(_ => $('body').addClass('busy'), 1000);
                    $("input.myClass[type=text]").attr('readonly', 'true');
                    $("input.myClass[type=date]").attr('readonly', 'true');
                    $("#observaciones").attr('readonly', 'true');
                }
                else {
                    $("input.myClass[type=text]").removeAttr('readonly');
                    $("input.myClass[type=date]").removeAttr('readonly');
                    $("#observaciones").removeAttr('readonly');
                }
            });
        });
        // $(document).ready(function(){

        //     var j = -1; //elemento inicial contador
        //     var max_fields = 200; //maximo elementos permitidos
        //     var addBitacora = $("#addBitacora");
        //     var sum = 0;
        //     var importeTotal = 0;

        //     $(addBitacora).click(function(){
        //         //Check maximum number of input fields
        //         if (j < max_fields) {
        //             j ++ ; // incrementando el contador
        //             if (j == 0) {
        //                 $("#dynamicTable").append(
        //                     '<tr>'+
        //                         '<td data-label="Fecha">'+
        //                             '<input type="date" name="agregarItem[' + j + '][fecha_bitacora]"  class="form-control" />'+
        //                         '</td>'+
        //                         '<td data-label="KM inicial">'+
        //                             '<input type="text" name="agregarItem[' + j + '][kminicial]" id="kmInicial"  class="form-control km_inicial_recorrido" />'+
        //                         '</td>'+
        //                         '<td data-label="De:">'+
        //                             '<textarea name="agregarItem[' + j + '][de]"  class="form-control"></textarea>'+
        //                         '</td>'+
        //                         '<td data-label="a:">'+
        //                             '<textarea name="agregarItem[' + j + '][a]"   class="form-control"></textarea>'+
        //                         '</td>'+
        //                         '<td data-label="KM final">'+
        //                             '<input type="text" name="agregarItem[' + j + '][kmfinal]" id="kmFinal[]" onchange="calcularKmTotales(this);" class="form-control kmFinal" />'+
        //                         '</td>'+
        //                         '<td data-label="Vales">'+
        //                             '<textarea name="agregarItem[' + j + '][vales]" id="vales[]" class="form-control numbersOnly vales_tag"></textarea>'+
        //                         '</td>'+
        //                         '<td data-label="Litros">'+
        //                             '<input type="text" name="agregarItem[' + j + '][litros]" id="litros[]" onchange="calcularLitrosTotales(this);"  class="form-control inst_litros" />'+
        //                         '</td>'+
        //                         '<td data-label="DV">'+
        //                             '<input type="text" name="agregarItem[' + j + '][dv]" id="dv[]" onchange="calcularImporte(this);" class="form-control denominacion_vales"/>'+
        //                         '</td>'+
        //                         '<td data-label="Importe">'+
        //                             '<input type="text" name="agregarItem[' + j + '][importe]" id="importes[]"  class="form-control importe" readonly />'+
        //                         '</td>'+
        //                         '<td data-label="Acción">'+
        //                             '<button type="button" class="btn btn-danger btn-circle btn-sm remove-tr">'+
        //                                 '<i class="fas fa-minus-circle"></i>'+
        //                             '</button>'+
        //                         '</td>'+
        //                     '</tr>'
        //                 );

        //                 var km_inicial = $('#_kilometroInicial');
        //                 if (km_inicial.val() == 'NaN' || km_inicial.val() == 0) {
        //                     $('#kmInicial').val(0);
        //                 } else {
        //                     $('#kmInicial').val(km_inicial.val());
        //                 }
        //             } else {
        //                 var km_recorrido_anterior = $('#dynamicTable tr').last().find('.kmFinal').val();
        //                 if (km_recorrido_anterior == 'NaN' || km_recorrido_anterior == 0) {
        //                     km_recorrido_anterior = 0;
                            
        //                 }
        //                 console.log(km_recorrido_anterior);
        //                 $("#dynamicTable").append(
        //                     '<tr>'+
        //                         '<td data-label="Fecha">'+
        //                             '<input type="date" name="agregarItem[' + j + '][fecha_bitacora]"  class="form-control" />'+
        //                         '</td>'+
        //                         '<td data-label="KM inicial">'+
        //                             '<input type="text" name="agregarItem[' + j + '][kminicial]" id="kmInicial" value="'+km_recorrido_anterior+'" class="form-control km_inicial_recorrido" />'+
        //                         '</td>'+
        //                         '<td data-label="De:">'+
        //                             '<textarea name="agregarItem[' + j + '][de]"  class="form-control"></textarea>'+
        //                         '</td>'+
        //                         '<td data-label="a:">'+
        //                             '<textarea name="agregarItem[' + j + '][a]"   class="form-control"></textarea>'+
        //                         '</td>'+
        //                         '<td data-label="KM final">'+
        //                             '<input type="text" name="agregarItem[' + j + '][kmfinal]" id="kmFinal[]" onchange="calcularKmTotales(this);" class="form-control kmFinal" />'+
        //                         '</td>'+
        //                         '<td data-label="Vales">'+
        //                             '<textarea name="agregarItem[' + j + '][vales]" id="vales[]" class="form-control numbersOnly vales_tag"></textarea>'+
        //                         '</td>'+
        //                         '<td data-label="Litros">'+
        //                             '<input type="text" name="agregarItem[' + j + '][litros]" id="litros[]" onchange="calcularLitrosTotales(this);"  class="form-control inst_litros" />'+
        //                         '</td>'+
        //                         '<td data-label="DV">'+
        //                             '<input type="text" name="agregarItem[' + j + '][dv]" id="dv[]" onchange="calcularImporte(this);" class="form-control denominacion_vales"/>'+
        //                         '</td>'+
        //                         '<td data-label="Importe">'+
        //                             '<input type="text" name="agregarItem[' + j + '][importe]" id="importes[]"  class="form-control importe" readonly />'+
        //                         '</td>'+
        //                         '<td data-label="Acción">'+
        //                             '<button type="button" class="btn btn-danger btn-circle btn-sm remove-tr">'+
        //                                 '<i class="fas fa-minus-circle"></i>'+
        //                             '</button>'+
        //                         '</td>'+
        //                     '</tr>'
        //                 );
        //             }
        //         }
        //     });

        //     //Once remove button is clicked
        //     $(document).on('click', '.remove-tr', function(e){
        //         e.preventDefault();
        //         var itemRemoved = $(this).closest('tr').find('.inst_litros').val();
        //         var totalLitros = $("#litros_totales").val();
        //         var importeitem = $(this).closest('tr').find('.importe').val();
        //         restarImporte(importeitem);
        //         restarLitros(itemRemoved);
        //         // se remueve la parte de la tabla
        //         $(this).parents('tr').remove();
        //         j--; //Decrement field counter
        //     });

        //     $(document).on('keyup', '.numbersOnly', function() {
        //         if (this.value != this.value.replace(/[^0-9\-,]/g, '')) {
        //             this.value = this.value.replace(/[^0-9\-,]/g, '');
        //         }
        //     });

        //     /** @author - Daniel Méndez Cruz
        //     *   @argument - evt
        //     */
        //     $(document).on('input', '.kmFinal', function(){
        //         if (this.value != this.value.replace(/[^0-9\-,]/g, '')) {
        //             this.value = this.value.replace(/[^0-9\-,]/g, '');
        //         }
        //     });

        //     $(document).on('input', '#kmInicial', function(){
        //         if (this.value != this.value.replace(/[^0-9\-,]/g, '')) {
        //             this.value = this.value.replace(/[^0-9\-,]/g, '');
        //         }
        //     });

        //     /*
        //     * funcion de javascript para obtener un dato
        //     */
        //     $(document).on('keyup', '.denominacion_vales', '.vales_tag', function(){
        //         //get amt and qty value
        //         var vales = $(this).closest('tr').find('.vales_tag').val();
        //         var denominacionVales = $(this).closest('tr').find('.denominacion_vales').val();
        //         if(check(vales) == true){
        //             // Code that needs to execute when none of the above is in the string
        //             separadores = ['-',','];
        //             textoseparado = vales.split (new RegExp (separadores.join('|'),'g'));
        //             var arreglo = [];
        //             for ( index = 0; index < textoseparado.length; index++) {
        //                 arreglo.push(textoseparado[index]);
        //             }

        //             arreglo.sort(function (a,b) {
        //                 return b-a;
        //             });
                    
        //             var sumatoria = calculo(arreglo);
                    
        //             var importe = sumatoria * denominacionVales;
        //             $(this).closest('tr').find('.importe').val(importe);
        //         }
        //     });

        //     /*
        //     * funcion para checar caracteres especiales
        //     */
        //     var specialChars = ",-";
        //     var check = function(string){
        //         for(i = 0; i < specialChars.length;i++){
        //             if(string.indexOf(specialChars[i]) > -1){
        //                 return true
        //             }
        //         }
        //         return false;
        //     }

        //     var calculo = (array) => {
        //         var resultado = 0;
        //         switch (array.length) {
        //             case 2:
        //                 return resultado =  Math.abs(parseInt(array[0], 10) - parseInt(array[1], 10)) + 1 ;
        //                 break;
        //             case 3:
        //                 var resultado1 = parseInt(array[0], 10) - parseInt(array[1], 10);
        //                 var resultado2 = parseInt(array[1], 10) - parseInt(array[2], 10);
        //                 return resultado = resultado1 + resultado2 + 1;
        //                 break;
        //             default:
        //                 break;
        //         }
        //     }

        //     $('input#_kilometroInicial').on('input', function() {
        //         this.value = this.value.replace(/[^0-9.,]/g, '').replace(/(\..*?)\..*/g, '$1');
        //     });

        //     var path = "{{ route('autocomplete') }}";
        //     $('input.typeahead').typeahead({
        //         source:  function (query, process) {
        //             return $.get(path, { term: query }, function (data) {
        //                 return process(data);
        //             });
        //         }
        //     });

        //     $("input.typeahead").focus(function(){
        //         if ($('input.typeahead').val().length != 0) {
        //             var url = "{{ route('softload') }}";
        //             var param = {
        //                 "type": $('input.typeahead').val()
        //             };
        //             $.ajax({
        //                 data:  param,
        //                 url:   url,
        //                 type:  'get',
        //                 beforeSend: function () {
        //                     console.log('Procesando, espere por favor...');
        //                 },
        //                 success:  function (response) {
        //                     $('#color').val(response[0]['color']);
        //                     $('#marca_vehiculo').val(response[0]['marca']);
        //                     $('#modelo').val(response[0]['modelo']);
        //                     $('#tipo').val(response[0]['tipo']);
        //                     $('#no_serie').val(response[0]['numero_serie']);
        //                     $('#responsableUnidad').val(response[0]['resguardante_unidad']);
        //                     $('#puestoResponsableUnidad').val(response[0]['puesto_resguardante_unidad']);
        //                     $('#idcatvehiculo').val(response[0]['id']);
        //                 }
        //             });
        //         } else {
                    
        //         }
        //     });

        //     $('#periodo').click(function () {
        //         $('#exampleModal').modal('show'); 
        //     });

        //     /**
        //     * @author - Daniel Méndez Cruz
        //     * @argument - periodo
        //     */
        //     $('.btn-squared-default').on('click', function(){
        //         $('#exampleModal').modal("toggle");
        //         var periodo = $(this).val();
        //         // obtener el primer carácter del periodo
        //         var primerCaracter = periodo.charAt(0);
        //         $('#periodo').val(periodo);
        //         $('#periodo_actual').val(primerCaracter);
        //     });

        //     /** @argument - arg
        //     * @author - Daniel Méndez Cruz
        //     */
        //     $('#_kilometroInicial').on('input', (event) => {
        //         $(this).val($(this).val().replace(/[^0-9]/g, ''));
        //     });
            
        // });
        // /** 
        // * funciones javascripts puras
        // */
        // function calcularImporte(valor){
        //     var cantidad = 0, precunit = 0, totalitem = 0 ;
        //     var tr = valor.parentNode.parentNode;
        //     var nodes = tr.childNodes;
        //     // ciclo
        //     for (let x = 0; x < nodes.length; x++) {
        //         if (nodes[x].firstChild.id == 'importes[]') {
        //             anterior = nodes[x].firstChild.value;
        //             totalitem = parseFloat(nodes[x].firstChild.value,10);
        //             nodes[x].firstChild.value = totalitem;
        //         }
        //     }
        //     var importeTotal = document.getElementById("importe_total");
        //     if (importeTotal.vale == 'NaN') {
        //         importeTotal.value = 0;
        //         // 
        //     }
        //     importeTotal.value = parseFloat(importeTotal.value) + totalitem; 
        // }

        // function restarImporte(argument){
        //     var elemento = 0;
        //     elemento = parseFloat(argument,10);
        //     var impTotal = document.getElementById("importe_total");
        //     if (impTotal.value == 'NaN' || impTotal.value == 0) {
        //         impTotal.value = 0;
        //         // 
        //     } else {
        //         impTotal.value = parseFloat(impTotal.value) - elemento;
        //     }
             
        // }

        // function calcularLitrosTotales(arg){
        //     var litrosTotales = 0, lts = 0, ltsanterior = 0;
        //     var t = arg.parentNode.parentNode;
        //     var nodos = t.childNodes;
        //     // generamos el ciclo
        //     for (let j = 0; j < nodos.length; j++) {
        //         if (nodos[j].firstChild.id == 'litros[]') {
        //             ltsanterior = nodos[j].firstChild.value;
        //             litrosTotales = parseFloat(nodos[j].firstChild.value,10);
        //             nodos[j].firstChild.value = litrosTotales;
        //         }
        //     }

        //     var ltsTotales = document.getElementById("litros_totales");
        //     if (ltsTotales.value == 'NaN') {
        //         ltsTotales.value = 0;
        //     }
        //     ltsTotales.value = parseFloat(ltsTotales.value) + litrosTotales; 
        // }
        // function restarLitros(args){
        //     var element = 0;
        //     element = parseFloat(args, 2);
        //     var callts = document.getElementById("litros_totales");
        //     if (callts.value == 'NaN' || callts.value == 0) {
        //         callts.value = 0;
        //     } else {
        //         callts.value = parseFloat(callts.value).toFixed(2) - element;
        //     }
        // }
        // function calcularKmTotales(ag) {
        //     var km_actual = 0, kmsanterior = 0;
        //     var t = ag.parentNode.parentNode;
        //     var nods = t.childNodes;
        //     var km_inicial = $('#_kilometroInicial').val();
        //     for (let i = 0; i < nods.length; i++) {
        //         if (nods[i].firstChild.id == 'kmFinal[]') {
        //             kmsanterior = nods[i].firstChild.value;
        //             km_actual = parseFloat(nods[i].firstChild.value,10);
        //             nods[i].firstChild.value = km_actual;
        //         }
        //     }
        //     var km_totales = document.getElementById("km_totales");
        //     if (km_totales.value == 'NaN') {
        //         km_totales.value = 0;
        //     }
        //     km_totales.value = parseFloat(km_actual - km_inicial);
        // }
    </script>
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
