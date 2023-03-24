/**
 * importar el archivo de la clase calculo
 */
 import VehiculoClass from "./VehiculoClass.js";

const btngetCalcular = document.getElementById('getCalculation');
btngetCalcular.addEventListener('click', () => {
    /**
     * variables
     */
    const ltsComision = $('.lts_comision');
    const precioUnitarioClass = $('.unitario_precio');
    const importeClass = $('.importe_unitario');
    let ltsTotales = 0, unitario_precio = 0, varimporte = 0;
    let lts_total = document.getElementById('litros_totales');
    let totalImp = document.getElementById('importe_total');
    let kilometrajeini = document.getElementById('kmInicial').value;
    let kilometrajefin = document.getElementById('kmFinal').value;
    let km_totales = document.getElementById('km_totales');
    let rendimiento_final = document.getElementById('rendimiento_final');
    let monto_total_rendimiento = document.getElementById('monto_total_rendimiento');

    let costo_combustible = document.getElementById('costo_combustible');

    ltsComision.each(function(i, e){
        if (typeof(e.value) !== "undefined") {
            if (e.value !== null && e.value !== 'NaN') {
                if (e.value > 0) {
                    ltsTotales += parseFloat(e.value);
                }
            }                    
        } 
    });
    if (lts_total.value == 'NaN') {
        lts_total.value = 0;
    }

    lts_total.value = ltsTotales.toFixed(2);

    /**
     * calcular importe total
     */
    importeClass.each(function(ind, ele){
        if (typeof(ele.value) !== 'undefined') {
            if (ele.value !== null && ele.value !== 'NaN') {
                if (ele.value > 0) {
                    varimporte += parseFloat(ele.value, 2);
                }
            }
        }
    });

    if (totalImp.value == 'NaN') {
        totalImp.value = 0;
    }
    totalImp.value = varimporte.toFixed(2);

    /**
     * calcular el rendimiento
     */
     var vcl = new VehiculoClass(costo_combustible.value, km_totales.value, rendimiento_final.value);
     vcl.rendimiento = rendimiento_final.value;
     vcl.kilometrototal = km_totales.value;
     vcl.costocombustible = costo_combustible.value;
     monto_total_rendimiento.value = vcl.montototal();

});