/**
 * validación de pre-comisión realizado por MIS.DANIEL MÉNDEZ CRUZ - 18 de abril 2022
 */
$(function() {
    $('#form_bitacora_recorrido').validate({
        rules: {
            periodo: {
                required: true
            },
            placas: {
                required: true
            },
            _kilometroInicial: {
                required: true
            },
            nombreConductor: {
                required: true
            },
            no_factura_compra: {
                required: true
            },
            fecha: {
                required: true
            }
        },
        messages: {
            periodo: {
                required: "El periodo es requerido"
            },
            placas: {
                required: "Placa del vehículo requerido"
            },
            _kilometroInicial: {
                required: "Kilómetro inicial requerido"
            },
            nombreConductor: {
                required: "Nombre del conductor requerido"
            },
            no_factura_compra: {
                required: "Factura de compra requerida"
            },
            fecha: {
                required: "la Fecha es requerida"
            }
        }
    });

    /**
     * una validación de bitacora de recorrido pre-guardado
     */
    $('#form_bitacora_pre_save').validate({
        rules: {
            fecha: { required: true },
            periodo: { required: true },
            no_factura_compra: { required: true},
            _kilometroInicial: { required: true },
            nombreConductor: { required: true },
            placas: { required: true }
        },
        messages: {
            fecha: { required: "la Fecha es requerida" },
            periodo: { required: "El periodo es requerido" },
            no_factura_compra: { required: "Factura de compra requerida" },
            _kilometroInicial: { required: "Kilómetro inicial requerido" },
            nombreConductor: { required: "Nombre del conductor requerido" },
            placas: { required: "Placa del vehículo requerido" }
        }
    });
});