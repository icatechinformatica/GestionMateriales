<?php

namespace App\Http\Controllers\solicitud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\PuntoAPuntoTrait;
use App\Http\Traits\savePreComision;
use App\Http\Traits\PreComisionTrait;
use Illuminate\Database\QueryException;
use App\Models\solicitud\PreComision;
use App\Models\solicitud\PuntoAPunto;
use Illuminate\Support\Facades\Auth;
use App\Models\solicitud\RecorridoComisionTemporal;
use App\Models\solicitud\BitacoraComisionTemporal;
use App\Models\solicitud\Temporal;
use App\Models\Solicitud\CatalogoVehiculo;
use Carbon\Carbon;
use App\Models\solicitud\Solicitud;
use Illuminate\Support\Str;
use App\Models\solicitud\SeguimientoSolicitud;
use App\Models\solicitud\RecorridoComision;
use App\Models\solicitud\BitacoraComision;

class PreComisionController extends Controller
{
    use PuntoAPuntoTrait, PreComisionTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // try catch - excepciones sql
       try {
           //code...
           $pre_comision = $this->savePreComision($request);
            /**
            * punto a punto
            */
            $this->savePuntoAPunto($pre_comision, $request->puntoapunto);

            /**
             * se redirecciona
             */
            return redirect()->route('pre.comision.index')->with('success', 'PRE-COMISIÓN AGREGADO ÉXITOSAMENTE!');
       } catch (QueryException $th) {
           //se lanza un excepcion de tipo sql;
           return back()->with('error', $th->getMessage());
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $idpre = base64_decode($id);
        $preComision = PreComision::where('id', $idpre)->first();
        $punto_a_punto = PuntoAPunto::where('pre_comision_id', $idpre)->get();
        /**
         * cargamos los registros del vehículos que estamos teniendo para poderlo utilizar en la consulta
         */
        $catAutomovil = CatalogoVehiculo::select('catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo',
        'catalogo_vehiculo.numero_serie', 'catalogo_vehiculo.numero_motor', 'catalogo_vehiculo.placas', 
        'catalogo_vehiculo.color', 'catalogo_vehiculo.tipo', 'resguardante.resguardante_unidad', 
        'resguardante.puesto_resguardante_unidad', 'catalogo_vehiculo.id as vehiculoId')
                        ->leftjoin('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')
                        ->where('placas', $preComision->placas_vehiculo)->first();
        return view('theme.dashboard.forms.form_bitacora_comision', compact('preComision', 'punto_a_punto', 'catAutomovil'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_precomision = base64_decode($id);
        //
        $preComision = PreComision::findOrFail($id_precomision)->first();
        $punto_a_punto = PuntoAPunto::where('pre_comision_id', $id_precomision)->get();
        $temporal = Temporal::select('temporal.fecha', 'temporal.periodo', 'temporal.memorandum_comision',
       'temporal.numero_factura_compra', 'temporal.id as temporalid',
       'temporal.status_proceso', 'catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo',
       'catalogo_vehiculo.numero_serie', 'catalogo_vehiculo.numero_motor', 'temporal.conductor',
       'temporal.km_inicial', 'temporal.km_final_antes_cargar_combustible',
       'temporal.total_km_recorridos', 'temporal.litros_totales', 'temporal.importe_total', 'temporal.observacion',
       'catalogo_vehiculo.tipo', 'temporal.periodo_actual',
       'catalogo_vehiculo.id as vehiculoId', 'catalogo_vehiculo.placas', 'catalogo_vehiculo.color', 'resguardante.resguardante_unidad', 'resguardante.puesto_resguardante_unidad')
       ->leftjoin('catalogo_vehiculo', 'temporal.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
       ->leftjoin('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')
       ->where([
           ['temporal.users_id', '=', Auth::user()->id],
           ['temporal.enviado', '=', false],
           ['temporal.es_comision', '=', true],
           ['pre_comision_id', '=', $id_precomision]
       ])->first();
       
       $recorrido_comision_temp = RecorridoComisionTemporal::where('temporal_id', $temporal->temporalid)->get();
       $bitacora_comision_temp = BitacoraComisionTemporal::where('temporal_id', $temporal->temporalid)->get();

       /**
        * retornamos la vista
        */
        return view('theme.dashboard.forms.form_bitacora_comision_update', compact('temporal', 'recorrido_comision_temp', 'bitacora_comision_temp', 'id_precomision', 'preComision', 'punto_a_punto'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /**
         * nueva modificación
         * calcular el tiempo transcurrido de la solicitud fechaFin - fechaInicio
         */
        try {
            $idSolicitud = base64_decode($id);
            /**
             * se actualiza el seguimiento_solicitud se cambia el seguimiento
             */
            $fechaInicio = SeguimientoSolicitud::where('solicitud_id', $idSolicitud)->first();
            //consulta para actualizar registro
            $fechaFin = Carbon::now()->format('Y-m-d');
            $tiempoSolicitud = Carbon::createFromDate($fechaInicio->fecha_inicio)->diffInDays($fechaFin);

            SeguimientoSolicitud::where('solicitud_id', $idSolicitud)->update([
                'status_seguimiento_id' => 5, 
                'fecha_fin' => $fechaFin,
                'tiempo_solicitud' => $tiempoSolicitud
            ]);
            // vamos a redireccionar el sistema
            return redirect()->route('solicitud.pre.comision.revision')->with('success', 'COMISIÓN VALIDADA ÉXITOSAMENTE.');
        } catch (QueryException $th) {
            //excepcion de consulta;
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function saveandupdate(Request $request)
    {
        try {
            //codigo de ejecución al menos intentar una vez
            switch ($request->get('ejecutar')) {
                case 'update':
                    # actualización del registro
                    $preComisionId = base64_decode($request->get('pre_comision_id'));
                    Temporal::where('id', $preComisionId)->update([
                        'catalogo_vehiculo_id' => $request->get('idcatvehiculo'),
                        'memorandum_comision' => $request->get('memo_comision'),
                        'fecha' => $request->get('fecha_comision'),
                        'periodo' => $request->get('periodo_comision'),
                        'km_inicial' => $request->get('kmInicial'),
                        'km_final_antes_cargar_combustible' => $request->get('kmFinal'),
                        'conductor' => $request->get('nombreConductor'),
                        'periodo_actual' => $request->get('periodo_comision_actual'),
                        'litros_totales' => $request->get('litros_totales'),
                        'total_km_recorridos' => $request->get('km_totales'),
                        'importe_total' => $request->get('importe_total'),
                        'users_id' => Auth::user()->id,
                        'observacion' => Str::upper($request->get('observaciones')),
                    ]);
                    /**
                     * eliminar las bitacoras temporales - para cargar nuevamente en bucle
                     */
                    /**
                     * trabajaremos en un bucle para guardar información en otra tabla
                     */
                    BitacoraComisionTemporal::where('temporal_id', $preComisionId)->delete();
                    /**
                     * actualizamos vía bucle
                     */
                    if (!empty($request->addcomisiones)) {
                        # checamos si el arreglo está vacio o no
                        foreach ($request->addcomisiones as $key => $value) {
                            # guardamos los registros
                            $comisiones = new BitacoraComisionTemporal;
                            $comisiones->factura_comision = $value['factura'];
                            $comision->litros_comision = $value['litros'];
                            $comision->precio_unitario_comision = $value['pu'];
                            $comision->importe_comision = $value['importe'];
                            $comision->temporal_id = $preComisionId;
                            /**
                             * guardando el registro dentro del bucle
                             */
                            $comision->save();
                        }
                    }
                    /**
                     * borrar registros
                     */
                    RecorridoComisionTemporal::where('temporal_id', $preComisionId)->delete();
                    if (!empty($request->addcomision)) {
                        # comisiones
                        foreach ($request->addcomision as $k => $v) {
                            # guardamos el registro desde el bucle recorrido
                            $recorrido = new RecorridoComisionTemporal;
                            $recorrido->fecha_comision = $v['fecha_comision'];
                            $recorrido->de_comision = $v['de_comision'];
                            $recorrido->a_comision = $v['a_comision'];
                            $recorrido->temporal_id = $preComisionId;
                            /**
                             * guardar el registro dentro del bucle den recorrido
                             */
                            $recorrido->save();
                        }
                    }
                    // retornar una plantilla
                    return redirect()->route('pre.comision.index')->with('success', 'COMISIÓN MODIFICADA ÉXITOSAMENTE!');
                break;
                case 'enviar':
                    /**
                     * enviar datos de los registros
                     */
                    # actualización de registro - cargar registros en tabla solicitud
                    $comisionId = base64_decode($request->get('pre_comision_id'));
                    /**
                     * insertar a la base de datos
                     */
                    /**
                     * obtenemos la fecha actual con el método carbon
                    */
                    $fecha_actual = Carbon::now();
                    $anio = $fecha_actual->year;
                    /**
                     * obtenemos la fecha actual con el método carbón
                     */
                    $fechaSolicitud = Carbon::parse($request->get('fecha_comision'));
                    $anioSolicitud = $fechaSolicitud->year;

                    $solicitudComision = new Solicitud;
                    $solicitudComision->catalogo_vehiculo_id = $request->get('idcatvehiculo');
                    $solicitudComision->memorandum_comision = Str::upper($request->get('memo_comision'));
                    $solicitudComision->anio_actual = $anio;
                    $solicitudComision->periodo = Str::upper($request->get('periodo_comision'));
                    $solicitudComision->fecha = $request->get('fecha_comision');
                    $solicitudComision->km_inicial = $request->get('kmInicial');
                    $solicitudComision->nombre_elabora = Str::upper(Auth::user()->name);
                    $solicitudComision->puesto_elabora = Str::upper(Auth::user()->puesto);
                    $solicitudComision->conductor = Str::upper($request->get('nombreConductor')); 
                    $solicitudComision->periodo_actual = Str::upper($request->get('periodo_comision_actual'));
                    $solicitudComision->litros_totales = $request->get('litros_totales');
                    $solicitudComision->anio_solicitud = $anioSolicitud;
                    $solicitudComision->km_final_antes_cargar_combustible = $request->get('kmFinal');
                    $solicitudComision->total_km_recorridos = $request->get('km_totales');
                    $solicitudComision->importe_total = $request->get('importe_total');
                    $solicitudComision->status_proceso = true;
                    $solicitudComision->users_id = Auth::user()->id;
                    $solicitudComision->tipo_solicitud = 2;
                    // guardar registros y obteneer el último id
                    $solicitudComision->observacion = Str::upper($request->get('observaciones'));
                    $solicitudComision->es_comision = true;
                    $solicitudComision->save();
                    $lastId = $solicitudComision->id;

                    /**
                     * actualizamos el registro en el sistema por generación de los temporales
                     */
                    Temporal::where('id', $comisionId)
                        ->update(['enviado' => true]);

                    /**
                     * se guarda de información seguimiento_solicitud se guarda en el registro
                     */
                    $segSolicitud = new SeguimientoSolicitud;
                    $segSolicitud->solicitud_id = $lastId;
                    $segSolicitud->status_seguimiento_id = 1;
                    $segSolicitud->fecha_inicio = Carbon::now();
                    $segSolicitud->save();
                    /**
                     * bucles para cargar datos
                     */
                    if (!empty($request->addcomision)) {
                        # si hay registros
                        foreach ($request->addcomision as $key => $value) {
                            # se entra en el bucle para cargar los datos en la tabla
                            $comisionRecorrido = new RecorridoComision();
                            $comisionRecorrido->fecha_comision = $value['fecha_comision'];
                            $comisionRecorrido->de_comision = $value['de_comision'];
                            $comisionRecorrido->a_comision = $value['a_comision'];
                            $comisionRecorrido->solicitud_id = $lastId;

                            // guardar registros
                            $comisionRecorrido->save();

                            if (!empty($value['recoridoComision_id'])) {
                                # code...
                                RecorridoComisionTemporal::where('id', $value['recoridoComision_id'])
                                    ->update(['enviado' => true]);
                            }
                        }
                    }
                    /**
                     * generación de otro bucle
                     */
                    if (!empty($request->addcomisiones)) {
                        # si hay registros se dispara el foreach
                        foreach ($request->addcomisiones as $k => $j) {
                            # entrando al bucle se carga los datos a la taba y se actualiza registro en la siguiente tabla
                            $comisionBitacora = new BitacoraComision();
                            $comisionBitacora->factura_comision = $j['factura'];
                            $comisionBitacora->litros_comision = $j['litros'];
                            $comisionBitacora->precio_unitario_comision = $j['pu'];
                            $comisionBitacora->importe_comision = $j['importe'];
                            $comisionBitacora->solicitud_id = $lastId;

                            // guardar registros
                            $comisionBitacora->save();

                            if (!empty($j['comisionTemporalId'])) {
                                # code...
                                BitacoraComisionTemporal::where('id', $j['comisionTemporalId'])
                                    ->update(['enviado' => true]);
                            }
                        }
                    }
                    /**
                     * vamos a llamar al registro del vehiculo para actualizar el 
                     */
                    $catVehiculo = CatalogoVehiculo::where('id', $request->idcatvehiculo)->first();
                    if (is_null($catVehiculo->km_final)) {
                        # si es nulo vamos a obtener los valores de los km iniciales
                        $kmFinal = $catVehiculo->km_inicial + $request->km_totales;
                        CatalogoVehiculo::where('id', $request->idcatvehiculo)->update([ 'km_final' => $kmFinal ]);
                    } else {
                        # si no es nulo vamos a obtener el km final y agregar los km totales
                        $kmFinal = $catVehiculo->km_final + $request->km_totales;
                        CatalogoVehiculo::where('id', $request->idcatvehiculo)->update([ 'km_final' => $kmFinal ]);
                    }
                    /**
                     * después dé insertar la información lo que hacemos será redireccionar
                     */
                    return redirect()->route('pre.comision.index')->with('success', 'COMISIÓN ENVIADA ÉXITOSAMENTE.');
                    // recorrido_comision
                    break;
                default:
                    # code...
                    break;
            }
        } catch (QueryException $th) {
            //envíar excepcion de consulta
            return back()->with('error', $e->getMessage());
        }
    }

    protected function getRevision(Request $request)
    {
        /**
         * consulta para obtener una pre comisión
         */
        $revisarPreComision = $this->getPreComisionRevision();
        return view('theme.dashboard.layouts.bitacora_pre_comision_revision', compact('revisarPreComision'));
    }

    protected function preComisionGetRevision($id)
    {

        $idPreComision = base64_decode($id);
        
        /**
         * vamos a generar la consulta para la revisión
         */
        $sqlComisionGetRevision = Solicitud::select('solicitud.fecha', 'solicitud.periodo', 'solicitud.memorandum_comision',
        'solicitud.numero_factura_compra', 'solicitud.id as solicitudId',
        'solicitud.status_proceso', 'catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo',
        'catalogo_vehiculo.numero_serie', 'catalogo_vehiculo.numero_motor', 'solicitud.conductor',
        'solicitud.km_inicial', 'solicitud.km_final_antes_cargar_combustible',
        'solicitud.total_km_recorridos', 'solicitud.litros_totales', 'solicitud.importe_total', 'solicitud.observacion',
        'catalogo_vehiculo.tipo', 'solicitud.periodo_actual',
        'catalogo_vehiculo.id as vehiculoId', 'catalogo_vehiculo.placas', 'catalogo_vehiculo.color',
        'resguardante.resguardante_unidad', 'resguardante.puesto_resguardante_unidad')
        ->leftjoin('catalogo_vehiculo', 'solicitud.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
        ->leftjoin('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')
        ->leftjoin('pre_comision', 'solicitud.pre_comision_id', '=', 'pre_comision.id')
        ->where([
            ['solicitud.pre_comision_id', '=', $idPreComision]
        ])
        ->first();

        /**
         * se actualiza el seguimiento_solicitud se cambia el seguimiento
         */
        $fechaInicio = SeguimientoSolicitud::where('solicitud_id', $sqlComisionGetRevision->solicitudId)->first();
        /**
         * calcular el tiempo transcurrido de la solicitud fechaFin - fechaInicio
         */
        $fechaFin = Carbon::now()->format('Y-m-d');
        $tiempoSolicitud = Carbon::createFromDate($fechaInicio->fecha_inicio)->diffInDays($fechaFin);
        SeguimientoSolicitud::where('solicitud_id', $sqlComisionGetRevision->solicitudId)->update([
            'status_seguimiento_id' => 3, 
            'fecha_fin' => $fechaFin,
            'tiempo_solicitud' => $tiempoSolicitud
        ]);

        /**
         * bitacora y recorrido
         */

        $recorrido_comision = RecorridoComision::where('solicitud_id', $sqlComisionGetRevision->solicitudId)->get();
        $bitacora_comision = BitacoraComision::where('solicitud_id', $sqlComisionGetRevision->solicitudId)->get();

        return view('theme.dashboard.layouts.comision_bitacora_revision', compact('sqlComisionGetRevision', 'recorrido_comision', 'bitacora_comision'));
    }

    protected function validarBitacoraComision(Request $request)
    {
        /**
         * nueva modificación
         * calcular el tiempo transcurrido de la solicitud fechaFin - fechaInicio
         */
        $fechaFin = Carbon::now()->format('Y-m-d');
        $tiempoSolicitud = Carbon::createFromDate($fechaInicio->fecha_inicio)->diffInDays($fechaFin);
        SeguimientoSolicitud::where('solicitud_id', $sqlComisionGetRevision->solicitudId)->update([
            'status_seguimiento_id' => 3, 
            'fecha_fin' => $fechaFin,
            'tiempo_solicitud' => $tiempoSolicitud
        ]);
    }
}
