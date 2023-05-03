{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('Facturas / Indice Facturas'), 'titlePage' => __('SIRMAT | Indice de Facturas')])

@section('contenidoCss')
    <link href="{{ asset('css/folioStyle.css') }}" rel="stylesheet">
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
                        <td data-label="Folio/Serie">{{ $v->serie }}</td>
                        <td data-label="Concepto">{{ $v->concepto }}</td>
                        <td data-label="Total">@money($v->total)</td>
                        <td data-label="Detalles">
                            <a type="button" class="btn btn-danger btn-circle btn-lg" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" href="{{ route('factura.getfile', ['filename' => $v->id]) }}" target="_blank">
                                <i class="fas fa-file-pdf"></i>
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
