{{-- DISEÑADO Y DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ --}}
@extends('theme.dashboard.main', ['breadcrum' => __('Facturas / Nuevas Facturas'), 'titlePage' => __('SIRMAT | Capturar Factura')])

@section('contenidoCss')
    <link href="{{ asset('css/folioCreateStyle.css') }}" rel="stylesheet">
@endsection

@section('contenido')
{{-- tabla --}}
<div class="container-fluid dark-nav">
    <div class="row">
        <div class="col-lg-1 mb-4"></div>
        <div class="col-lg-10 mb-4">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <span id="success_message"></span>
            <div class="card shadow mb-4">
                <div class="card-body">
{{-- FORM --}}
                    <form method="POST" id="frmFacturastore" enctype="multipart/form-data">
                {{--   @csrf TOKEN --}}
                            @csrf
                {{--  @csrf TOKEN END --}}
                {{-- Agregar Formulario --}}
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="memo_comision">&nbsp;</label>
                                            <div class="custom-file">
                                                <h3><b>CARGAR FACTURA</b></h3>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-7 mb-3 process" style="display:none;">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" style=""></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="fecha_comision">Cliente</label>
                                            <div class="custom-file">
                                                <input type="text" name="cliente" id="cliente" class="@error('cliente') is-invalid @enderror form-control" autocomplete="off">
                                                @error('cliente')
                                                    <div class="alert alert-danger mt-1 mb-1">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="periodo_comision">Concepto</label>
                                            <div class="custom-file">
                                                <input type="text" class="form-control" id="concepto" name="concepto" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="folio_serie">Folio/Serie</label>
                                            <div class="custom-file">
                                                <input type="text" class="@error('folio_serie') is-invalid @enderror typeahead form-control" id="folio_serie" name="folio_serie" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="subtotal">Subtotal</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="text" class="form-control" id="subtotal" name="subtotal" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="impuesto_trasladados">Impuestos Trasladados</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="text" class="form-control " id="impuesto_trasladados" name="impuesto_trasladados" autocomplete="off" >
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="total">Total</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="text" class="form-control " id="total" name="total"  readonly >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-1 mb-3">
                                        </div>
                                        <div class="col-md-10 mb-3 center">
                                            <div class="btn-container">
                                                <!--the three icons: default, ok file (img), error file (not an img)-->
                                                <h1 class="imgupload"><i class="fas fa-file-pdf"></i></h1>
                                                <h1 class="imgupload ok"><i class="fas fa-check"></i></h1>
                                                <h1 class="imgupload stop"><i class="fas fa-times"></i></h1>
                                                <!--this field changes dinamically displaying the filename we are trying to upload-->
                                                <p id="namefile">Sólo Archivos pdf's (pdf)</p>
                                                <!--our custom btn which which stays under the actual one-->
                                                <button type="button" id="btnup" class="btn btn-primary btn-lg">Busca el documento</button>
                                                <!--this is the actual file input, is set with opacity=0 beacause we wanna see our custom one-->
                                                <input type="file" value="" name="fileup" id="fileup">
                                            </div>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-success" id="submitFrm">
                                                <i class="fas fa-save"></i> Guardar Factura
                                            </button>
                                        </div>
                                    </div>
                {{-- Agregar Formulario END --}}
                    </form>
{{-- FORM END --}}
                </div>
            </div>
        </div>
        <div class="col-lg-1 mb-4"></div>
    </div>
    <hr>
</div>
{{-- tabla END --}}
@endsection

@section('contenidoJavaScript')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
        $(document).ready(function(){
            $('#frmFacturastore').on('submit', (event) => {
                event.preventDefault();
                const count_error = 0;
                if (count_error == 0)
                {
                    const fd = new FormData($('#frmFacturastore')[0]);
                    // fd.append('file', $( '#fileup' )[0].files[0])
                    // si el contador de errores es 0 se procede a realizar la petición en ajax
                    $.ajax({
                        url: "{{ route('factura.save') }}",
                        method: "POST",
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        data: fd,
                        beforeSend: function()
                        {
                            $('#submitFrm').attr('disabled', 'disabled');
                            $('.process').css('display', 'block');
                        },
                        success: function(data)
                        {
                            // manejando porcentaje
                            let percentage = 0;
                            const timer = setInterval(() => {
                                percentage = percentage + 20;
                                progress_bar_process(percentage, timer, data)
                            }, 1000);
                        },
                        error: function(xhr, textStatus, error)
                        {
                            // manejar errores
                            console.log(xhr.statusText);
                            console.log(xhr.responseText);
                            console.log(xhr.status);
                            console.log(textStatus);
                            console.log(error);
                        }
                    })
                } else {
                    return false;
                }
            });

            const progress_bar_process = (percentage, timer, data) => {
                $(".progress-bar").css('width', percentage + '%');
                if (percentage > 100) {
                    clearInterval(timer); // funcion que resetea el intervalo de tiempos
                    $('#frmFacturastore')[0].reset(); // resetear el formulario
                    $('.process').css('display', 'none'); // mostramos en pantalla el div
                    $('.progress-bar').css('width', '0%'); // seteamos el valor del progress bar
                    $('#submitFrm').attr('disabled', false);
                    $('#success_message').html("<div class='alert alert-success'>"+ data.message +"</div>");
                    setTimeout(() => {
                        $('#success_message').html('')
                        window.location.href = "{{ route('factura.index')}}";
                    }, 800);
                }
            }

            const roundToTwo = (num) => {
                return +(Math.round(num + "e+2")  + "e-2");
            }

            const round = (num, decimales = 2) => {
                const signo = (num >= 0 ? 1 : -1);
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

            $(document).on('input', '#subtotal', function(){
                if (this.value != this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.')) {
                    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
                }
            });

            $(document).on('input', '#impuesto_trasladados', function(){
                if (this.value != this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.')) {
                    this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
                }
            });

            // function cargar los datos
            $(document).on('keyup', '#subtotal', '#impuesto_trasladados', () => {
                const subtotal = $(this).find("input[id='subtotal']").val();
                const impuesto = $(this).find("input[id='impuesto_trasladados']").val();
                // checamos si están vacios
                if (subtotal == null || impuesto == null) {
                    return false;
                } else {
                    // empezamos a realizar el calculo
                    const total = document.getElementById("total");
                    if (total.value == 'NaN') {
                        total.value = 0;
                    }
                    const valor = parseFloat(subtotal) + parseFloat(impuesto);
                    total.value = roundToTwo(valor);
                }
            });

            /**
             * evento de cambio en un input
            */
           $('#fileup').change(() => {
                // tomamos la extensión del archivo y seteamos un arreglo de extensiones validas
                const res = $('#fileup').val();
                const arr = res.split("\\");
                const filename = arr.slice(-1)[0];
                const filextension = filename.split(".");
                let filext = "."+filextension.slice(-1)[0];
                const valid = [".pdf"];

                // si el archivo no está validado mandamos un error y escondamos el botton submit
                if (valid.indexOf(filext.toLowerCase()) == -1) {
                    $( ".imgupload" ).hide("slow");
                    $( ".imgupload.ok" ).hide("slow");
                    $( ".imgupload.stop" ).show("slow");
                    $('#namefile').css({"color":"red","font-weight":700});
                    $('#namefile').html("El archivo "+filename+" no es un pdf!");
                    // deshabilitar el submit
                    $( "#submitFrm" ).prop( "disabled", true );
                } else {
                    // si el archivo es valido mostramos un alerta verde y cargamos el submit a valido
                    $( ".imgupload" ).hide("slow");
                    $( ".imgupload.stop" ).hide("slow");
                    $( ".imgupload.ok" ).show("slow");
                    $('#namefile').css({"color":"green","font-weight":700});
                    $('#namefile').html(filename);
                    //habilitar
                    $( "#submitFrm" ).prop( "disabled", false );
                }
            })
        });
    </script>
@endsection
{{--  --}}
