{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('Folio / Asignación de Folios'), 'titlePage' => __('SIRMAT | Asignación de Folios')])

@section('contenidoCss')
    <link href="{{ asset('css/folioStyle.css') }}" rel="stylesheet">
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
        <div class="col-lg-14 md-4 posicionamiento_flotante">
            <span id="success_message"></span>
            <div class="card shadow mb-4">
                <div class="card-header text-white" style="background-color: #621132;"><b>Asignación de Folios</b></div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-2">
                            <a type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top" href="{{ route('folios.assign.create') }}">
                                <i class="fas fa-cogs"></i> Asignar Folios
                            </a>
                        </div>
                        <div class="col-10">

                        </div>
                    </div>
                    <hr>
                    <table>
                        <caption>Lista de Asignaciones</caption>
                        <thead>
                          <tr>
                            <th scope="col">Placas</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Serie</th>
                            <th scope="col">Información</th>
                          </tr>
                        </thead>
                        <tbody>
                           @if (count($catVehiculo))
                            @foreach ($catVehiculo as $k => $v)
                                <tr>
                                    <td><i class="fas fa-truck-pickup"></i> <b>{{ $v->placas }}</b></td>
                                    <td>{{ $v->marca }}</td>
                                    <td>{{ $v->tipo." ".$v->modelo }}</td>
                                    <td>{{ $v->numero_serie }}</td>
                                    <td>
                                        <a rel="noopener noreferrer" class="btn btn-info btnModalShow" id="{{ base64_encode($v->id) }}">
                                            <i class="fas fa-info-circle"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                           @else
                                <tr>
                                    <td colspan="5"><center><h3> <b>NO HAY REGISTROS</b> </h3></center></td>
                                </tr>
                           @endif
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <hr>
</div>
{{-- tabla END --}}
@endsection

@section('modals')
    {{-- incluir modal --}}
    @include('modals.modalinfoasignacion')
    {{-- incluir modal END --}}
@endsection

@section('contenidoJavaScript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $(document).ready(function(){
            // inciamos el documento
            // clic botón de mostrar detalles
            $('a.btnModalShow').on('click', async (e)=> {
                var $this = $(e.currentTarget);
                let id = $this.attr('id');
                if (id.length > 0) {
                    // si hay algún registro tenemos que cargar el módal con registros
                    let urlReq = "{{ route('folioGetDetails', ':id') }}";
                    let contenido = '';
                    let contendioFolio = '';
                    urlReq = urlReq.replace(':id', id);
                    await $.get(urlReq)
                        .done(function(response, textStatus, jqXHR){
                            // vamos a cargar el modal con la información de la consulta
                            let respuesta =response.res; // obtenemos la respuesta

                            Object.entries(respuesta['folio']).forEach(([key, value]) => {
                                /**
                                 * iterando el objeto por foreach
                                */
                                contendioFolio += `<div class="col-md-3">`+
                                                    `<span class="badge badge-success">${value['numero_folio']}</span>`+
                                                  `</div>`;
                            });
                            // limpiar el div
                            $("#modalAFolios .content").empty();

                            // cargar el contenido generado por html en la variable
                            contenido += `<div class="form-group">`+
                                            `<div>`+
                                                `<a href="{{ route('solicitud.bitacora.previo.guardado') }}" class="btn btn-success"><i class="fas fa-link"></i> Generar Bitácora</a>`+
                                            `</div>`+
                                        `</div>`+
                                        `<div class="form-row">`+
                                            `<div class="col-md-7">`+
                                                `<div>`+
                                                    `<b>${respuesta['marca']} ${respuesta['linea']} ${respuesta['modelo']}</b>` +
                                                `</div>`+
                                            `</div>` +
                                            `<div class="col-md-4">`+
                                                `<div>`+
                                                    `Color: <b>${respuesta['color']}</b>`+
                                                `</div>`+
                                            `</div>`+
                                        `</div>`+
                                        `<div class="form-group">`+
                                            `<label class="control-label">Tipo</label>`+
                                            `<div>`+
                                                `<b>${respuesta['tipo']}</b>`+
                                            `</div>`+
                                        `</div>`+
                                        `<div class="form-row">`+
                                            `<div class="col-md-3">`+
                                                `<label class="control-label">Placas</label>`+
                                                `<div>`+
                                                    `<b>${respuesta['placas']}</b>`+
                                                `</div>`+
                                            `</div>`+
                                            `<div class="col-md-5">`+
                                                `<label class="control-label">número de serie</label>`+
                                                `<div>`+
                                                    `<b>${respuesta['numero_serie']}</b>`+
                                                `</div>`+
                                            `</div>`+
                                            `<div class="col-md-4">`+
                                                `<label class="control-label">número económico</label>`+
                                                `<div>`+
                                                    `<b>${respuesta['numero_economico']}</b>`+
                                                `</div>`+
                                            `</div>`+
                                        `</div>`+
                                        `<hr>`+
                                        `<h3>DATOS DEL RESGUARDANTE</h3>`+
                                        `<div class="form-group">`+
                                            `<label class="control-label">Resguardante</label>`+
                                            `<div>`+
                                                `<b>${respuesta['resguardante']['resguardante_unidad']}</b>`+
                                            `</div>`+
                                        `</div>`+
                                        `<div class="form-group">`+
                                            `<label class="control-label">Puesto Resguardante</label>`+
                                            `<div>`+
                                                `<b>${respuesta['resguardante']['puesto_resguardante_unidad']}</b>`+
                                            `</div>`+
                                        `</div>`+
                                        `<hr>`+
                                        `<h4>Vales de combustible asignados al vehículo</h4>`+
                                        `<div class="form-row">`+
                                            `${contendioFolio}`+
                                        `</div>`;


                            $('#modalAFolios .content').append(contenido); // cargar contenido al modal
                            $('#modalAFolios').modal({show:true});// mostrar modal
                        })
                        .fail(function(jqXHR, textStatus, errorThrown){
                            console.log(jqXHR.statusText);
                            console.log(jqXHR.responseText);
                            console.log(jqXHR.status);
                            console.log(textStatus);
                            console.log(errorThrown);
                        });
                }
            });
        });
    </script>
@endsection
{{--  --}}
