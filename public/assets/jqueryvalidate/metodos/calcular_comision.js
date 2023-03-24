import VehiculoClass from "./VehiculoClass.js";
/**
 * declaracion de las variables globales y constantes
 */
/**@argument
 * agregar un addEvenetListener
*/

 let calculaComision = () => {
    const ltsComision = $('.lts_comision');
    const precioUnitarioClass = $('.unitario_precio');
    const importeClass = $('.importe_unitario');
    let ltsTotales = 0, unitario_precio = 0, varimporte = 0;
    let lts_total = document.getElementById('litros_totales');
    let preciouTotal = document.getElementById('precio_unitario_total');
    let totalImp = document.getElementById('importe_total');
    let kilometrajeini = document.getElementById('kmInicial').value;
    let kilometrajefin = document.getElementById('kmFinal').value;
    let km_totales = document.getElementById('km_totales');
    let rendimiento_final = document.getElementById('rendimiento_final');
    let monto_total_rendimiento = document.getElementById('monto_total_rendimiento');
    // nuevas variables
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
     * calcular precio Unitario
     */
     precioUnitarioClass.each(function(index, element){
         if (typeof(element.value) !== 'undefined') {
             if (element.value !== null && element.value !== 'NaN') {
                 if (element.value > 0) {
                     unitario_precio += parseFloat(element.value, 2);
                 }
             }
         }
     });
     if (preciouTotal.value == 'NaN') {
        preciouTotal.value = 0;
     }
     preciouTotal.value = unitario_precio.toFixed(2);

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
     * calcular dif de cambios de kilometrajes
     */
    var calculo = new CalcularKilometraje(kilometrajeini, kilometrajefin);
    km_totales.value = calculo.diffkilometraje();

    var vcl = new VehiculoClass(costo_combustible.value, km_totales.value, rendimiento_final.value);
    monto_total_rendimiento.value = vcl.montototal;
    vcl.rendimiento = rendimiento_final.value;
    console.log(vcl.montototal);
}

/**
 * creamos una clase que tendrá ambitos
 */
class CalcularKilometraje {
    constructor(kmini, kmfin)
    {
        // VehiculoClass.prototype.datos();
        this._kmini = kmini;
        this._kmfin = kmfin;
    }

    diffkilometraje()
    {
        let resultado = 0;
        if (this._kmfin > 0 && this._kmini > 0) {
            if (this._kmfin > this._kmini) {
                resultado = Math.abs(this._kmfin - this._kmini);
                return resultado; 
            } else {
                return 0;
            }
            
        } else {
            return 0;
        }
    }
}

const btnCalcularComision = document.getElementById('calcularComision');
btnCalcularComision.addEventListener('click', calculaComision);