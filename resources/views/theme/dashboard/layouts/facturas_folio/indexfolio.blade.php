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
        <div class="col-10">

        </div>
    </div>
    <hr>
    <table>
        <caption>Lista de Facturas</caption>
        <thead>
          <tr>
            <th scope="col">Folio/Serie</th>
            <th scope="col">Proveedor</th>
            <th scope="col">Total</th>
            <th scope="col">Modificar</th>
            <th scope="col">Agregar Folios</th>
          </tr>
        </thead>
        <tbody>
            @if (count($factura) > 0)
               @foreach ($factura as $k => $v)
                    <tr>
                        <td data-label="Folio/Serie">{{ $v->serie }}</td>
                        <td data-label="Proveedor">{{ $v->proveedores->nombre }}</td>
                        <td data-label="Total">@money($v->total)</td>
                        <td data-label="Modificar">
                            <a type="button" class="btn btn-info btn-circle btn-lg" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" href="{{ route('factura.edit', ['id' => base64_encode($v->id)]) }}">
                                <i class="fas fa-wrench"></i>
                            </a>
                        </td>
                        <td data-label="Agregar Folios">
                            <a href="{{ route('factura.add.folio', ['id' => base64_encode($v->id)]) }}" rel="noopener noreferrer" class="btn btn-success btn-circle btn-lg">
                                <i class="fas fa-plus"></i>
                            </a>
                        </td>
                    </tr>
               @endforeach
            @else
                <tr>
                    <td colspan="5"><center><h3> <b>NO HAY REGISTROS PARA MOSTRAR</b> </h3></center></td>
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
