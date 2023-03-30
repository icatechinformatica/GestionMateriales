{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('Facturas / Indice Facturas'), 'titlePage' => __('SIRMAT | Indice de Facturas')])

@section('contenidoCss')
    <style>
        /* .dark-nav {
            background-color: #E5E7E9;
            height: 100vh;
            width: 100%;
        } */

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
            margin-top: 10px;
        }
        .btn-circle.btn-lg {
            width: 50px;
            height: 50px;
            padding: 10px 16px;
            font-size: 18px;
            line-height: 1.33;
            border-radius: 25px;
        }
        .btn-circle.btn-xl {
            width: 70px;
            height: 70px;
            padding: 10px 16px;
            font-size: 24px;
            line-height: 1.33;
            border-radius: 35px;
        }

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
            background-color: #E5E7E9;
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
{{-- tabla --}}
<div class="container-fluid dark-nav">
    <div class="row">
        <div class="col-2">
            <a type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" href="{{ route('factura.create') }}">
                <i class="fas fa-plus"></i> Agregar Factura
            </a>
        </div>
        <div class="col-6">

        </div>
        <div class="col-4"></div>
    </div>
    <hr>
    <table>
        <caption>Lista de Facturas</caption>
        <thead>
          <tr>
            <th scope="col">Folio/Serie</th>
            <th scope="col">Concepto</th>
            <th scope="col">Total</th>
            <th scope="col">Detalles</th>
          </tr>
        </thead>
        <tbody>
            @if (count($factura) > 0)
               @foreach ($factura as $k => $v)
                    <tr>
                        <td data-label="Folio/Serie"></td>
                        <td data-label="Concepto"></td>
                        <td data-label="Total"></td>
                        <td data-label="Detalles">
                            <a type="button" class="btn btn-info btn-circle btn-lg" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                    </tr>
               @endforeach
            @else
                <tr>
                    <td colspan="4"><center><h3> <b>NO HAY REGISTROS PARA MOSTRAR</b> </h3></center></td>
                </tr>
            @endif
        </tbody>
    </table>


</div>
{{-- tabla END --}}
@endsection

@section('contenidoJavaScript')

@endsection
{{--  --}}
