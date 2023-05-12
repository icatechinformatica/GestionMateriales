/**
 * REALIZADO POR MIS. DANIEL MÉNDEZ CRUZ 12/05/2023
 * VALIDACIÓN DE FORMULARIOS
 */
$(function(){
    $('#precomisionstore').validate({
        rules: {
            placas_comision: {
                required: true
            },
            costo_combustible: {
                required: true
            },
            km_total: {
                required: true
            },
        },
        messages: {
            placas_comision: {
                required: "Las placas del Vehículo son requeridas"
            },
            costo_combustible: {
                required: "El costo del combustible es requerido",
            },
            km_total: {
                required: "Kilometraje total es requerido"
            },
        }
    });
});
