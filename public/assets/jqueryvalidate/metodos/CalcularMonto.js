import MontoTotal from './MontoTotal.js';

$.ajaxSetup({
    headers: {
        'X-CSSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});



/**
 * Elemento select - change
 */
const selectElement = document.querySelector('#rendimiento_vehiculo');
selectElement.addEventListener('change', (e) => {
    const result = document.querySelector('#rendimiento_valor');
    getRendimiento(e.target.value);
});


/**
 *
 */

const kmTotal = document.querySelector('#km_total');
const rendimientoValor = document.querySelector('#rendimiento_valor');
const costoCombustible = document.querySelector('#costo_combustible');
const montoTotal = document.querySelector('#monto_total_rendimiento');

kmTotal.addEventListener("keyup", (event) => {
    montoTotal.value = ""; // se limpia el input
    if (event.target.value === null || event.target.value === "" || kmTotal.value === null || kmTotal.value === "") {
        return 0;
    }
    let calculoMontoTotal = MontoTotal({rendimiento: rendimientoValor.value, costo: costoCombustible.value, km_total: event.target.value });
    montoTotal.value = calculoMontoTotal;
});

costoCombustible.addEventListener("keyup", (evt) => {
    montoTotal.value = ""; // se limpia el input
    //checamos si el valor es vacio o nullo
    if (kmTotal.value === null || kmTotal.value === "" || evt.target.value === null || evt.target.value === '') {
        return 0;
    }
    let calculoMontoTotal = MontoTotal({rendimiento: rendimientoValor.value, costo: evt.target.value, km_total: kmTotal.value });
    montoTotal.value = calculoMontoTotal;
});

/***
 * funcion async - away
 */


export const getRendimiento = async(param) => {
    try {
        let route ="/solicitud/pre/comision/getrendimiento";

        return await $.get(route,{parametro: param}, function(data){
            alert(`Data: ${data}`);
        });

    } catch (error) {
        // manejo de error
        console.warn(error);
    }
}
