<?php

namespace App\Http\Controllers\solicitud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\TemporalTrait;
use App\Models\solicitud\RecorridoComisionTemporal;
use App\Models\solicitud\BitacoraComisionTemporal;
use App\Models\solicitud\Temporal;
use App\Models\solicitud\Solicitud;
use App\Models\solicitud\BitacoraComision;
use App\Models\solicitud\RecorridoComision;
use App\Models\solicitud\SeguimientoSolicitud;
use App\Http\Traits\PreComisionTrait;


class ComisionController extends Controller
{
    use TemporalTrait, PreComisionTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $temporal_comision = $this->gettemporalbycomision();

        return view('theme.dashboard.layouts.index_bitacora_comision', compact('temporal_comision'));
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
        //iniciamos cargando los datos para hacer un guardado previo en la tabla temporal
        try {
            /**
             * obtener la id de pre_comision
             */
            $id_preComision = base64_decode($request->get('pre_comision_id'));
            //code...
            $temporal_id = $this->save_temporal($request);
            /**
             * modificacar la pre_comision - actualizar registros de la precomisión con id
             */
            $this->updatePreComision($id_preComision);
            /**
             * trabajamos con el primer bucle
             */
            foreach ($request->addcomision as $key => $value) {
                # vamos a insertar en la comisión -  recorrido
                $recorrido = new RecorridoComisionTemporal();
                $recorrido->fecha_comision = $value['fecha_comision'];
                $recorrido->de_comision = $value['de_comision'];
                $recorrido->a_comision = $value['a_comision'];
                $recorrido->temporal_id = $temporal_id;
                // guardar el registro
                $recorrido->save();
            }
            /**
             * segundo bucle - vamos a trabajar en guardar los registros
             */
            foreach ($request->addcomisiones as $k => $val) {
                # vamos a insertar en bitacora comision temporal
                $bitacora_temporal = new BitacoraComisionTemporal();
                $bitacora_temporal->factura_comision = $val['factura'];
                $bitacora_temporal->litros_comision = $val['litros'];
                $bitacora_temporal->precio_unitario_comision = $val['pu'];
                $bitacora_temporal->importe_comision = $val['importe'];
                $bitacora_temporal->temporal_id = $temporal_id;

                // guardando el resgistro
                $bitacora_temporal->save();
            }
            /**
             * se hace una redirección
             */
            return redirect()->route('pre.comision.index')->with('success', 'BITÁCORA DE COMISIÓN AGREGADA ÉXITOSAMENTE!');
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
        $idtemporalComision = base64_decode($id);
        /**
         * se realiza la consulta
         */
        $qryComisionTmp = Temporal::select('temporal.id', 'temporal.catalogo_vehiculo_id', 'temporal.directorio_id', 'temporal.memorandum_comision',
        'temporal.fecha', 'temporal.periodo', 'temporal.km_inicial', 'temporal.conductor', 'temporal.nombre_elabora', 'temporal.puesto_elabora',
        'temporal.titular_departamento', 'temporal.total_km_recorridos', 'temporal.status_proceso', 'temporal.periodo_actual', 'temporal.anio_actual',
        'temporal.litros_totales', 'temporal.importe_total', 'temporal.users_id', 'temporal.tipo_solicitud', 'temporal.rendimiento_litros', 'temporal.es_comision',
        'catalogo_vehiculo.color', 'catalogo_vehiculo.numero_motor', 'catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo', 'catalogo_vehiculo.tipo', 'catalogo_vehiculo.placas',
        'catalogo_vehiculo.numero_serie', 'catalogo_vehiculo.linea', 'catalogo_vehiculo.placas', 'temporal.observacion',
        'resguardante.resguardante_unidad', 'resguardante.puesto_resguardante_unidad', 'temporal.km_final_antes_cargar_combustible')
        ->leftjoin('catalogo_vehiculo', 'temporal.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
        ->leftjoin('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')
        ->where(
            [
                ['temporal.users_id', '=', auth()->id()],
                ['temporal.enviado', '=', false],
                ['temporal.es_comision', '=', true],
                ['temporal.id', '=', $idtemporalComision]
            ]
        )
        ->first();
        /**
         * obtenemos la información de otras tablas para enviarlo a la plantilla
         */
        $recorrido_comision_tmp = RecorridoComisionTemporal::where('temporal_id', $idtemporalComision)->get();
        $bitacora_comision_tmp = BitacoraComisionTemporal::where('temporal_id', $idtemporalComision)->get();

        return view('theme.dashboard.forms.form_edit_comision', compact('qryComisionTmp', 'recorrido_comision_tmp', 'bitacora_comision_tmp', 'idtemporalComision'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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

    protected function precomision()
    {
        $getprecomision = $this->getPreComision();
        return view('theme.dashboard.layouts.index_pre_comision', compact('getprecomision'));
    }

    protected function comisionupdate(Request $request)
    {
        try {
            //aquí vamos a cargar el registro
            switch ($request->get('ejecutar')) {
                case 'update':
                    $comision_id = base64_decode($request->get('comision_id'));
                    # actualizar registros
                    Temporal::where('id', $comision_id)->update([
                        'catalogo_vehiculo_id' => $request->get('idcatvehiculo'),
                        'memorandum_comision' => $request->get('memo_comision'),
                        'fecha' => Str::upper($request->get('fecha_comision')),
                        'periodo' => Str::upper($request->get('periodo_comision')),
                        'km_inicial' => $request->get('kmInicial'),
                        'km_final_antes_cargar_combustible' => $request->get('kmFinal'),
                        'conductor' => Str::upper($request->get('nombreConductor')),
                        'periodo_actual' => Str::upper($request->get('periodo_comision_actual')),
                        'litros_totales' => $request->get('litros_totales'),
                        'total_km_recorridos' => $request->get('km_totales'),
                        'importe_total' => $request->get('importe_total'),
                        'users_id' => Auth::user()->id,
                        'observacion' => Str::upper($request->get('observaciones')),
                    ]);

                    /**
                     * eliminar las bitácoras temporales - para poder cargar nuevamente en el bucle
                     */

                    /**
                     * trabajaremos en un bucle para guardar información en otra tabla
                    */
                    BitacoraComisionTemporal::where('temporal_id', $comision_id)->delete();
                    foreach ($request->addcomisiones as $key => $value) {
                        # vamos a insertar en bitacora comision temporal
                        $bitacora_temporal = new BitacoraComisionTemporal;
                        $bitacora_temporal->factura_comision = $value['factura'];
                        $bitacora_temporal->litros_comision = $value['litros'];
                        $bitacora_temporal->precio_unitario_comision = $value['pu'];
                        $bitacora_temporal->importe_comision = $value['importe'];
                        $bitacora_temporal->temporal_id = $comision_id;

                        // guardando el resgistro
                        $bitacora_temporal->save();  
                    }
                    RecorridoComisionTemporal::where('temporal_id', $comision_id)->delete();
                    foreach ($request->addcomision as $k => $val) {
                        # vamos a insertar en la comisión -  recorrido
                        $recorrido = new RecorridoComisionTemporal;
                        $recorrido->fecha_comision = $val['fecha_comision'];
                        $recorrido->de_comision = $val['de_comision'];
                        $recorrido->a_comision = $val['a_comision'];
                        $recorrido->temporal_id = $comision_id;
                        // guardar el registro
                        $recorrido->save();
                    }

                    // retornar a el objeto
                    return redirect()->route('comision.pre.guardado', base64_encode($comision_id))->with('success', 'COMISIÓN MODIFICADA ÉXITOSAMENTE!');
                    break;
                case 'send':
                    $comision_id = base64_decode($request->get('comision_id'));
                    # enviar registros - se tiene que hacer un update
                    /**
                     * insertar a la base de datos
                     */
                    /**
                     * obtenemos la fecha actual con el método carbon
                    */
                    $fecha_actual = Carbon::now();
                    $anio = $fecha_actual->year;
                    /**
                     * obtener el año de la solicitud de la bitácora
                     */
                    $fecha_solicitud = Carbon::parse($request->get('fecha_comision'));
                    $anio_solicitud = $fecha_solicitud->year;

                    $solicitud = new Solicitud;
                    $solicitud->catalogo_vehiculo_id = $request->get('idcatvehiculo');
                    // $solicitud->directorio_id = $request->get('');
                    $solicitud->fecha = $request->get('fecha_comision');
                    $solicitud->periodo = Str::upper($request->get('periodo_comision'));
                    $solicitud->km_inicial = $request->get('kmInicial');
                    $solicitud->nombre_elabora = Str::upper(Auth::user()->name);
                    $solicitud->puesto_elabora = Str::upper(Auth::user()->puesto);
                    $solicitud->conductor = Str::upper($request->get('nombreConductor'));
                    $solicitud->anio_actual = $anio;
                    $solicitud->periodo_actual = Str::upper($request->get('periodo_comision_actual'));
                    $solicitud->litros_totales = $request->get('litros_totales');
                    $solicitud->anio_solicitud = $anio_solicitud;
                    $solicitud->memorandum_comision = Str::upper($request->get('memo_comision'));
                    $solicitud->km_final_antes_cargar_combustible = $request->get('kmFinal');
                    // $solicitud->km_inicial_cargar_combustible = $request->get('');
                    $solicitud->total_km_recorridos = $request->get('km_totales');
                    $solicitud->importe_total = $request->get('importe_total');
                    // $solicitud->numero_economico = $request->get('');
                    $solicitud->status_proceso = true;
                    $solicitud->users_id = Auth::user()->id;
                    $solicitud->tipo_solicitud = 2;
                    // guardar registros y obteneer el último id
                    $solicitud->observacion = Str::upper($request->get('observaciones'));
                    $solicitud->es_comision = true;
                    $solicitud->save();
                    $lastId = $solicitud->id;

                    /**
                     * actualizamos el registro en el sistema por generación de los temporales
                    */
                    Temporal::where('id', $comision_id)
                    ->update(['enviado' => true]);

                    /**
                     * se guarda la información seguimiento_solicitud se guarda el registro
                    */
                    $seguimientoSolicitud = new SeguimientoSolicitud;
                    $seguimientoSolicitud->solicitud_id = $lastId;
                    $seguimientoSolicitud->status_seguimiento_id = 1;
                    $seguimientoSolicitud->fecha_inicio = Carbon::now();
                    $seguimientoSolicitud->save();
                    
                    /**
                     * bucles para cargar datos
                     */
                    foreach ($request->addcomision as $key => $value) {
                        # entramos en el bucle - addcomision -- recorrido_comision
                        $recorridoComision = new RecorridoComision();
                        $recorridoComision->fecha_comision = $value['fecha_comision'];
                        $recorridoComision->de_comision = $value['de_comision'];
                        $recorridoComision->a_comision = $value['a_comision'];
                        $recorridoComision->solicitud_id = $lastId;
                        $recorridoComision->save();

                        if (!empty($value['recorrido_comision_id'])) {
                            # code...
                            RecorridoComisionTemporal::where('id', $value['recorrido_comision_id'])
                            ->update(['enviado' => true]);
                        }
                    }
                    /**
                     * generar otro bucle
                     */
                    foreach ($request->addcomisiones as $k => $val) {
                        # entramos en el bucle -- bitacora_comision
                        $bitacoraComision = new BitacoraComision();
                        $bitacoraComision->factura_comision = $val['factura'];
                        $bitacoraComision->litros_comision = $val['litros'];
                        $bitacoraComision->precio_unitario_comision = $val['pu'];
                        $bitacoraComision->importe_comision = $val['importe'];
                        $bitacoraComision->solicitud_id = $lastId;
                        $bitacoraComision->save();

                        if (!empty($value['recorrido_comision_id'])) {
                            # code...
                            BitacoraComisionTemporal::where('id', $val['bitacora_comision_id'])
                            ->update(['enviado' => true]);
                        }
                        
                    }
                    /**
                     * después dé insertar la información lo que hacemos será redireccionar
                     */
                        return redirect()->route('solicitud.bitacora.comision.index')->with('success', 'COMISIÓN ENVIADA ÉXITOSAMENTE.');
                    break;
            }
        } catch (QueryException $e) {
            //throw $e enviar excepcion;
            return back()->with('error', $e->getMessage());
        }
    }

    protected function comisioncreatepre(){
        $array_rendimiento = array(
            'rendimiento_carretera' => 'CARRETERA',
            'rendimiento_ciudad' => 'CIUDAD',
            'rendimiento_mixto' => 'MIXTO',
            'rendimiento_carga' => 'CARGA',
        );
        return view('theme.dashboard.forms.form_pre_comision', compact('array_rendimiento'));
    }
}
