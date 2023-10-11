{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('Devoluciones / Folios'), 'titlePage' => __('SIRMAT | Devolución de Folios')])

@section('contenidoCss')
    <link href="{{ asset('css/folioStyle.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> tailwind --}}
    <link rel="stylesheet" href="{{ asset('css/loaderspinner.css') }}">
@endsection

@section('contenido')
    {{-- tabla --}}
    <div class="container-fluid dark-nav">
        <div class="row">
            <div id="cover-spin"></div>
            <div class="col-1"></div>
            <div class="col-10 items-center">
                <div class="card shadow mb-4">
                    <div class="card-header text-white" style="background-color: #621132;"><b>Devolución de Folios a los
                            automóviles</b></div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach ($vehiculos as $item)
                                <a class="list-group-item list-group-item-action btnModalReturn" data-toggle="modal"
                                    data-target="#staticBackdrop" id="{{ base64_encode($item->id) }}">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1"><i class="fas fa-car"></i>
                                            {{ $item->marca . ' ' . $item->linea }}
                                        </h5>
                                        <small class="text-muted">
                                            <span class="badge bg-danger">{{ $item->placas }}</span>
                                        </small>
                                    </div>
                                    <p class="mb-1">Resguardante: {{ $item->resguardante->resguardante_unidad }}</p>
                                    <p class="mb-1">Número de Serie: {{ $item->numero_serie }}</p>
                                    <small class="text-muted">Tipo {{ $item->tipo }}, Modelo: {{ $item->modelo }}</small>
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-1"></div>
        </div>

    </div>
    {{-- tabla END --}}
@endsection

@section('modals')
    {{-- incluir modal --}}
    @include('modals.modalreturninvoice')
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

        $(document).ready(function() {
            $('a.btnModalReturn').on('click', async (event) => {
                let btnModal = $(event.currentTarget);
                let id = btnModal.attr('id');
                $("#staticBackdrop .content").empty(); // borrar contenido del modal
                if (id.length > 0) {
                    //
                    let URLQry = "{{ route('devoluciones.show', ':id') }}";
                    let contenido = '';
                    let contenidoFolio = '';
                    URLQry = URLQry.replace(':id', id);
                    await $.get(URLQry)
                        .done(function(response, textStatus, jqXHR) {
                            let respuesta = response;
                            if (respuesta?.data.length > 0) {
                                let res = respuesta.data;
                                const arr = Array.from(res);
                                let cargar = loadContent(arr, contenido, contenidoFolio, id);
                                // limpiar el div
                                $('#staticBackdrop .content').append(
                                    cargar); // cargar contenido al modal
                                $('#staticBackdrop').modal({
                                    show: true
                                }); // mostrar modal
                            }
                        })
                        .fail(function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR.statusText);
                            console.log(jqXHR.responseText);
                            console.log(jqXHR.status);
                            console.log(textStatus);
                            console.log(errorThrown);
                        });
                }
            });

            // checkbox
        });

        function loadContent(arrContent = [], contenido = '', contenidoFolio = '', param = '') {
            Object.entries(arrContent).forEach(function([key, value]) {
                contenidoFolio +=
                    `<div class="col-md-4" id="${value['numero_folio']}">` +
                    `<div class="form-switch">` +
                    `<input class="form-check-input" type="checkbox" role="switch" id="check_${parseInt(key) + 1}" onchange="cambiar(this, '${param}')" value="${value['numero_folio']}">` +
                    `<span class="badge badge-info">${value['numero_folio']}</span>` +
                    `</div>` +
                    `</div>`;
            });

            contenido += `<div class="form-row">` +
                `${contenidoFolio}` +
                `</div>`;

            return contenido;
        }

        function cambiar(element, paramid) {
            const checkboxId = $(element).attr('id');
            var checkedValue = document.querySelector(`#${checkboxId}:checked`);
            if (checkedValue?.value.length > 0) {
                let URL = "{{ route('devoluciones.folio.done', [':id', ':folio']) }}";


                let elemento = document.getElementById(checkedValue?.value);
                URL = URL.replace(':id', paramid);
                URL = URL.replace(':folio', checkedValue?.value);
                // si es mayor a cero vamos a ejecutar el método

                $.ajax({
                    url: URL,
                    method: 'DELETE',
                    dataType: 'json',
                    beforeSend: function() {
                        $('#cover-spin').show(0);
                    },
                    success: function(response, textStatus, jqXHR) {
                        if (response.Data === true) {
                            elemento.style.display = "none"; // se elimina el elemento
                            $('#cover-spin').hide(0); // ocultamos el spinner
                            $('#returninvoicealert').fadeIn(1000);
                            setTimeout(function() {
                                $('#returninvoicealert').fadeOut(1000);
                            }, 5000);
                        }
                    },
                    error: function(xhr, textStatus, error) {
                        // manejar errores
                        console.log(xhr.statusText);
                        console.log(xhr.responseText);
                        console.log(xhr.status);
                        console.log(textStatus);
                        console.log(error);
                        $('#cover-spin').show(0);
                    }
                })


                // $.get(URL)
                //     .done(function(response, textStatus, jqXHR) {
                //         if (response.data.Data) {
                //             console.log(response.data.Data);
                //             elemento.style.display = "none"; // se elimina el elemento
                //             $('#cover-spin').hide(0); // ocultamos el spinner
                //         }

                //     })
                //     .fail(function(jqXHR, textStatus, errorThrown) {
                //         console.log(jqXHR.statusText);
                //         console.log(jqXHR.responseText);
                //         console.log(jqXHR.status);
                //         console.log(textStatus);
                //         console.log(errorThrown);
                //         $('#cover-spin').hide(0); // ocultamos el spinner
                //     })
                //     .always(function() {
                //         $('#cover-spin').show(0);
                //     });
            }
        }
    </script>
@endsection
{{--  --}}
