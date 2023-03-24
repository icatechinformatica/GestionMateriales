{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('REQUISICIÓN DE MATERIALES / MODIFICAR REQUISICIÓN '.$requisicion_editar->partida_presupuestal), 'titlePage' => __('SIRMAT | Nueva Requisición de Materiales')])

@section('contenidoCss')
    <style>
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
        font-size: .85em;
        letter-spacing: .1em;
        text-transform: uppercase;
        }

        .bd-example {
            --bd-example-padding: 1rem;
            position: relative;
            padding: 1.5rem;
            margin: 0 -1.5rem;
            border: solid hsla(215, 30%, 92%, 0.877);
            border-width: 1px 0;
            background-color: #f8f8f8;
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

        @media (min-width: 768px)
        {
            .bd-example {
                --bd-example-padding: 1.5rem;
                margin-right: 0;
                margin-left: 0;
                border-width: 1px;
                border-top-left-radius: 0.375rem;
                border-top-right-radius: 0.375rem;
                background-color: #ffffff;
            }
        }
    </style>
@endsection

@section('contenido')
    <div class="row">
        <div class="col-lg-1 mb-4"></div>
        <div class="col-lg-10 mb-4">
            <div class="bd-example">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <p>
                    <a href="{{ route('requisicion.index') }}" class="btn btn-warning">
                        <i class="fas fa-undo"></i>
                        Regresar
                    </a>
                    <a id="btnHabilitar" class="btn btn-success">
                        <i class="fas fa-lock-open"></i>
                        Habilitar
                    </a>
                </p>
                {{-- formulario --}}
                {!! Form::open(['method' => 'PUT', 'class' => 'form needs-validation', 'route' => ['requisicion.modify', 'id' => $requisicion_editar->id ], 'files' => true, 'novalidate']) !!}
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating">
                            {!! Form::text('area_solicita', '',['class' => 'form-control', 'required', 'readonly']) !!}
                            {!! Form::label('area_solicita', 'Área que Solicita', ['for' => 'area_solicita', 'class' => 'control-label']) !!}
                            <div class="invalid-feedback">
                                Proveer Área Solicita 
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            {!! Form::date('fechaRequisicion', $requisicion_editar->fechaRequisicion,['class' => 'form-control', 'required', 'readonly']) !!}
                            {!! Form::label('fechaRequisicion', 'Fecha de Requisición', ['for' => 'fechaRequisicion', 'class' => 'control-label']) !!}
                            <div class="invalid-feedback">
                                Proveer Fecha 
                            </div>
                        </div>
                    </div>
                </div>
                &nbsp;
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            {!! Form::text('depto', $requisicion_editar->area->nombre,['class' => 'form-control', 'required', 'id' => 'deptos', 'readonly']) !!}
                            {!! Form::label('depto', 'Departamento', ['for' => 'depto', 'class' => 'control-label']) !!}
                            <div class="invalid-feedback">
                                Proveer Departamento
                            </div>
                        </div>
                    </div>
                </div>
                &nbsp;
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            {!! Form::text('solicita', $requisicion_editar->solicita,['class' => 'form-control', 'required', 'id' => 'solicita', 'autocomplete' => 'off', 'readonly']) !!}
                            {!! Form::label('solicita', 'Solicita', ['for' => 'solicita', 'class' => 'control-label']) !!}
                            <div class="invalid-feedback">
                                Proveer Solicita
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="form-floating">
                            {!! Form::text('autoriza', $requisicion_editar->autoriza ,['class' => 'form-control', 'required', 'readonly']) !!}
                            {!! Form::label('autoriza', 'Autoriza', ['for' => 'autoriza', 'class' => 'control-label']) !!}
                            <div class="invalid-feedback">
                                Proveer Autoriza 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-md">
                        <div class="form-floating mb-3">
                            {!! Form::textarea('justificacion', $requisicion_editar->justificacion , ['class' => 'form-control', 'name' => 'justificacion', 'id' => 'justificacionId', 'rows' => '50', 'cols' => '40','style' => 'height: 90px', 'readonly']) !!}
                            {!! Form::label('justificacion', 'Justificación', ['for' => 'justificacion', 'class' => 'control-label']) !!}
                        </div>
                    </div>
                </div>
                <hr>
                {!! Form::hidden('id_departamento', $requisicion_editar->area->id,['id' => 'id_departamento']) !!}
                <br>
                    {!! Form::button('<i class="fas fa-plus-square"></i> Agregar', 
                        ['class' => 'btn btn-info', 'id' => 'btnAgregar']
                    ) !!}
                <hr>
                <div class="field_wrapper">
                   @php
                       $i = 1;
                   @endphp
                   @foreach ($requisicion_editar->partidapresupuestal as $k => $v)
                        <table class="table table-bordered" id="requisicionTable_{{ $i }}">
                            <thead>
                                <tr>
                                    <th  style="width: 40%;">PARTIDA PRESUPUESTAL</th>
                                    <th  style="width: 40%;">CONCEPTO</th>
                                    <th  style="width: 10%">AGREGAR</th>
                                    <th  style="width: 10%;">QUITAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td data-label="PARTIDA PRESUPUESTAL">
                                        <input type="text" name="itemPartida[{{ $i }}][partida_presupuestal]" id="partida_presupuestal[]" autocomplete="off"  class="form-control" value="{{ $v->partida_presupuestal }}"/>
                                    </td>
                                    <td data-label="CONCEPTO">
                                        <input type="text" name="itemPartida[{{ $i }}][concepto]" id="unidad[]" autocomplete="off"  class="form-control" value="{{ $v->concepto }}"/>
                                    </td>
                                    <td data-label="AGREGAR">
                                        <a href="javascript:;" class="btn btn-success btn-circle btn-sm addItemPartidaPresupuestal" id="{{ $i }}">
                                            <i class="fas fa-database"></i>
                                        </a>
                                    </td>
                                    <td data-label="QUITAR">
                                        {!! Form::button('', ['class' => 'btn-close remove-tr', 'type' => 'button', 'arial-label' => 'Close']) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div id="addItemPartida_{{ $i }}">
                                           @if (count($v->requisicionunidad) > 0)
                                           @php
                                               $j= 1;
                                           @endphp
                                                @foreach ($v->requisicionunidad as $item)
                                                    <table class="table table-bordered" id="partidaPresupuestal_{{ $i }}_{{ $j }}">
                                                        <thead>
                                                            <tr>
                                                            <th  style="width: 20%;">CANT.</th>
                                                            <th  style="width: 20%;">UNIDAD</th>
                                                            <th  style="width: 50%;">DESCRIPCIÓN</th>
                                                            <th  style="width: 10%">QUITAR</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td data-label="CANT.">
                                                                    <input type="text" name="itemPartida[{{ $j }}][{{ $i }}][cantidad]" class="form-control cantidades" id="cantidad[]" autocomplete="off" value="{{ $item['cantidad'] }}"/>
                                                                </td>
                                                                <td data-label="UNIDAD">
                                                                    <input type="text" name="itemPartida[{{ $j }}][{{ $i }}][unidad]" class="form-control" id="unidad[]" autocomplete="off" value="{{ $item['unidad'] }}"/>
                                                                </td>
                                                                <td data-label="DESCRIPCIÓN">
                                                                    <textarea name="itemPartida[{{ $j }}][{{ $i }}][descripcion]" id="descripcion[]" class="form-control" rows="2" cols="30">{{ $item['descripcion'] }}</textarea>
                                                                </td>
                                                                <td data-label="QUITAR">
                                                                    <button id="EliminarElemento_{{ $j }}_{{ $i }}" class="btn-close remove-item-tr" arial-label="Close"></button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                   @php
                                                       $i++;
                                                   @endphp
                                                @endforeach
                                           @endif
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @php
                            $i++;
                        @endphp
                   @endforeach
                </div>
                <hr>
                {!! 
                    Form::button(
                        '<i class="fas fa-save" aria-hidden="true"></i> Modificar', 
                        ['class' => 'btn btn-danger', 'type' => 'submit']
                    )
                !!}
                {!! Form::close() !!}
                <br>
                {{-- incluir mensaje --}}
                @include('theme.dashboard.messages.flash_message')
                {{-- incluir mensaje END --}}
            </div>
        </div>
        <div class="col-lg-1 mb-4"></div>
    </div>
@endsection

@section('contenidoJavaScript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });
    /*
    * contenido de Javascript funcion para validar
    */
    (()=> {
        'use strict'
        // obtener los datos de todos los formularios que queremos aplicar la validación de bootstrap personalizada
        let contador = 0;
        const max_fields = 1000;
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated')
            }, false);
        });

        const btnAdd = document.getElementById('btnAgregar');
        btnAdd.addEventListener('click', event => {
            if (contador < max_fields) {
                contador++;
                $('#requisicionTable').append(
                    '<tr>' +
                        '<td data-label="CANT.">'+
                            '<input type="text" name="itemRequisicion['+contador+'][cantidad]" id="cantidad[]" autocomplete="off"  class="form-control cantidades"/>' +
                        '</td>'+
                        '<td data-label="UNIDAD">'+
                            '<input type="text" name="itemRequisicion['+contador+'][unidad]" id="unidad[]" autocomplete="off"  class="form-control"/>'+
                        '</td>' +
                        '<td data-label="DESCRIPCIÓN">' +
                            '<textarea name="itemRequisicion['+contador+'][descripcion]" id="descripcion[]" class="form-control" rows="2" cols="30"></textarea>' +
                        '</td>' +
                        '<td data-label="JUSTIFICACIÓN">' +
                            '<textarea name="itemRequisicion['+contador+'][justificacion]" id="justificacion[]" class="form-control" rows="2" cols="30"></textarea>' +
                        '</td>' +
                        '<td data-label="QUITAR">' +
                            '{!! Form::button('', ['class' => 'btn-close remove-tr', 'type' => 'button', 'arial-label' => 'Close']) !!}' +
                        '</td>' +
                    '</tr>'
                );
        }
        });

        /*
        * eliminar elementos
        */
        $(document).on('click', '.remove-tr', function(e){
            e.preventDefault();
            // se remueve la parte de la tabla
            $(this).parents('tr').remove();
            contador--;
        });

        $(document).on('keyup', '.cantidades', function() {
            if (this.value != this.value.replace(/[^0-9\-,]/g, '')) {
                this.value = this.value.replace(/[^0-9\-,]/g, '');
            }
        });

        /**
         * onlyfans
         * */
        $(document).on('click', '#btnHabilitar', function(e){
            e.preventDefault();
            //habilitar
            $('input[type=text], input[type=date], textarea').attr("readonly", false);
        })


        /**
         * @author - Daniel Méndez Cruz
         * @argument - name
         * ajax - requisicion.partida.solicita
        */
        $( "input#solicita" ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "{{ route('requisicion.partida.solicita') }}",
                    method: 'GET',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function( data ) {
                        response( data );
                    },
                    error: (error) => {
                        console.log(error.responseJSON.message);
                    }
                });
            }
        });

        $("input#deptos").autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: "{{ route('requisicion.partida.getdepto') }}",
                    method: 'GET',
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function( data ) {
                        response(data);
                    },
                    error: (error) => {
                        console.log(error.responseJSON.message);
                    }
                });
            },
            minLength: 2,
            select: function (event, ui){
                $("input#id_departamento").val(ui.item.id);
            }
        });
    })();
    
</script>
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}