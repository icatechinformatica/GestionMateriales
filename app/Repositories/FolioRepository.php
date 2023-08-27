<?php
namespace App\Repositories;

use App\Http\Traits\ConvertStringTrait;
use App\Interfaces\FolioRepositoryInterface;
use App\Models\catalogos\Denominaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\factura_folio\Factura;
use App\Models\factura_folio\Folio;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\factura_folio\FacturaDetalle;
use App\Models\solicitud\BitacoraTemporal;
use App\Models\solicitud\CatalogoVehiculo;
use App\Models\solicitud\Temporal;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FolioRepository implements FolioRepositoryInterface {

    use ConvertStringTrait; // convierte un string en STRING, respetando idioma

    public function addFolioFactura(Request $folioRequest): bool {

        // $facturaDetalle = FacturaDetalle::where('id', $folioRequest->get('denominacion'))->first();
        $idFactura = base64_decode($folioRequest->get('idFactura'));
        // obtener año actual
        $anioActual = Carbon::now()->format('Y');
        $folioDe = strtoupper($folioRequest->get('folio_de'));
        $folioHasta = strtoupper($folioRequest->get('folio_hasta'));
        $arrayFolios = [];
        // convertir string a numerico
        $folioDe = (int) $folioDe;
        $folioHasta = (int) $folioHasta;

        // checar si los dos son numericos
        if (is_numeric($folioDe) && is_numeric($folioHasta)) {
            // validas la longitus
            $longFolioDe = strlen($folioDe);
            $longFolioHasta = strlen($folioHasta);
            // comparamos si las longitudes son identicas
            if ($longFolioHasta === $longFolioDe) {
                # son identicas
                #resta
                $resta = $folioHasta - $folioDe;
                # entramos en el bucle
                $contador = 0;

                while ($contador <= $resta) {
                    # el contador aumenta
                    // agregamos la variable en el arreglo
                    $sumFolio = $folioDe + $contador;
                    array_push($arrayFolios, $sumFolio);
                    $contador += 1;
                }

                /***
                 * obtenemos el arreglo y empezamos a iterar con el folio
                 * checamos si es el conteo del arreglo tiene los mismos elementos que lo que dice el detalle de la cantidad
                 */
                foreach ($arrayFolios as $value) {
                    # un bucle foreach para recorrer el arreglo y volcarlo
                    $folio = Folio::create([
                        'numero_folio' => $value,
                        'anio' => $anioActual,
                        'factura_id' => $idFactura,
                        'denominacion' => $folioRequest->get('denominacion'),
                        'status' => 'DISPONIBLE',
                    ]);
                }
                // termina el ciclo
                return true;

                // if ($facturaDetalle->cantidad === count($arrayFolios)) {
                //     # checamos si la cantidad y el valor es mejor

                //     return true;
                // } else {
                //     return false;
                // }

            } else{
                return false;
            }
        }

        // // cargar registros
        // $factura->folios()->attach([ $folioId => ['denominacion' => $folioRequest->get('denominacion')] ]);

    }

    public function getFolio($request, $id) {
        $idfactura = base64_decode($id);
        $factu = Factura::findOrFail($idfactura);
       return $factu->setRelation('folios', $factu->folios()->paginate(
        $perPage = 15, $columns = ['*'], $pageName = 'folios'
       ));
       if ($request->ajax()) {
        # cargar los registros
            $idfactura = base64_decode($id);
            $factu = Factura::findOrFail($idfactura);

            return $factu->setRelation('folios', $factu->folios()
                                                    ->when($request->search_term, function($q) use ($request){
                                                            $q->where('numero_folio', 'like', '%'.$request->seach_term.'%');
                                                    })
                                                    ->paginate(15)

            );
       }
    }

    public function searchFolio(Request $request): array {
        $data = CatalogoVehiculo::select("catalogo_vehiculo.placas", "resguardante.resguardante_unidad")
        ->join('resguardante', 'resguardante.id', '=', 'catalogo_vehiculo.resguardante_id')
        ->where("catalogo_vehiculo.placas","LIKE","%{$request->term}%")
        ->orWhere("resguardante.resguardante_unidad","LIKE","%{$request->term}%")
        ->get();

        $vehiculoResguargante = [];
        foreach ($data as $hsl)
        {
            $vehiculoResguargante[] = $hsl->placas."----".$hsl->resguardante_unidad;
        }

        return $vehiculoResguargante;

        // $data = CatalogoVehiculo::search($request->term, ['catalogo_vehiculo.placas', 'resguardante.resguardante_unidad'])->get();
    }

    public function loadData(Request $request){

        $req = explode('----', $request->type, 2);
        // retornamos la consulta
        return  CatalogoVehiculo::with(["resguardante"])->where('placas', $req[0])->first();
    }

    public function getFoliosByStatus(){
        return Folio::select("denominacion", DB::raw("GROUP_CONCAT(DISTINCT numero_folio ORDER BY numero_folio ASC  limit 1) AS folios"))->where('status', '=' ,'DISPONIBLE')->groupBy('denominacion')->get();
    }

    public function getDenominacionByFactura(){
        return Folio::where('status', '=' ,'DISPONIBLE')->groupBy('denominacion')->pluck('denominacion', 'denominacion')->toArray();
    }

    public function cargarFolios(Request $request){
        $denominacion = $request->get('denominacion');
        $cantidad = $request->get('cantidad');
        $factura = $request->get('factura');
        $reasignar = $request->get('reasignar');

        $estado = ($reasignar == 'true') ? "REASIGNAR": "DISPONIBLE";  # si la variable es verdadera o falsa operador ternario
        // consulta de folios disponibles por denominación y buscados por factura
        return Folio::select('id', 'numero_folio')->where([['denominacion', $denominacion], ['factura_id', $factura], ['status', $estado]])->orderBy('id', 'asc')->limit($cantidad)->get();
    }

    public function asignarFoliosVehiculo(Request $res): bool{
        try {
        /**
         * realizar carga de registros
         * convertir la entidad HTML en un arreglo
         */
            $estado = ($res['reasignarInput'] === 1) ? "REASIGNAR" : "ASIGNADO";
            $arrayData =  html_entity_decode($res['foliosArray']); // Convierte todas las entidades HTML a sus caracteres correspondientes
            $getArrayFolios = json_decode($arrayData, true);

            $idVehiculo = $res['vehiculo_id']; // obtenemos el valor del id del vehículo

        // obtener el vehiculo referido con el idVehiculo
        $catVehicle = CatalogoVehiculo::where('id', $idVehiculo)->first();

        // get Factura data
        $getFactura = Factura::where('id', $res->get('factura'))->first();

        /**
         * crear temporal para vincular las cargas
         */
        Temporal::create([
            'catalogo_vehiculo_id' => $idVehiculo,
            'fecha' => Carbon::now(),
            'km_inicial' => $catVehicle->km_final,
            'numero_factura_compra' => $this->toUpper($getFactura->serie),
            'nombre_elabora' => Auth::user()->name,
            'anio_actual' => Carbon::now()->year,
            'puesto_elabora' => Auth::user()->puesto,
            'users_id' => Auth::user()->id,
            'status_proceso' => true,
        ]);
         /**
         * REALIZAMOS LA CARGA CORRESPONDIENTE - OBTENEMOS EL VEHÍCULO ASIGNADO
         */
            $vehiculoSeleccionado = CatalogoVehiculo::FindOrFail($idVehiculo);

            foreach ($getArrayFolios as $key => $value) {
                # bucle para cargar los registros en la tabla pivote
                $vehiculoSeleccionado->folio()->attach([ $value['id'] => ['status' =>  $estado, 'created_at' => Carbon::now()] ]);
                #actualizar tabla folios
                Folio::where('id', $value['id'])
                    ->update(['status' => $estado]);
            }

            return true; // retornamos verdadero si se cumplen estas condiciones
        } catch (QueryException $th) {
            //excepcion sql;
            return $th->getMessage();
        }
    }

    public function folioAsignadoIndex(){
        return CatalogoVehiculo::whereHas('folio', function($query) {
            $query->where('folio.status', 'ASIGNADO')
                ->orWhere('folio.status', 'BITACORA');
        })->get();
    }

    public function getDetails($id): object {
        $getId = base64_decode($id);
        return CatalogoVehiculo::with('resguardante', 'folio')->findOrFail($getId);
    }

    /**
     *
     */
    public function getReasignar($id): bool {
        // utilizaremos queryBuilder statements no es lo mejor pero se tiene que hacer
        return Folio::where([['factura_id', $id], ['status', 'REASIGNAR']])->exists();
    }
    /**
     * obtener folios de gasolina por el vehiculo
     */
    public function getFolioByCatVehicle($id): object {
        //checamos si la variables el verdadera o falsa
        $Query = DB::table('vehiculo_folio AS VEHICULOS_FOLIOS')->select(
            'FOLIOS.id',
            'FOLIOS.numero_folio',
            'FOLIOS.utilizado',
            'FOLIOS.denominacion'
        )->leftJoin('folio AS FOLIOS', 'FOLIOS.id', '=', 'VEHICULOS_FOLIOS.folio_id')
         ->leftJoin('catalogo_vehiculo AS CATALOGOS_VEHICULOS', 'CATALOGOS_VEHICULOS.id', '=', 'VEHICULOS_FOLIOS.catalogo_vehiculo_id')
         ->where('CATALOGOS_VEHICULOS.id', $id)
         ->whereIn('VEHICULOS_FOLIOS.status', ['ASIGNADO', 'COMISION', 'BITACORA'])
         ->get();

         // CatalogoVehiculo::findOrFail($id)->folio()->where('vehiculo_folio.status', '=', 'ASIGNADO')->orWhere('vehiculo_folio.status', '=', 'COMISION')->orWhere('vehiculo_folio.status', '=', 'BITACORA')->get();
        // tenemos el id del vehículo y retornamos un objeto de
        return $Query;
    }

    /**
     * obtener sólo los folios que están seleccionados en BITACORA si hay y que están utilizados
     *
     */
    public function getSumByFoliosUsed($id): object {
        $operador = ''; // declaración de variable
        $foliosVehiculoUsados = CatalogoVehiculo::findOrFail($id)->folio()->where([['vehiculo_folio.status', '=', 'BITACORA'], ['folio.utilizado', '=', 1]])->get();
        /**
         * realizamos un bucle sobre folios vehiculos
         */
        foreach ($foliosVehiculoUsados as $folios) {
            # realizamos la operación dentro del bucle
            $operador .= $folios->numero_folio.",";
        }
        $operador = rtrim ($operador, ","); // quitar la coma y espacio final
        // obtenemos el valor primero del temporal
        $temporal = Temporal::where('catalogo_vehiculo_id', $id)->first();
        #
        // crear un arreglo
        $condicional = [
            ['vales', '=', $operador],
            ['solicitud_id', '=', $temporal->id],
            ['confirmado', '=', 1],
        ];
        // consulta de la bitácora si encuentra infor realicionada

        return BitacoraTemporal::selectRaw('SUM(importe) AS imp , SUM(DISTINCT importevales) AS imp_vale, SUM(DISTINCT importevales) - SUM(importe) AS restant')->where($condicional)->get();

    }
}
