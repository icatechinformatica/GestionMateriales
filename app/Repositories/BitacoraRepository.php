<?php

namespace App\Repositories;

use App\Interfaces\BitacoraRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\solicitud\CatalogoVehiculo;
use Illuminate\Database\QueryException;
use App\Models\solicitud\Temporal;
use Illuminate\Support\Facades\Auth;
use App\Models\solicitud\BitacoraTemporal;
use App\Models\factura_folio\Folio;
use App\Http\Traits\ConvertStringTrait;
use App\Models\factura_folio\Factura;

class BitacoraRepository implements BitacoraRepositoryInterface
{
    use ConvertStringTrait; // convierte un string en STRING, respetando idioma

    public function getBitacora(): object
    {
        try {
            //realizar el procedimiento
            return CatalogoVehiculo::whereHas('folio', function ($query) {
                $query->where('folio.status', 'ASIGNADO')
                    ->orWhere('folio.status', 'BITACORA');
            })->get();
        } catch (QueryException $th) {
            //excepción SQL
            return $th->getMessage();
        }
    }

    public function getBitacoraDetails($id): object
    {
        try {
            //ejecutamos la consulta
            return CatalogoVehiculo::join('vehiculo_folio', 'vehiculo_folio.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
                ->join('folio', 'folio.id', '=', 'vehiculo_folio.folio_id')
                ->join('factura', 'factura.id', '=', 'folio.factura_id')
                ->join('resguardante', 'resguardante.id', '=', 'catalogo_vehiculo.resguardante_id')
                ->where([['catalogo_vehiculo.id', $id]])
                ->groupBy('catalogo_vehiculo.id', 'catalogo_vehiculo.color', 'factura.serie', 'catalogo_vehiculo.numero_motor', 'catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo', 'catalogo_vehiculo.tipo', 'catalogo_vehiculo.placas', 'catalogo_vehiculo.numero_serie', 'catalogo_vehiculo.linea', 'catalogo_vehiculo.km_inicial', 'catalogo_vehiculo.km_final', 'catalogo_vehiculo.numero_economico', 'resguardante.resguardante_unidad', 'resguardante.puesto_resguardante_unidad', 'catalogo_vehiculo.rendimiento_ciudad', 'catalogo_vehiculo.rendimiento_carretera', 'catalogo_vehiculo.rendimiento_mixto', 'catalogo_vehiculo.rendimiento_carga')
                ->first(['catalogo_vehiculo.id', 'catalogo_vehiculo.color', 'factura.serie  AS facturaserie', 'catalogo_vehiculo.numero_motor', 'catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo', 'catalogo_vehiculo.tipo', 'catalogo_vehiculo.placas', 'catalogo_vehiculo.numero_serie', 'catalogo_vehiculo.linea', 'catalogo_vehiculo.km_inicial', 'catalogo_vehiculo.km_final', 'catalogo_vehiculo.numero_economico', 'resguardante.resguardante_unidad', 'resguardante.puesto_resguardante_unidad', 'catalogo_vehiculo.rendimiento_ciudad', 'catalogo_vehiculo.rendimiento_carretera', 'catalogo_vehiculo.rendimiento_mixto', 'catalogo_vehiculo.rendimiento_carga']);
        } catch (QueryException $e) {
            //excepción SQL
            return $e->getMessage();
        }
    }

    public function getBitacoraTemp($id): object
    {
        try {
            //consulta
            $temporal = Temporal::where('catalogo_vehiculo_id', $id)->first();
            $idTemp = ($temporal) ? $temporal->id : 0;
            return BitacoraTemporal::where('solicitud_id', $idTemp)->get();
        } catch (QueryException $e) {
            //excepción SQL
            return $e->getMessage();
        }
    }

    public function storeRouteLog(Request $request)
    {
        try {
            #checamos si tengo el valor del switch o checkbox
            $check_comision = isset($_POST['chkcomision']) ? 1 : 0;
            # casteamos los tiepos de datos en el importe y también en el importe folio sólo pueden cargarse se es menor o igual al importe folio
            $importe_folio = trim($request->get('importefolios')); // quitamos espacios
            $importe_folio = (float) $importe_folio; // se castea a tipo decimal
            $importe = trim($request->get('importe')); // quitamos espacios
            $importe = (float) $importe; // se castea al tipo decimal
            $kmRecorrido = trim($request->get('kmrecorrido'));
            $respuesta = []; // declaramos un arreglo

            if ($check_comision === 1) {
                # si la comisión es verdadera
                $strStatusFolio = 'COMISION';
                // trabajamos en guardar una comisión

                if ($importe > $importe_folio) {
                    # solo retorno falso
                    $respuesta['response'] = false;
                    $respuesta['message'] = 'EL IMPORTE NO PUEDE SER MAYOR AL IMPORTE DE LOS FOLIOS EN ESTE RECORRIDO DE LA COMISIÓN!';
                    return $respuesta;
                } else {
                    // si el importe es menor o igual al importe folio

                    $idVehicle = base64_decode($request->get('idCatVehiculo'));
                    // checamos que no haya un registro previo con el id
                    $chkTemp = Temporal::where([['catalogo_vehiculo_id', $idVehicle], ['status_proceso', true]])->first();

                    if (!$chkTemp) {
                        # si no hay registros anteriores podemos generar el proceso
                        $QryInserTemp = Temporal::create([
                            'catalogo_vehiculo_id' => $idVehicle,
                            'fecha' => $request->get('fechaEntrada'),
                            'km_inicial' => $request->get('kmInicial'),
                            'numero_factura_compra' => $this->toUpper($request->get('noFactura')),
                            'nombre_elabora' => Auth::user()->name,
                            'anio_actual' => Carbon::now()->year,
                            'puesto_elabora' => Auth::user()->puesto,
                            'users_id' => Auth::user()->id,
                        ]);

                        $lastId = $QryInserTemp->id;

                        // recorremos la variable folio_inicial_final que es un arreglo para obtener valores
                        static $suma = 0;
                        static $operador = '';
                        static $denominacionVale = '';

                        $countDv200 = 0;
                        $countdDv100 = 0;
                        $countDv50 = 0;

                        // checamos si las variables se encuentran vacias
                        if (empty($request->folio_inicial_final) && !empty($request->get('numero_factura'))) {

                            # si está vacio el folio inicial y final y si no está vacio el número de factura - no hay necesidad de recorrer $request->folio_inicial_final

                            // insertamos el primer registro que obtenemos
                            BitacoraTemporal::create([
                                'fecha' => $request->get('fechaEntrada'),
                                'kilometraje_inicial' => $request->get('kmInicial'),
                                'kilometraje_final' => $request->get('kmFinal'),
                                'litros' => $request->get('litros'),
                                'division_vale' => ($denominacionVale === '') ? null : $denominacionVale,
                                'importe' => $importe,
                                'actividad_inicial' => $this->toUpper($request->get('de')),
                                'actividad_final' => $this->toUpper($request->get('a')),
                                'vales' => $this->toUpper($request->get('numero_factura')),
                                'solicitud_id' => $lastId,
                                'importevales' => $request->get('importefolios'),
                                'numero_comision' => (!empty($request->get('numero_comision'))) ? $this->toUpper($request->get('numero_comision')) : null,
                                'comision' => $check_comision
                            ]);

                            // actualizamos el siguiente registro
                            Temporal::where('id', $lastId)->update([
                                'status_proceso' => 1,
                                'total_km_recorridos' => (int)$kmRecorrido,
                                'litros_totales' => $request->get('litros'),
                                'importe_total' => $request->get('importefolios'),
                                'es_comision' => 1, //si es comisión se agrega el campo y vamos a utilizarlo hasta que deje de servinos en las iteracciones de bitácoras
                            ]);

                            #actualizar el registro de catalogo del vehiculo con el km final
                            CatalogoVehiculo::where('id', $idVehicle)->update(['km_final' => $request->get('kmFinal')]);
                            #modificar catalogo de vehículos agregar kilometraje final

                            $respuesta['response'] = true;
                            $respuesta['message'] = 'AGREGADO ÉXITOSAMENTE';
                            return $respuesta;
                        } elseif (!empty($request->folio_inicial_final) && empty($request->get('numero_factura'))) {

                            # si no está vacio folio inicial y final y si está vacio el número de factura
                            foreach ($request->folio_inicial_final as $items) {
                                # recorremos el bucle que existe
                                # extraemos ambos valores
                                $arrayItems = explode("|", $items);
                                // actualizar registros
                                Folio::where('id', $arrayItems[0])->update([
                                    'status' => $strStatusFolio,
                                    'utilizado' => true,
                                ]);

                                $suma += (int)$arrayItems[1]; // suma de los las deonominaciones
                                $getFolios = Folio::where('id', $arrayItems[0])->first();

                                // realizar un bucle
                                switch ($arrayItems[1]) {
                                    case '100':
                                        # checamos que la denominacion de vale no se repita en toda la iteración, si es así sólo se agreaga una vez
                                        if ($countdDv100 === 0) {
                                            # checar si un string dv está vacio
                                            if (!empty($denominacionVale)) {
                                                # si no está vacio se procede a concatenar
                                                $denominacionVale .= ", " . $arrayItems[1];
                                            } else {
                                                $denominacionVale .= $arrayItems[1];
                                            }
                                            # actualizar el contador de la denominacion de vales a +1 en este caso es el valor 100
                                            $countdDv100 = $countdDv100 + 1;
                                        }
                                        break;
                                    case '200':
                                        # checamos la denominación de vale de 200 para no repetir toda la iteracion
                                        if ($countDv200 === 0) {
                                            # si son iguales se checa que el string dv este vacio
                                            if (!empty($denominacionVale)) {
                                                # si no se encuentra vacio procede a concatenar
                                                $denominacionVale .= ", " . $arrayItems[1];
                                            } else {
                                                # si está vacio se agrega directamente
                                                $denominacionVale .= $arrayItems[1];
                                            }
                                            # actualizar el contador de la denominacion de vales a +1 en este caso es el valor 200
                                            $countDv200 = $countDv200 + 1;
                                        }
                                        break;
                                    case '50':
                                        # checamos la denominación de vale de 50 para no repetir toda la iteracion
                                        if ($countDv50 === 0) {
                                            # si son iguales se checa que el string dv este vacio
                                            if (!empty($denominacionVale)) {
                                                # si no se encuentra vacio procede a concatenar
                                                $denominacionVale .= ", " . $arrayItems[1];
                                            } else {
                                                # si está vacio se agrega directamente
                                                $denominacionVale .= $arrayItems[1];
                                            }
                                            # actualizar el contador de la denominacion de vales a +1 en este caso es el valor 200
                                            $countDv50 = $countDv50 + 1;
                                        }
                                        break;
                                    default:
                                        # code...
                                        break;
                                }

                                // concatenar los números de folio
                                $operador .= $getFolios->numero_folio . ",";
                            }

                            $operador = rtrim($operador, ","); // quitar la coma y espacio final


                            // insertamos el primer registro que obtenemos
                            BitacoraTemporal::create([
                                'fecha' => $request->get('fechaEntrada'),
                                'kilometraje_inicial' => $request->get('kmInicial'),
                                'kilometraje_final' => $request->get('kmFinal'),
                                'litros' => $request->get('litros'),
                                'division_vale' => $denominacionVale,
                                'importe' => $importe,
                                'actividad_inicial' => $this->toUpper($request->get('de')),
                                'actividad_final' => $this->toUpper($request->get('a')),
                                'vales' => $operador,
                                'solicitud_id' => $lastId,
                                'importevales' => $suma,
                                'numero_comision' => (!empty($request->get('numero_comision'))) ? $this->toUpper($request->get('numero_comision')) : null,
                                'comision' => $check_comision
                            ]);

                            //se checa si el importe de la gasolina es igual o menor al importe de la gasolina
                            if ($importe == $importe_folio) {

                                # si son iguales quiere decir que no se tiene que realizar dicho recorrido y cambia su estado (en los folios porque ese recorrido será único)
                                foreach ($request->folio_inicial_final as $value) {
                                    # realizamos un recorrido en el bucle para poder actualizar
                                    # extraemos ambos valores
                                    $itemArr = explode("|", $value);
                                    $vehicle = CatalogoVehiculo::findOrFail($idVehicle); // obteniendo registro - vehículo
                                    $vehicle->folio()->updateExistingPivot($itemArr[0], ['transitado' => true, 'status' => 'TERMINADO']); // actualizando registro de una tabla pivote
                                }

                                // actualizamos el siguiente registro
                                Temporal::where('id', $lastId)->update([
                                    'status_proceso' => 1,
                                    'total_km_recorridos' => (int)$kmRecorrido,
                                    'litros_totales' => $request->get('litros'),
                                    'importe_total' => $suma,
                                    'es_comision' => 0, //si es comisión se agrega el campo y vamos a utilizarlo hasta que deje de servinos en las iteracciones de bitácoras
                                ]);
                            } elseif ($importe < $importe_folio) {
                                # si el importe es menor que el importe folio

                                foreach ($request->folio_inicial_final as $key) {
                                    # realizamos el proceso del bucle para actualizar los estados
                                    # extraemos ambos valores
                                    $array = explode("|", $key);
                                    $vhclo = CatalogoVehiculo::findOrFail($idVehicle); // obteniendo registro - vehículo
                                    $vhclo->folio()->updateExistingPivot($array[0], ['status' => $strStatusFolio, 'transitado' => true]); // actualizando registro de una tabla pivote
                                }

                                // obtener la información de los folios que están el BITACORA si hay
                                $foliosGet = Folio::where('status', 'BITACORA')->get();

                                if ($foliosGet->isNotEmpty()) {
                                    # no se encuentra vacio vamos a vaciarlo
                                    foreach ($foliosGet as $key => $value) {
                                        # code...
                                        $getvehicle = CatalogoVehiculo::findOrFail($idVehicle); // obteniendo registro - vehículo
                                        $getvehicle->folio()->updateExistingPivot($value->id, ['transitado' => false]);
                                    }
                                }

                                // se confirma la tabla bitacora_temporal
                                BitacoraTemporal::where('solicitud_id', $lastId)->update([
                                    'confirmado' => 1, // se cambiara a verdadero cuándo aún los importes no cuadren
                                ]);

                                // actualizamos el siguiente registro
                                Temporal::where('id', $lastId)->update([
                                    'status_proceso' => 1,
                                    'total_km_recorridos' => (int)$kmRecorrido,
                                    'litros_totales' => $request->get('litros'),
                                    'importe_total' => $suma,
                                    'es_comision' => 1, //si es comisión se agrega el campo y vamos a utilizarlo hasta que deje de servinos en las iteracciones de bitácoras
                                ]);
                            }

                            #actualizar el registro de catalogo del vehiculo con el km final
                            CatalogoVehiculo::where('id', $idVehicle)->update(['km_final' => $request->get('kmFinal')]);
                            #modificar catalogo de vehículos agregar kilometraje final

                            $respuesta['response'] = true;
                            $respuesta['message'] = 'AGREGADO ÉXITOSAMENTE';
                            return $respuesta;
                        }
                    } else {
                        // si no se encuentra un temporal - QUERY - ya hay registro y se tiene que actualizar el temporal y agregar los campos de bitácora temporal

                        // si el valor del vehículo existe en la tabla temporal -- idvehículo
                        $idTemporal = $chkTemp->id;

                        // value declaration
                        static $operator = '';
                        static $suma = 0;
                        static $operador = '';
                        static $denominacion = '';
                        $countdv100 = 0;
                        $countdv200 = 0;
                        $countdv50 = 0;

                        // checamos las variables vemos las condicionales
                        if (empty($request->folio_inicial_final) && !empty($request->get('numero_factura'))) {
                            # la condición es que los folios inciales y finales estén vacios y que el número de la factura no esté vacio

                            # si está vacio el folio inicial y final y si no está vacio el número de factura - no hay necesidad de recorrer $request->folio_inicial_final

                            // insertamos el primer registro que obtenemos
                            BitacoraTemporal::create([
                                'fecha' => $request->get('fechaEntrada'),
                                'kilometraje_inicial' => $request->get('kmInicial'),
                                'kilometraje_final' => $request->get('kmFinal'),
                                'litros' => $request->get('litros'),
                                'division_vale' => ($denominacion === '') ? null : $denominacion,
                                'importe' => $importe,
                                'actividad_inicial' => $this->toUpper($request->get('de')),
                                'actividad_final' => $this->toUpper($request->get('a')),
                                'vales' => $this->toUpper($request->get('numero_factura')),
                                'solicitud_id' => $idTemporal,
                                'importevales' => $request->get('importefolios'),
                                'numero_comision' => (!empty($request->get('numero_comision'))) ? $this->toUpper($request->get('numero_comision')) : null,
                                'comision' => $check_comision
                            ]);

                            // obtener datos del temporal
                            $temp = Temporal::where('id', $idTemporal)->first();

                            // hacer calculos -- castear
                            $totalKmRecorridos = (int) $temp->total_km_recorridos + (int)$kmRecorrido;

                            $importeTotal = (float) $temp->importe_total + (float) $request->importefolios;

                            $ltTotal = (float) $temp->litros_totales + (float) $request->get('litros');

                            // actualizamos el siguiente registro
                            Temporal::where('id', $idTemporal)->update([
                                'status_proceso' => 1,
                                'total_km_recorridos' => (int)$totalKmRecorridos,
                                'litros_totales' => $ltTotal,
                                'importe_total' => $importeTotal,
                                'es_comision' => 0, //si es comisión se agrega el campo y vamos a utilizarlo hasta que deje de servinos en las iteracciones de bitácoras
                            ]);

                            #actualizar el registro de catalogo del vehiculo con el km final
                            CatalogoVehiculo::where('id', $idVehicle)->update(['km_final' => $request->get('kmFinal')]);
                            #modificar catalogo de vehículos agregar kilometraje final

                            $respuesta['response'] = true;
                            $respuesta['message'] = 'AGREGADO ÉXITOSAMENTE';
                            return $respuesta;
                        } elseif (!empty($request->folio_inicial_final) && empty($request->get('numero_factura'))) {
                            # la condición cambia completamente

                            /**
                             * primeramente se realiza el primer bucle para obtener todos los folios y después ya realizamos la consulta para obtener toda la información
                             * de las sumas totales de importe e importevales
                             */
                            foreach ($request->folio_inicial_final as $k) {
                                # realizamos el recorrido para obtener la información
                                # extraemos ambos valores
                                $aryItemFolio = explode("|", $k);

                                //realizamos una consulta dentro del bucle para obtener los valores de los folios asignados
                                $QryFolioById = Folio::where('id', $aryItemFolio[0])->first();

                                # checamos cuántas items tiene el arreglo si es uno sólo se procede a guardar y si es más de uno se realiza la sig. iteración
                                $operator .= $QryFolioById->numero_folio . ",";
                            }

                            $operator = rtrim($operator, ","); // quitar la coma y espacio final

                            // realizar una consulta - condicional creado para la consulta
                            $conditional = [
                                ['vales', '=', $operator],
                                ['solicitud_id', '=', $idTemporal],
                                ['confirmado', '=', 1],
                            ];

                            // checamos que la coleccion de la consulta no esté vacia collect([])->isNotEmpty();
                            $QueryBitacora = BitacoraTemporal::where($conditional)->get();

                            if ($QueryBitacora->isNotEmpty()) {
                                # si la consulta no está vacia se tiene que realizar
                                # si la consulta no está vacia entrará en verdadero true - consulta de la suma
                                $QuerySumaBitacora = BitacoraTemporal::selectRaw('SUM(importe) AS imp , SUM(DISTINCT importevales) AS imp_vale ')->where($conditional)->get();

                                //obtener la sumatoria
                                $imp = $QuerySumaBitacora[0]->imp;
                                $impVale = number_format($QuerySumaBitacora[0]->imp_vale, 2);
                                //cast impvale to float
                                $castImpVale = (float) $impVale; // importe del vale

                                $valueImporte = trim($request->get('importe')); // importe de la gasolina
                                $valueImporte = (float) $valueImporte;
                                $sumaImporte = $imp + $valueImporte;

                                //comparamos ambos importes, los cuales son los de la consulta anterior y también los de la suma del importe ahora con lo almacenado
                                if ($castImpVale === $sumaImporte) {
                                    # true si $castImpVale es igual a $sumaImporte, y son del mismo tipo. guardamos el último registro y actualizamos los estados del folio
                                    list($listaOperador, $listadenominacion, $sumaRecorrido) = self::getRecorrido($request->folio_inicial_final, 'TERMINADO', $idVehicle, $suma, $denominacion, $countdv100, $countdv200, $countdv50, $operador);

                                    // realizamos la inserción (la última)
                                    // insertamos nuevo registro
                                    BitacoraTemporal::create([
                                        'fecha' => $request->get('fechaEntrada'),
                                        'kilometraje_inicial' => $request->get('kmInicial'),
                                        'kilometraje_final' => $request->get('kmFinal'),
                                        'litros' => $request->get('litros'),
                                        'division_vale' => $listadenominacion,
                                        'importe' => $request->get('importe'),
                                        'actividad_inicial' => $this->toUpper($request->get('de')),
                                        'actividad_final' => $this->toUpper($request->get('a')),
                                        'vales' => $listaOperador,
                                        'solicitud_id' => $idTemporal,
                                        'importevales' => $sumaRecorrido,
                                        'numero_comision' => (!empty($request->get('numero_comision'))) ? $this->toUpper($request->get('numero_comision')) : null,
                                        'comision' => $check_comision,
                                        'confirmado' => 1,
                                    ]);

                                    // obtener datos del temporal
                                    $temp = Temporal::where('id', $idTemporal)->first();

                                    // hacer calculos -- castear
                                    $totalKmRecorridos = (int) $temp->total_km_recorridos + (int)$kmRecorrido;

                                    $importeTotal = (float) $temp->importe_total + (float) $sumaRecorrido;

                                    $ltTotal = (float) $temp->litros_totales + (float) $request->get('litros');

                                    // actualizamos el siguiente registro
                                    Temporal::where('id', $idTemporal)->update([
                                        'total_km_recorridos' => $totalKmRecorridos,
                                        'litros_totales' => $ltTotal,
                                        'importe_total' => $importeTotal,
                                        'es_comision' => 0, //si es comisión se agrega el campo y vamos a utilizarlo hasta que deje de servinos en las iteracciones de bitácoras
                                    ]);

                                    #actualizar el registro de catalogo del vehiculo con el km final
                                    CatalogoVehiculo::where('id', $idVehicle)->update(['km_final' => $request->get('kmFinal')]);

                                    $respuesta['response'] = true;
                                    $respuesta['message'] = 'AGREGADO ÉXITOSAMENTE';

                                    return $respuesta;
                                } elseif ($sumaImporte < $castImpVale) {
                                    # si la suma del importe es menor al importe del vale vamos a realizar la sig operación

                                    # aún es menor sumaImporte vamos a guardar el registro y mantenemos el estado del folio intacto
                                    list($listOperador, $listDenominacion, $listSuma) = self::getRecorrido($request->folio_inicial_final, $strStatusFolio, $idVehicle, $suma, $denominacion, $countdv100, $countdv200, $countdv50, $operador);

                                    // realizamos la inserción seguira registrandose
                                    // insertamos nuevo registro
                                    BitacoraTemporal::create([
                                        'fecha' => $request->get('fechaEntrada'),
                                        'kilometraje_inicial' => $request->get('kmInicial'),
                                        'kilometraje_final' => $request->get('kmFinal'),
                                        'litros' => $request->get('litros'),
                                        'division_vale' => $listDenominacion,
                                        'importe' => $request->get('importe'),
                                        'actividad_inicial' => $this->toUpper($request->get('de')),
                                        'actividad_final' => $this->toUpper($request->get('a')),
                                        'vales' => $listOperador,
                                        'solicitud_id' => $idTemporal,
                                        'importevales' => $listSuma,
                                        'numero_comision' => (!empty($request->get('numero_comision'))) ? $this->toUpper($request->get('numero_comision')) : null,
                                        'comision' => $check_comision,
                                        'confirmado' => 1,
                                    ]);

                                    // obtener datos del temporal
                                    $temp = Temporal::where('id', $idTemporal)->first();

                                    // hacer calculos -- castear
                                    $totalKmRecorridos = (int) $temp->total_km_recorridos + (int)$kmRecorrido;

                                    $importeTotal = (float) $temp->importe_total + (float) $listSuma;

                                    $ltTotal = (float) $temp->litros_totales + (float) $request->get('litros');

                                    // actualizamos el siguiente registro
                                    Temporal::where('id', $idTemporal)->update([
                                        'total_km_recorridos' => $totalKmRecorridos,
                                        'litros_totales' => $ltTotal,
                                        'importe_total' => $importeTotal,
                                        'es_comision' => 1, //si es comisión se agrega el campo y vamos a utilizarlo hasta que deje de servinos en las iteracciones de bitácoras
                                    ]);


                                    #actualizar el registro de catalogo del vehiculo con el km final
                                    CatalogoVehiculo::where('id', $idVehicle)->update(['km_final' => $request->get('kmFinal')]);

                                    $respuesta['response'] = true;
                                    $respuesta['message'] = 'AGREGADO ÉXITOSAMENTE';


                                    return $respuesta;
                                } elseif ($sumaImporte > $castImpVale) {
                                    # si la suma del importe es mayor nos límitamos a mandar un mensaje
                                    $respuesta['response'] = false;
                                    $respuesta['message'] = 'NO SE PUEDE AGREGAR RECORRIDO, YA QUE EL IMPORTE DE GASOLINA PASA AL IMPORTE ACOMULADO DE LOS FOLIOS DE LA COMISIÓN!';
                                    return $respuesta;
                                }
                            } else {
                                #se checa la información para ver si los datos son correctos
                                $valueImporte = trim($request->get('importe')); // importe de la gasolina
                                $valueImporte = (float) $valueImporte;
                                if ($importe_folio === $valueImporte) {
                                    # comparación con el importe de gasolina y el importe de folios son iguales se da por terminado el status del proceso
                                    $strStatus = 'TERMINADO';
                                } else {
                                    $strStatus = 'COMISION';
                                }
                                # si se encuentra vacia la consulta -- vamos a realizar la operación de manera normal
                                // recorremos la variable folio_inicial_final que es un arreglo para obtener valores
                                list($oprd, $dnmon, $sumReq) = self::getRecorrido($request->folio_inicial_final, $strStatus, $idVehicle, $suma, $denominacion, $countdv100, $countdv200, $countdv50, $operador);

                                // insertamos nuevo registro
                                BitacoraTemporal::create([
                                    'fecha' => $request->get('fechaEntrada'),
                                    'kilometraje_inicial' => $request->get('kmInicial'),
                                    'kilometraje_final' => $request->get('kmFinal'),
                                    'litros' => $request->get('litros'),
                                    'division_vale' => $dnmon,
                                    'importe' => $request->get('importe'),
                                    'actividad_inicial' => $this->toUpper($request->get('de')),
                                    'actividad_final' => $this->toUpper($request->get('a')),
                                    'vales' => $oprd,
                                    'solicitud_id' => $idTemporal,
                                    'importevales' => $sumReq,
                                    'numero_comision' => (!empty($request->get('numero_comision'))) ? $this->toUpper($request->get('numero_comision')) : null,
                                    'comision' => $check_comision,
                                    'confirmado' => 1,
                                ]);

                                // obtener datos del temporal
                                $temp = Temporal::where('id', $idTemporal)->first();

                                // hacer calculos -- castear
                                $totalKmRecorridos = (int) $temp->total_km_recorridos + (int)$kmRecorrido;

                                $importeTotal = (float) $temp->importe_total + (float) $sumReq;

                                $ltTotal = (float) $temp->litros_totales + (float) $request->get('litros');

                                // actualizamos el siguiente registro
                                Temporal::where('id', $idTemporal)->update([
                                    'total_km_recorridos' => $totalKmRecorridos,
                                    'litros_totales' => $ltTotal,
                                    'importe_total' => $importeTotal,
                                    'es_comision' => 1, //si es comisión se agrega el campo y vamos a utilizarlo hasta que deje de servinos en las iteracciones de bitácoras
                                ]);

                                #actualizar el registro de catalogo del vehiculo con el km final
                                CatalogoVehiculo::where('id', $idVehicle)->update(['km_final' => $request->get('kmFinal')]);

                                $respuesta['response'] = true;
                                $respuesta['message'] = 'AGREGADO ÉXITOSAMENTE';
                                return $respuesta;
                            }
                        }
                    }
                }
            } else {
                # la comision es falsa
                $strStatusFolio = 'BITACORA';

                #checamos si son diferentes
                if ($importe > $importe_folio) {
                    # solo retorno falso
                    $respuesta['response'] = false;
                    $respuesta['message'] = 'EL IMPORTE NO PUEDE SER MAYOR AL IMPORTE DE LOS FOLIOS!';
                    return $respuesta;
                } else {

                    $idVehicle = base64_decode($request->get('idCatVehiculo'));
                    // checamos que no haya un registro previo con el id
                    $chkTemp = Temporal::where([['catalogo_vehiculo_id', $idVehicle], ['status_proceso', true]])->first();

                    if (!$chkTemp) {
                        # si no hay registros anteriores procedemos a generar el proceso
                        $insertTemporal = Temporal::create([
                            'catalogo_vehiculo_id' => $idVehicle,
                            'fecha' => $request->get('fechaEntrada'),
                            'km_inicial' => $request->get('kmInicial'),
                            'numero_factura_compra' => $this->toUpper($request->get('noFactura')),
                            'nombre_elabora' => Auth::user()->name,
                            'anio_actual' => Carbon::now()->year,
                            'puesto_elabora' => Auth::user()->puesto,
                            'users_id' => Auth::user()->id,
                        ]);

                        $lastId = $insertTemporal->id;

                        // recorremos la variable folio_inicial_final que es un arreglo para obtener valores
                        static $suma = 0;
                        static $operador = '';
                        static $dv = '';
                        $count_dv_100 = 0;
                        $count_dv_50 = 0;
                        $count_dv_200 = 0;

                        foreach ($request->folio_inicial_final as $item) {
                            # extraemos ambos valores
                            $arrItem = explode("|", $item);
                            // actualizar registros
                            Folio::where('id', $arrItem[0])->update([
                                'status' => $strStatusFolio,
                                'utilizado' => true,
                            ]);

                            $suma += (int)$arrItem[1]; // suma de los las deonominaciones
                            $getFolioById = Folio::where('id', $arrItem[0])->first();

                            // realizar un bucle
                            switch ($arrItem[1]) {
                                case '100':
                                    # checamos que la denominacion de vale no se repita en toda la iteración, si es así sólo se agreaga una vez
                                    if ($count_dv_100 === 0) {
                                        # checar si un string dv está vacio
                                        if (!empty($dv)) {
                                            # si no está vacio se procede a concatenar
                                            $dv .= ", " . $arrItem[1];
                                        } else {
                                            $dv .= $arrItem[1];
                                        }
                                        # actualizar el contador de la denominacion de vales a +1 en este caso es el valor 100
                                        $count_dv_100 = $count_dv_100 + 1;
                                    }
                                    break;
                                case '200':
                                    # checamos la denominación de vale de 200 para no repetir toda la iteracion
                                    if ($count_dv_200 === 0) {
                                        # si son iguales se checa que el string dv este vacio
                                        if (!empty($dv)) {
                                            # si no se encuentra vacio procede a concatenar
                                            $dv .= ", " . $arrItem[1];
                                        } else {
                                            # si está vacio se agrega directamente
                                            $dv .= $arrItem[1];
                                        }
                                        # actualizar el contador de la denominacion de vales a +1 en este caso es el valor 200
                                        $count_dv_200 = $count_dv_200 + 1;
                                    }
                                    break;
                                case '50':
                                    # checamos la denominación de vale de 50 para no repetir toda la iteracion
                                    if ($count_dv_50 === 0) {
                                        # si son iguales se checa que el string dv este vacio
                                        if (!empty($dv)) {
                                            # si no se encuentra vacio procede a concatenar
                                            $dv .= ", " . $arrItem[1];
                                        } else {
                                            # si está vacio se agrega directamente
                                            $dv .= $arrItem[1];
                                        }
                                        # actualizar el contador de la denominacion de vales a +1 en este caso es el valor 200
                                        $count_dv_50 = $count_dv_50 + 1;
                                    }
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                            // concatenar los números de folio
                            $operador .= $getFolioById->numero_folio . ",";
                        }

                        $operador = rtrim($operador, ","); // quitar la coma y espacio final

                        // insertamos el primer registro que obtenemos
                        BitacoraTemporal::create([
                            'fecha' => $request->get('fechaEntrada'),
                            'kilometraje_inicial' => $request->get('kmInicial'),
                            'kilometraje_final' => $request->get('kmFinal'),
                            'litros' => $request->get('litros'),
                            'division_vale' => $dv,
                            'importe' => $importe,
                            'actividad_inicial' => $this->toUpper($request->get('de')),
                            'actividad_final' => $this->toUpper($request->get('a')),
                            'vales' => $operador,
                            'solicitud_id' => $lastId,
                            'importevales' => $suma,
                            'numero_comision' => (!empty($request->get('numero_comision'))) ? $this->toUpper($request->get('numero_comision')) : null,
                            'comision' => $check_comision
                        ]);

                        //se checa si el importe de la gasolina es igual o menor al importe de la gasolina
                        if ($importe == $importe_folio) {
                            # si son iguales quiere decir que no se tiene que realizar dicho recorrido y cambia su estado (en los folios porque ese recorrido será único)
                            foreach ($request->folio_inicial_final as $value) {
                                # realizamos un recorrido en el bucle para poder actualizar
                                # extraemos ambos valores
                                $itemArr = explode("|", $value);
                                $vehicle = CatalogoVehiculo::findOrFail($idVehicle); // obteniendo registro - vehículo
                                $vehicle->folio()->updateExistingPivot($itemArr[0], ['transitado' => true, 'status' => 'TERMINADO']); // actualizando registro de una tabla pivote
                            }
                        } elseif ($importe < $importe_folio) {
                            # si el importe es menor todavía podría mostrarse la información de los folios, para continuar con ese recorrido (previo)
                            foreach ($request->folio_inicial_final as $key) {
                                # realizamos el proceso del bucle para actualizar los estados
                                # extraemos ambos valores
                                $array = explode("|", $key);
                                $vhclo = CatalogoVehiculo::findOrFail($idVehicle); // obteniendo registro - vehículo
                                $vhclo->folio()->updateExistingPivot($array[0], ['status' => $strStatusFolio, 'transitado' => true]); // actualizando registro de una tabla pivote
                            }

                            // se confirma la tabla bitacora_temporal
                            BitacoraTemporal::where('solicitud_id', $lastId)->update([
                                'confirmado' => 1, // se cambiara a verdadero cuándo aún los importes no cuadren
                            ]);
                        }

                        // actualizamos el siguiente registro
                        Temporal::where('id', $lastId)->update([
                            'status_proceso' => 1,
                            'total_km_recorridos' => (int)$kmRecorrido,
                            'litros_totales' => $request->get('litros'),
                            'importe_total' => $suma,
                            'es_comision' => 0, //si es comisión se agrega el campo y vamos a utilizarlo hasta que deje de servinos en las iteracciones de bitácoras
                        ]);

                        #actualizar el registro de catalogo del vehiculo con el km final
                        CatalogoVehiculo::where('id', $idVehicle)->update(['km_final' => $request->get('kmFinal')]);
                        #modificar catalogo de vehículos agregar kilometraje final

                        $respuesta['response'] = true;
                        $respuesta['message'] = 'AGREGADO ÉXITOSAMENTE';
                        return $respuesta;
                    } else {
                        // si el valor del vehículo existe en la tabla temporal -- idvehículo
                        $idTemporal = $chkTemp->id;

                        // value declaration
                        static $operator = '';
                        static $suma = 0;
                        static $operador = '';
                        static $denominacion = '';
                        $countdv100 = 0;
                        $countdv200 = 0;
                        $countdv50 = 0;

                        /**
                         * primeramente se realiza el primer bucle para obtener todos los folios y después ya realizamos la consulta para obtener toda la información
                         * de las sumas totales de importe e importevales
                         */
                        foreach ($request->folio_inicial_final as $j) {
                            # realizamos el recorrido para obtener la información
                            # extraemos ambos valores
                            $aryItemFolio = explode("|", $j);

                            //realizamos una consulta dentro del bucle para obtener los valores de los folios asignados
                            $QryFolioById = Folio::where('id', $aryItemFolio[0])->first();

                            # checamos cuántas items tiene el arreglo si es uno sólo se procede a guardar y si es más de uno se realiza la sig. iteración
                            $operator .= $QryFolioById->numero_folio . ",";
                        }
                        $operator = rtrim($operator, ","); // quitar la coma y espacio final

                        // realizar una consulta
                        $conditional = [
                            ['vales', '=', $operator],
                            ['solicitud_id', '=', $idTemporal],
                            ['confirmado', '=', 1],
                        ];

                        $QryBitacora = BitacoraTemporal::where($conditional)->get();

                        // checamos que la coleccion de la consulta no esté vacia collect([])->isNotEmpty();

                        if ($QryBitacora->isNotEmpty()) {
                            # si la consulta no está vacia entrará en verdadero true - consulta de la suma
                            $QrySumBitacora = BitacoraTemporal::selectRaw('SUM(importe) AS imp , SUM(DISTINCT importevales) AS imp_vale ')->where($conditional)->get();
                            //obtener la sumatoria
                            $imp = $QrySumBitacora[0]->imp;
                            $impVale = number_format($QrySumBitacora[0]->imp_vale, 2);
                            //cast impvale to float
                            $castImpVale = (float) $impVale; // importe del vale

                            $valueImporte = trim($request->get('importe')); // importe de la gasolina
                            $valueImporte = (float) $valueImporte;
                            $sumaImporte = $imp + $valueImporte;

                            //comparamos ambos importes, los cuales son los de la consulta anterior y también los de la suma del importe ahora con lo almacenado
                            if ($castImpVale === $sumaImporte) {
                                # true si $castImpVale es igual a $sumaImporte, y son del mismo tipo. guardamos el último registro y actualizamos los estados del folio
                                list($listaOperador, $listadenominacion, $sumaRecorrido) = self::getRecorrido($request->folio_inicial_final, 'TERMINADO', $idVehicle, $suma, $denominacion, $countdv100, $countdv200, $countdv50, $operador);

                                // realizamos la inserción (la última)
                                // insertamos nuevo registro
                                BitacoraTemporal::create([
                                    'fecha' => $request->get('fechaEntrada'),
                                    'kilometraje_inicial' => $request->get('kmInicial'),
                                    'kilometraje_final' => $request->get('kmFinal'),
                                    'litros' => $request->get('litros'),
                                    'division_vale' => $listadenominacion,
                                    'importe' => $request->get('importe'),
                                    'actividad_inicial' => $this->toUpper($request->get('de')),
                                    'actividad_final' => $this->toUpper($request->get('a')),
                                    'vales' => $listaOperador,
                                    'solicitud_id' => $idTemporal,
                                    'importevales' => $sumaRecorrido,
                                    'numero_comision' => (!empty($request->get('numero_comision'))) ? $this->toUpper($request->get('numero_comision')) : null,
                                    'comision' => $check_comision,
                                    'confirmado' => 1,
                                ]);

                                // obtener datos del temporal
                                $temp = Temporal::where('id', $idTemporal)->first();

                                // hacer calculos -- castear
                                $totalKmRecorridos = (int) $temp->total_km_recorridos + (int)$kmRecorrido;

                                $importeTotal = (float) $temp->importe_total + (float) $sumaRecorrido;

                                $ltTotal = (float) $temp->litros_totales + (float) $request->get('litros');

                                // actualizamos el siguiente registro
                                Temporal::where('id', $idTemporal)->update([
                                    'total_km_recorridos' => $totalKmRecorridos,
                                    'litros_totales' => $ltTotal,
                                    'importe_total' => $importeTotal,
                                    'es_comision' => 0, //si es comisión se agrega el campo y vamos a utilizarlo hasta que deje de servinos en las iteracciones de bitácoras
                                ]);

                                #actualizar el registro de catalogo del vehiculo con el km final
                                CatalogoVehiculo::where('id', $idVehicle)->update(['km_final' => $request->get('kmFinal')]);

                                $respuesta['response'] = true;
                                $respuesta['message'] = 'AGREGADO ÉXITOSAMENTE';

                                return $respuesta;
                            } elseif ($sumaImporte < $castImpVale) {
                                # aún es menor sumaImporte vamos a guardar el registro y mantenemos el estado del folio intacto

                                list($listOperador, $listDenominacion, $listSuma) = self::getRecorrido($request->folio_inicial_final, $strStatusFolio, $idVehicle, $suma, $denominacion, $countdv100, $countdv200, $countdv50, $operador);

                                // realizamos la inserción seguira registrandose
                                // insertamos nuevo registro
                                BitacoraTemporal::create([
                                    'fecha' => $request->get('fechaEntrada'),
                                    'kilometraje_inicial' => $request->get('kmInicial'),
                                    'kilometraje_final' => $request->get('kmFinal'),
                                    'litros' => $request->get('litros'),
                                    'division_vale' => $listDenominacion,
                                    'importe' => $request->get('importe'),
                                    'actividad_inicial' => $this->toUpper($request->get('de')),
                                    'actividad_final' => $this->toUpper($request->get('a')),
                                    'vales' => $listOperador,
                                    'solicitud_id' => $idTemporal,
                                    'importevales' => $listSuma,
                                    'numero_comision' => (!empty($request->get('numero_comision'))) ? $this->toUpper($request->get('numero_comision')) : null,
                                    'comision' => $check_comision,
                                    'confirmado' => 1,
                                ]);

                                // obtener datos del temporal
                                $temp = Temporal::where('id', $idTemporal)->first();

                                // hacer calculos -- castear
                                $totalKmRecorridos = (int) $temp->total_km_recorridos + (int)$kmRecorrido;

                                $importeTotal = (float) $temp->importe_total + (float) $listSuma;

                                $ltTotal = (float) $temp->litros_totales + (float) $request->get('litros');

                                // actualizamos el siguiente registro
                                Temporal::where('id', $idTemporal)->update([
                                    'total_km_recorridos' => $totalKmRecorridos,
                                    'litros_totales' => $ltTotal,
                                    'importe_total' => $importeTotal,
                                    'es_comision' => 0, //si es comisión se agrega el campo y vamos a utilizarlo hasta que deje de servinos en las iteracciones de bitácoras
                                ]);

                                #actualizar el registro de catalogo del vehiculo con el km final
                                CatalogoVehiculo::where('id', $idVehicle)->update(['km_final' => $request->get('kmFinal')]);

                                $respuesta['response'] = true;
                                $respuesta['message'] = 'AGREGADO ÉXITOSAMENTE';


                                return $respuesta;
                            } elseif ($sumaImporte > $castImpVale) {
                                # si la suma del importe es mayor nos límitamos a mandar un mensaje
                                $respuesta['response'] = false;
                                $respuesta['message'] = 'NO SE PUEDE AGREGAR RECORRIDO, YA QUE EL IMPORTE DE GASOLINA PASA AL IMPORTE ACOMULADO DE LOS FOLIOS!';
                                return $respuesta;
                            }
                        } else {
                            # si se encuentra vacia la consulta -- vamos a realizar la operación de manera normal
                            // recorremos la variable folio_inicial_final que es un arreglo para obtener valores
                            $valueImporte = trim($request->get('importe')); // importe de la gasolina
                            $valueImporte = (float) $valueImporte;

                            if ($importe_folio === $valueImporte) {
                                # comparación con el importe de gasolina y el importe de folios son iguales se da por terminado el status del proceso
                                $strStatus = 'TERMINADO';
                            } else {
                                $strStatus = 'BITACORA';
                            }

                            list($oprd, $dnmon, $sumReq) = self::getRecorrido($request->folio_inicial_final, $strStatus, $idVehicle, $suma, $denominacion, $countdv100, $countdv200, $countdv50, $operador);


                            // insertamos nuevo registro
                            BitacoraTemporal::create([
                                'fecha' => $request->get('fechaEntrada'),
                                'kilometraje_inicial' => $request->get('kmInicial'),
                                'kilometraje_final' => $request->get('kmFinal'),
                                'litros' => $request->get('litros'),
                                'division_vale' => $dnmon,
                                'importe' => $request->get('importe'),
                                'actividad_inicial' => $this->toUpper($request->get('de')),
                                'actividad_final' => $this->toUpper($request->get('a')),
                                'vales' => $oprd,
                                'solicitud_id' => $idTemporal,
                                'importevales' => $sumReq,
                                'numero_comision' => (!empty($request->get('numero_comision'))) ? $this->toUpper($request->get('numero_comision')) : null,
                                'comision' => $check_comision,
                                'confirmado' => 1,
                            ]);

                            // obtener datos del temporal
                            $temp = Temporal::where('id', $idTemporal)->first();

                            // hacer calculos -- castear
                            $totalKmRecorridos = (int) $temp->total_km_recorridos + (int)$kmRecorrido;

                            $importeTotal = (float) $temp->importe_total + (float) $sumReq;

                            $ltTotal = (float) $temp->litros_totales + (float) $request->get('litros');

                            // actualizamos el siguiente registro
                            Temporal::where('id', $idTemporal)->update([
                                'total_km_recorridos' => $totalKmRecorridos,
                                'litros_totales' => $ltTotal,
                                'importe_total' => $importeTotal,
                                'es_comision' => 0, //si es comisión se agrega el campo y vamos a utilizarlo hasta que deje de servinos en las iteracciones de bitácoras
                            ]);

                            #actualizar el registro de catalogo del vehiculo con el km final
                            CatalogoVehiculo::where('id', $idVehicle)->update(['km_final' => $request->get('kmFinal')]);

                            $respuesta['response'] = true;
                            $respuesta['message'] = 'AGREGADO ÉXITOSAMENTE';
                            return $respuesta;
                        }
                    }
                }
            }
        } catch (QueryException $e) {
            //excepción SQL
            $respuesta = [];
            $respuesta['response'] = false;
            $respuesta['message'] = $e->getMessage();
            return $respuesta;
        }
    }

    public function getBitacoraReport(Request $request): object
    {
        try {
            $numeroFactura = $request->get('facturas');
            $from = $request->get('fechaInicio');
            $to = $request->get('fechaFinal');

            // consulta
            $Qry = Temporal::select('temporal.id', 'temporal.catalogo_vehiculo_id', 'temporal.numero_factura_compra', 'cv.marca', 'cv.modelo', 'cv.placas')
                ->join('bitacora_temporal AS bt', 'temporal.id', '=', 'bt.solicitud_id')
                ->join('catalogo_vehiculo AS cv', 'temporal.catalogo_vehiculo_id', '=', 'cv.id')
                ->where('temporal.numero_factura_compra', $numeroFactura);
            //consulta Qry
            if (!empty($from) && !empty($to)) {
                # checar si las variables están vacias o no
                $Qry->whereBetween('bt.fecha', [$from, $to]);
            }

            return $Qry->groupBy('temporal.id', 'temporal.catalogo_vehiculo_id', 'temporal.numero_factura_compra', 'cv.marca', 'cv.modelo', 'cv.placas')->get();
        } catch (QueryException $e) {
            //exception SQL
            return $e->getMessage();
        }
    }

    static public function getRecorrido($folioInicilFinal  = null, $strStatusFolio, $idVehicle, $suma, $denominacion, $countdv100, $countdv200, $countdv50, $operador)
    {

        foreach ($folioInicilFinal as $item) {
            # extraemos ambos valores
            $arrItem = explode("|", $item);

            // actualizar registros
            Folio::where('id', $arrItem[0])->update([
                'status' => $strStatusFolio,
                'utilizado' => 1,
            ]);

            $vehiculo = CatalogoVehiculo::findOrFail($idVehicle); // obteniendo registro
            $vehiculo->folio()->updateExistingPivot($arrItem[0], ['status' => $strStatusFolio, 'transitado' => 1]); // actualizando registro de una tabla pivote

            $suma += $arrItem[1]; // suma de los las deonominaciones
            $getFolioById = Folio::where('id', $arrItem[0])->first();

            // realizar un switch para las denominaciones de vale
            switch ($arrItem[1]) {
                case '100':
                    # checamos que la denominacion de vale no se repita en toda la iteración, si es así sólo se agreaga una vez
                    if ($countdv100 === 0) {
                        # si son iguales se checa que el string dv este vacio
                        if (!empty($denominacion)) {
                            # si no se encuentra vacio procede a concatenar
                            $denominacion .= ", " . $arrItem[1];
                        } else {
                            # si está vacio se agrega directamente
                            $denominacion .= $arrItem[1];
                        }
                        # actualizar el contador de la denominacion de vales a +1 en este caso es el valor 200
                        $countdv100 = $countdv100 + 1;
                    }
                    break;
                case '200':
                    # code...
                    if ($countdv200 === 0) {
                        # si son iguales se checa que el string dv este vacio
                        if (!empty($denominacion)) {
                            # si no se encuentra vacio procede a concatenar
                            $denominacion .= ", " . $arrItem[1];
                        } else {
                            # si está vacio se agrega directamente
                            $denominacion .= $arrItem[1];
                        }
                        # actualizar el contador de la denominacion de vales a +1 en este caso es el valor 200
                        $countdv200 = $countdv200 + 1;
                    }
                    break;
                case '50':
                    # code...
                    if ($countdv50 === 0) {
                        # si son iguales se checa que el string dv este vacio
                        if (!empty($denominacion)) {
                            # si no se encuentra vacio procede a concatenar
                            $denominacion .= ", " . $arrItem[1];
                        } else {
                            # si está vacio se agrega directamente
                            $denominacion .= $arrItem[1];
                        }
                        # actualizar el contador de la denominacion de vales a +1 en este caso es el valor 200
                        $countdv50 = $countdv50 + 1;
                    }
                    break;
                default:
                    # carga por defecto
                    break;
            }

            # checamos cuántas items tiene el arreglo si es uno sólo se procede a guardar y si es más de uno se realiza la sig. iteración
            $operador .= $getFolioById->numero_folio . ",";
        }

        $operador = rtrim($operador, ","); // quitar la coma y espacio final

        // retornamos dos valores rápidamente
        return [$operador, $denominacion, $suma];
    }

    public function getTemporal($id)
    {
        try {
            //consulta
            return Temporal::where('catalogo_vehiculo_id', $id)->first();
        } catch (QueryException $e) {
            //excepción SQL
            return $e->getMessage();
        }
    }
}
