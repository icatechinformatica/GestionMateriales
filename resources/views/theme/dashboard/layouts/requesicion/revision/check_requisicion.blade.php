{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('REQUISICIÓN DE MATERIALES / Revisión'), 'titlePage' => __('SIRMAT | Revisión Solicitud')])

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
        <div class="col-lg-1 mb-4">
        </div>
        <div class="col-lg-10 mb-4">
            <div class="bd-example">
                <p>
                    <a href="{{ route('requisicion.revision.index') }}" class="btn btn-warning">
                        <i class="fas fa-undo"></i>
                        Regresar
                    </a>
                </p>
{{-- formulario --}}
    {!! Form::open(['method' => 'post', 'class' => 'form needs-validation', 'route' => 'requisicion.revision.validation', 'files' => true, 'novalidate']) !!}
                <div class="row g-2">
                    <div class="col-md">
                        {!! Form::label('', 'Área', [ 'class' => 'control-label']) !!}
                        <div class="form-floating">
                            <b>{{ strtoupper($reqRevision->area->nombre) }}</b>
                        </div>
                    </div>
                    <div class="col-md">
                        {!! Form::label('', 'Fecha de Requisición', ['class' => 'control-label']) !!}
                        <div class="form-floating">
                        @php
                            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                            $fecha = Carbon\Carbon::parse($reqRevision->fechaRequisicion);
                            $mes = $meses[($fecha->format('n')) - 1];
                            $fechaoutput = $fecha->format('d') . ' DE ' . strtoupper($mes) . ' DE ' . $fecha->format('Y');
                        @endphp
                            <b>{{ $fechaoutput }}</b>
                        </div>
                    </div>
                </div>
                &nbsp;
                <div class="row g-2">
                    <div class="col-md">
                        {!! Form::label('', 'Departamento', [ 'class' => 'control-label']) !!}
                        <div class="form-floating mb-3">
                            <b>{{ strtoupper($reqRevision->area->nombre) }}</b>
                        </div>
                    </div>
                </div>
                &nbsp;
                <div class="row g-2">
                    <div class="col-md">
                        {!! Form::label('', 'Solicita', ['class' => 'control-label']) !!}
                        <div class="form-floating mb-3">
                            <b>{{ strtoupper($reqRevision->solicita) }}</b>
                        </div>
                    </div>
                    <div class="col-md">
                        {!! Form::label('', 'Autoriza', ['class' => 'control-label']) !!}
                        <div class="form-floating"> 
                            <b>{{ strtoupper($reqRevision->autoriza) }}</b>
                        </div>
                    </div>
                </div>
                {!! Form::hidden('id_requisicion', $id_req ,['id' => 'id_requisicion']) !!}
                <hr>
                <div class="field_wrapper">
                    <table class="table table-bordered" id="requisicionTable_">
                        @php
                            $j = 1;
                            $sum = 0;
                            $sum2 = 0;
                            foreach($reqRevision->partidapresupuestal as $item => $value)
                            {
                                $sum += 1;
                                foreach($value->requisicionunidad as $item)
                                {
                                    $sum2 += 1;
                                }
                            }
                            $totalrows = $sum + $sum2;
                        @endphp
                        <thead>
                            <tr>
                                <th  style="width: 40%;">PARTIDA PRESUPUESTAL</th>
                                <th  style="width: 40%;">CONCEPTO</th>
                                <th style="width: 20%">JUSTIFICACIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reqRevision->partidapresupuestal as $item => $value)
                                <tr>
                                    <td data-label="PARTIDA PRESUPUESTAL">
                                        <b>{{ $value->partida_presupuestal }}</b>
                                    </td>
                                    <td data-label="CONCEPTO">
                                        <b>{{ strtoupper($value->concepto)  }}</b>
                                    </td>
                                    @if($item == 0)
                                        <td rowspan="{{ $totalrows }}">
                                            <b>{{ strtoupper($reqRevision->justificacion) }}</b>
                                        </td>
                                    @endif
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        @php
                                            $i = 1;
                                        @endphp
                                        @if (count($value->requisicionunidad) > 0)
                                            @foreach ($value->requisicionunidad as $item)
                                                <table class="table table-bordered" id="partidaPresupuestal_{{ $i }}_{{ $j }}">
                                                    <thead>
                                                        <tr>
                                                            <th  style="width: 20%;">CANT.</th>
                                                            <th  style="width: 20%;">UNIDAD</th>
                                                            <th  style="width: 50%;">DESCRIPCIÓN</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td data-label="CANT.">
                                                                <label>{{ $item['cantidad'] }}</label>
                                                            </td>
                                                            <td data-label="UNIDAD">
                                                                <label>{{ strtoupper($item['unidad']) }}</label>
                                                            </td>
                                                            <td data-label="DESCRIPCIÓN">
                                                                <label>
                                                                    <b>
                                                                        {{ strtoupper($item['descripcion']) }}
                                                                    </b>
                                                                </label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $j++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row g-2">
                    <div class="col-md">
                        {!! Form::textarea('observaciones','',[
                            'class' => 'form-control',
                            'rows' => 5,
                            'cols' => 30,
                            'name' => 'observaciones',
                            'id' => 'observaciones'
                        ]) !!}
                    </div>
                </div>
                <br>
                {!! 
                    Form::button(
                        '<i class="fas fa-archive"></i> Archivar', 
                        ['class' => 'btn btn-success', 'type' => 'submit']
                    )
                !!}
    {!! Form::close() !!}
{{-- formulario END --}}
                {{-- incluir mensaje --}}
                @include('theme.dashboard.messages.flash_message')
                {{-- incluir mensaje END --}}
            </div>
        </div>
        <div class="col-lg-1 mb-4"></div>
       @include('theme.dashboard.layouts.requesicion.modal.requisicion_enviar_moda')
    </div>
@endsection

@section('contenidoJavaScript')
    
@endsection
{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
