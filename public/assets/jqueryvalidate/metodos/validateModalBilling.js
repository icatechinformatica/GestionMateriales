/**
 * REALIZADO POR MIS. DANIEL MÉNDEZ CRUZ 06/06/2023
 * VALIDACIÓN DE FORMULARIOS
 */
 $(function(){
    const form = $('#FormBilling');
    // const arrayData = [];
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
            let contador = 0;
            const invoice = {
                claveProducto:$('#clave_producto').val(),
                cantidad:$('#cantidad').val(),
                claveUnidad:$('#clave_unidad').val(),
                valorUnitario:$("#valor_unitario").val(),
                impuestos: $("#impuestos").val(),
                importe:$("#importe").val(),
                descripcion:$("#descripcion").val()
            };

            if (invoice != null) {
                // es diferente a null
                itemsData.push(invoice);
            }
            $('#noData').hide();
            // creamos un arreglo y enviamos
            if (contador < max_fields) {
                // limpiamos contenido de la tabla
                $("#invoiceDetails").html("");
                // al arreglo le aplicamos una destructuración para acceder a los elementos del objeto de forma más sencilla sin tocar el arreglo original
                itemsData.map(({claveProducto, cantidad, claveUnidad, valorUnitario, impuestos, importe}, index) => {
                    $("#invoiceDetails").append(
                        `<tr id=${index}>`+
                            '<td>' +
                                `${claveProducto.toUpperCase()}` +
                            '</td>' +
                            '<td>' +
                                `${cantidad.toUpperCase()}` +
                            '</td>' +
                            '<td>' +
                                `${claveUnidad.toUpperCase()}` +
                            '</td>' +
                            '<td>' +
                                `${descripcion.value.toUpperCase()}` +
                            '</td>' +
                            '<td>' +
                                `${valorUnitario.toUpperCase()}` +
                            '</td>' +
                            '<td data-label="...">'+
                                `${impuestos.toUpperCase()}`+
                            '</td>'+
                            '<td data-label="...">'+
                                `${importe.toUpperCase()}`+
                            '</td>'+
                        '<tr>'
                    );
                });
                // cerrar modal
                $('#modalBillingTheme').modal('hide'); // cerrar el modal
                // agregamos el valor del arreglo nuevo con el input que tenemos
                // si el input tiene datos vorramos el valor
                $('#arregloDetalle').val(''); // borramos el valor
                contador++; // acrecentamos el contador
                // resetear formulario del modal
                $('#FormBilling')[0].reset();

                // arrayData.forEach(function(element, index){
                //     console.log(element.claveProducto);
                // });
            }
        }
    });
});
