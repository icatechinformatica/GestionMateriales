class VehiculoClass {
    constructor(costoCombustible, kmTotal, rendimiento){
        this.costocombustible = costoCombustible;
        this.kmTotal = kmTotal;
        this.rendimiento = rendimiento;
    }

    set rendimiento(value){
        this._rendimiento = value;
    }

    get rendimiento(){
        return this._rendimiento;
    }

    set costocombustible(costo){
        this._costo = costo;
    }

    get costocombustible(){
        return this._costo;
    }

    set kilometrototal(kilometro){
        this._kilometro = kilometro;
    }

    get kilometrototal(){
        return this._kilometro;
    }


    montototal(){
        if (this._rendimiento === '' || this._costo === '' || this._kilometro === '') {
            return 0;
        }
        return Math.round(Number((Math.abs((this._kilometro / this._rendimiento ) * this._costo) * 100).toPrecision(15))) / 100 * Math.sign((this._kilometro / this._rendimiento ) * this._costo);
    }
}

export default VehiculoClass