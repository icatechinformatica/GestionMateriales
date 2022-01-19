{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main')

@section('title', 'Formulario Para la Solicitud de Suficiencia Presupuestal | SISCOM - ICATECH')

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

    table th, table td {
        padding: .625em;
        text-align: justify;
    }

    table th {
        font-size: .55em;
        letter-spacing: .1em;
        text-transform: uppercase;
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

                <!-- Illustrations -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Formulario para la Solicitud de Suficiencia Presupuestal</h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="mamorandum" class="control-label">Memoramdum de Solicitud</label>
                                    <input type="text" class="form-control" id="memorandumsolicitud" name="memorandumsolicitud" placeholder="ICATECH/0000/000/2020">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="mamorandum" class="control-label">Memoramdum de Requisición</label>
                                    <input type="text" class="form-control" id="memorandumsolicitud" name="memorandumsolicitud" placeholder="ICATECH/0000/000/2020">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fecha" class="control-label">Fecha</label>
                                    <input class="form-control" name="fecha" type="date" value="2020-01-01" id="fecha">
                                </div>
                            </div>
    
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputvalida" class="control-label">Nombre de Quien Valida</label>
                                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" id="nombre_valida" name="nombre_valida" placeholder="Nombre">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputvalida" class="control-label">Puesto de Quien Valida</label>
                                    <input type="text" class="form-control" readonly onkeypress="return soloLetras(event)" id="puesto_valida" name="puesto_valida" placeholder="Puesto">
                                    <input id="id_valida" name="id_valida" type="text" hidden>
                                </div> 
                            </div>
    
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="inputvalida" class="control-label">Nombre de Quien Recibe</label>
                                    <input type="text" class="form-control" onkeypress="return soloLetras(event)" id="nombre_valida" name="nombre_valida" placeholder="Nombre">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputvalida" class="control-label">Puesto de Quien Recibe</label>
                                    <input type="text" class="form-control" readonly onkeypress="return soloLetras(event)" id="puesto_valida" name="puesto_valida" placeholder="Puesto">
                                    <input id="id_valida" name="id_valida" type="text" hidden>
                                </div>
                            </div>
                            <hr>
                            <div class="field_wrapper">
                                <table class="table table-bordered" id="dynamicTable">
                                    <thead>
                                      <tr>
                                        <th>Proveedor</th>
                                        <th>Área</th>
                                        <th>Proyecto/Descripción</th>
                                        <th>Partida/Concepto</th>
                                        <th>Importe</th>
                                        <th>Acción</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td data-label="Proveedor"><input type="text" name="addmore[0][proveedor]" id="addmore[0][proveedor]" placeholder="Proveedor" class="form-control claveCurso" /></td>
                                        <td data-label="Área"><input type="text" name="addmore[0][area]" id="addmore[0][area]" placeholder="Área" class="form-control claveCurso" /></td>
                                        <td data-label="Proyecto/Descripción"><input type="text" name="addmore[0][proyectoDescripcion]" id="addmore[0][proyectoDescripcion]" placeholder="Área" class="form-control claveCurso" /></td>
                                        <td data-label="Partida/Concepto"><input type="text" name="addmore[0][partidaconcepto]" id="addmore[0][partidaconcepto]" placeholder="número presupuesto" class="form-control" value="12101" /></td>
                                        <td data-label="Importe"><input type="text" name="addmore[0][importe]" id="addmore[0][importe]" placeholder="importe total" class="form-control" readonly/><footer name="addmore[0][aviso]" id="addmore[0][aviso]" style="color: red"></footer></td>
                                        <td data-label="Acción">
                                            <button type="button" name="addSuficiencia" id="addSuficiencia" class="btn btn-success">
                                                <i class="fas fa-plus-circle"></i>
                                            </button>
                                        </td>
                                      </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 margin-tb">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-primary" >
                                            <i class="fas fa-paper-plane"></i>
                                            Enviar
                                        </button>
                                    </div>
                                </div>
                            </div>
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
        $(function(){
            //Botones en tabla modsupre
            var i = 0;

            $("#addSuficiencia").click(function(){

                ++i;
                $("#dynamicTable").append(
                    '<tr>'+
                        '<td>'+
                            '<input type="text" name="addmore['+i+'][proveedor]" id="addmore['+i+'][proveedor]" placeholder="Proveedor" class="form-control" />'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" name="addmore['+i+'][area]" id="addmore['+i+'][area]" placeholder="área" class="form-control" disabled value="12101" />'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" name="addmore['+i+'][proyectoDescripcion]" id="addmore['+i+'][proyectoDescripcion]" placeholder="Clave curso" class="form-control" />'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" name="addmore['+i+'][partidaconcepto]" id="addmore['+i+'][partidaconcepto]" placeholder="12101" class="form-control" readonly />'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" name="addmore['+i+'][importe]" id="addmore['+i+'][importe]" placeholder="importe" class="form-control" readonly />'+
                            '<footer name="addmore['+i+'][aviso]" id="addmore['+i+'][aviso]" style="color: red"></footer>'+
                        '</td>'+
                        '<td data-label="Acción">'+
                            '<button type="button" class="btn btn-danger remove-tr">'+
                                '<i class="fas fa-minus-circle"></i>'+
                            '</button>'+
                        '</td>'+
                    '</tr>'
                );
                //
            });

            $(document).on('click', '.remove-tr', function(){
                $(this).parents('tr').remove();
            });

        });

        function soloLetras(e) {
                key = e.keyCode || e.which;
                tecla = String.fromCharCode(key).toLowerCase();
                letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
                especiales = [8, 37, 39, 46];
                tecla_especial = false
                for(var i in especiales) {
                    if(key == especiales[i]) {
                        tecla_especial = true;
                        break;
                    }
                }
                if(letras.indexOf(tecla) == -1 && !tecla_especial)
                    return false;
        }
    </script>
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
