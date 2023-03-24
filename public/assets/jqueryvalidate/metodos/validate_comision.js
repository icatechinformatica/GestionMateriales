// inicializando el DOM con el método de validación de la comision
 /**
  * REALIZADO POR MIS. DANIEL MÉNDEZ CRUZ - 04-MARZO-2022
  */
$(function() {
    $('#form_bitacora_comision').validate({
        rules: {
            memo_comision: {
                required: true
            },
            periodo_comision: {
                required: true
            },
            placas_comision: {
                required: true
            },
            kmInicial: {
                required: true
            },
            kmFinal: {
                required: true
            }
        },
        messages: {
            memo_comision: {
                required: "El Memorándum de comisión es requerido"
            },
            periodo_comision: {
                required: "Este campo es requerido",
            },
            placas_comision: {
                required: "Placas del vehículo requerida"
            },
            kmInicial: {
                required: "Kilómetro inicial requerido"
            },
            kmFinal: {
                required: "Kilómetro final requerido"
            }
        }
    });
});