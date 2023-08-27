/**
 * REALIZADO POR MIS. DANIEL MÉNDEZ CRUZ 06/06/2023
 * VALIDACIÓN DE FORMULARIOS
 */
 $(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const form = $('#FormBilling');
    let contador = 0;
    let sumaSubtotal = 0;
    let sumaImporte = 0;
    let sumaFacturaTotal = 0;
    let idFactura = '';
    form.validate({
        errorClass: "error",
        rules: {
            clave_producto: {
                required: true
            },
            cantidad: {
                required: true
            },
            clave_unidad: {
                required: true
            },
            valor_unitario: {
                required: true
            },
            impuestos: {
                required: true
            },
            importe: {
                required: true
            }
        },
        messages: {
            clave_producto: {
                required: "La clave del producto es requerida"
            },
            cantidad: {
                required: "La cantidad es requerida",
            },
            clave_unidad: {
                required: "La clave unidad es requerida",
            },
            valor_unitario: {
                required: "El valor unitario es requerido"
            },
            impuestos: {
                required: "Los impuestos son requeridos"
            },
            importe: {
                required: "El importe es requerido"
            }
        },
        highlight: function(element, errorClass) {
            $(element).addClass(errorClass);
        },
        submitHandler: function(form, event){
            event.preventDefault();
            let max_fields = 1000; //maximo elementos permitidos

            // creamos un arreglo y enviamos
            if (contador < max_fields) {
                // función ajax para envíar registro a guardar
                idFactura = $('#idFormDetalleFactura').val();
                const frmdata = new FormData($('#FormBilling')[0]);
                frmdata.append('subtotal', JSON.stringify(subtotal));
                frmdata.append('impuestoTrasladado', JSON.stringify(impuestoTrasladado));
                frmdata.append('totalFactura', JSON.stringify(totalFactura));
                $.ajax({
                    method: "POST",
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: frmdata,
                    url: '/factura/details/add',
                    success: function(data){
                        $('#modalBillingTheme').modal('hide'); // cerrar el modal
                        // resetear formulario del modal
                        $('#FormBilling')[0].reset();
                        //redireccionar
                        window.location.href = `/factura/edit/${idFactura}`;
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
                });

                // agregamos el valor del arreglo nuevo con el input que tenemos
                contador++; // acrecentamos el contador
            }
        }
    });
});
