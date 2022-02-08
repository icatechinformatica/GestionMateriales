<?php
/**
 * DESARROLLADO POR MIS. DANIEL MÉNDEZ CRUZ - SEPTIEMBRE 2021
 */
namespace App\Http\Controllers\solicitud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\solicitud\Solicitud;
use App\Models\solicitud\CatalogoVehiculo;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use App\Models\solicitud\Bitacora;
use App\Models\solicitud\SeguimientoSolicitud;
use App\Models\solicitud\BitacoraTemporal;
use App\Models\solicitud\Temporal;
use App\Http\Traits\LogTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\Solicitud\Chofer;
use Illuminate\Support\Str;
use App\Models\solicitud\BitacoraComision;
use App\Models\solicitud\RecorridoComision;

class SolicitudBitacoraController extends Controller
{
    use LogTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //
        $userId = auth()->id();
        $usuario = auth()->user();
        if ($usuario->hasRole('revisor') === true) {
            # parte de la consulta con role de revisor
            $query = [
                ['seguimiento_solicitud.status_seguimiento_id', '!=', 5]
            ];
        } elseif ($usuario->hasRole('capturista') === true) {
            # parte de la consulta con el rol de capturista
            $query = [
                ['solicitud.users_id', '=', $userId],
                ['seguimiento_solicitud.status_seguimiento_id', '!=', 5]
            ];
        }
        $solicitud = Solicitud::select('solicitud.fecha', 'solicitud.periodo', 
        'solicitud.numero_factura_compra', 'solicitud.id',
        'solicitud.status_proceso', 'catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo',
        'catalogo_vehiculo.tipo', 'catalogo_vehiculo.placas', 'seguimiento_status.estado', 'seguimiento_solicitud.status_seguimiento_id')
                ->leftjoin('catalogo_vehiculo', 'solicitud.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
                ->leftjoin('seguimiento_solicitud', 'solicitud.id', '=', 'seguimiento_solicitud.solicitud_id')
                ->leftjoin('seguimiento_status', 'seguimiento_solicitud.status_seguimiento_id', '=', 'seguimiento_status.id')
                ->where($query)->get();
        return view('theme.dashboard.layouts.solicitud_bitacora_index', compact('solicitud'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /**
         * petición de la solicitud
         */
        $fecha = Carbon::now()->format('Y-m-d');
        $hora = Carbon::now()->format('H:i:s');
        // $MAC = exec('getmac');
        // $MAC = strtok($MAC, ' ');
        $tipo_peticion = 'GET';
        $path = '/solicitud/create';
        $peticion = ['operacion' => 'Agregar una nueva solicitud de bitácora de rendimiento', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 3, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);
        /**
         * programar el mes actual - del periodo
         */
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::now();
        $anio_actual = $fecha->year;
        $mes = $meses[($fecha->format('n')) - 1];
        // enviar una vista a un formulario
        return view('theme.dashboard.forms.solicitud_bitacora_form', compact('mes', 'anio_actual'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'memo_comision' => 'required|max:255',
            // 'fecha' => 'date',
            'placas' => 'required|max:70',
            '_kilometroInicial' => 'required'

        ],[
            // 'memo_comision.required' => 'El memo de comisión es requerido',
            // 'fecha.date' => 'Se requiere una fecha valida',
            'placas.required' => 'Las placas son requeridos',
            '_kilometroInicial.required' => 'El kilometro incial es requerido'
        ]);
        // vamos a hacer un try catch
        try {
            /**
             * petición de la solicitud
             */
            $fecha = Carbon::now()->format('Y-m-d');
            $hora = Carbon::now()->format('H:i:s');
            // $MAC = exec('getmac');
            // $MAC = strtok($MAC, ' ');
            $tipo_peticion = 'POST';
            $path = '/solicitud/store';
            $peticion_parcial =  (array)$request->all();
            $solicitud_total = json_encode($peticion_parcial);
            $peticion = ['operacion' => 'Agregar una bitácora de rendimiento nueva', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 4, 'tipo_peticion' => $tipo_peticion, 'httpRequest' => $solicitud_total];
            $this->storeLog($peticion);
            /**
             * obtenemos la fecha actual con el método carbon
             */
            $fecha_actual = Carbon::now();
            $anio = $fecha_actual->year;
            //parte de código dónde vamos a realizar el proceso de guardado en la base de datos
            /**
             * insertar a la base de datos
             */
            $solicitud_model = new Temporal;
            $solicitud_model->catalogo_vehiculo_id = $request->get('idcatvehiculo');
            // $solicitud_model->directorio_id = $request->get('');
            $solicitud_model->fecha = Str::upper($request->get('fecha'));
            $solicitud_model->periodo = Str::upper($request->get('periodo'));
            $solicitud_model->km_inicial = Str::upper($request->get('_kilometroInicial'));
            $solicitud_model->numero_factura_compra = Str::upper($request->get('no_factura_compra'));
            $solicitud_model->nombre_elabora = Auth::user()->name;
            $solicitud_model->puesto_elabora = Auth::user()->puesto;
            $solicitud_model->conductor = Str::upper($request->get('nombreConductor'));
            $solicitud_model->anio_actual = $anio;
            $solicitud_model->periodo_actual = Str::upper($request->get('periodo_actual'));
            $solicitud_model->litros_totales = $request->get('litros_totales');
            $solicitud_model->total_km_recorridos = $request->get('km_totales');
            $solicitud_model->importe_total = $request->get('importe_total');
            $solicitud_model->status_proceso = true;
            $solicitud_model->users_id = Auth::user()->id;
            // guardar registros y obteneer el último id
            $solicitud_model->save();
            $lastId = $solicitud_model->id;
            /**
             * trabajaremos en un bucle para guardar información en otra tabla
             */
            foreach ($request->agregarItem as $key => $value) {
                # entramos en el bucle
                $bitacora = new BitacoraTemporal();
                $bitacora->fecha = $value['fecha_bitacora'];
                $bitacora->kilometraje_inicial = $value['kminicial'];
                $bitacora->kilometraje_final = $value['kmfinal'];
                $bitacora->litros = $value['litros'];
                $bitacora->division_vale = $value['dv'];
                $bitacora->importe = $value['importe'];
                $bitacora->actividad_inicial = $value['de'];
                $bitacora->actividad_final = $value['a'];
                $bitacora->vales = $value['vales'];
                $bitacora->solicitud_id = $lastId;
                // guardar el registro
                $bitacora->save();
            }
            /**
             * después dé insertar la información lo que hacemos será redireccionar
             */
            return redirect()->route('solicitud.bitacora.previo.guardado')->with('success', 'BITÁCORA DE RECORRIDO AGREGADA ÉXITOSAMENTE!');
        } catch (QueryException $th) {
            //cachando excepcion y retornando a la vista
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
        $idSolicitud = base64_decode($id);
        /**
         * solicitud
         */
        $solicitud_detalle = Solicitud::select('solicitud.fecha', 'solicitud.periodo', 
        'solicitud.numero_factura_compra', 'solicitud.id',
        'solicitud.status_proceso', 'catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo',
        'catalogo_vehiculo.tipo', 'catalogo_vehiculo.placas', 'seguimiento_status.estado', 'catalogo_vehiculo.color', 'catalogo_vehiculo.numero_motor',
        'catalogo_vehiculo.linea', 'catalogo_vehiculo.importe_combustible', 
        'catalogo_vehiculo.numero_serie', 'solicitud.km_inicial', 'solicitud.conductor', 
        'resguardante.resguardante_unidad', 'resguardante.puesto_resguardante_unidad', 'solicitud.litros_totales', 
        'solicitud.importe_total', 'solicitud.total_km_recorridos', 'solicitud.observacion')
                ->leftjoin('catalogo_vehiculo', 'solicitud.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
                ->leftjoin('seguimiento_solicitud', 'solicitud.id', '=', 'seguimiento_solicitud.solicitud_id')
                ->leftjoin('seguimiento_status', 'seguimiento_solicitud.status_seguimiento_id', '=', 'seguimiento_status.id')
                ->leftjoin('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')
                ->where('solicitud.id', $idSolicitud)->first();
        /**
         * solicitud Bitácora que está vinculado a la solicitud
         */
        $bitacora_recorrido = Bitacora::where('solicitud_id', $idSolicitud)->get();
        return view('theme.dashboard.layouts.detalle_solicitud', compact('solicitud_detalle', 'bitacora_recorrido'));
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete(Request $request)
    {
        $data = CatalogoVehiculo::select("placas")
                ->where("placas","LIKE","%{$request->term}%")
                ->get();
                
        $array_ = array();
        foreach ($data as $hsl)
        {
            $array_[] = $hsl->placas;
        }
   
        return response()->json($array_);
    }

    public function loaddata(Request $request)
    {
        $datos = CatalogoVehiculo::select("catalogo_vehiculo.id", 'catalogo_vehiculo.color', 
        'catalogo_vehiculo.numero_motor', 
        'catalogo_vehiculo.marca', 
        'catalogo_vehiculo.modelo', 'catalogo_vehiculo.rendimiento_ciudad',
        'catalogo_vehiculo.rendimiento_carretera', 'catalogo_vehiculo.rendimiento_mixto',
        'catalogo_vehiculo.rendimiento_carga',
        'catalogo_vehiculo.tipo', 'catalogo_vehiculo.numero_serie', 'catalogo_vehiculo.placas', 'catalogo_vehiculo.linea',
        'catalogo_vehiculo.importe_combustible', 'resguardante.resguardante_unidad', 'resguardante.puesto_resguardante_unidad', 'catalogo_vehiculo.numero_economico')
            ->join('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')
            ->where("catalogo_vehiculo.placas","=", $request->type)
            ->get();

        return response()->json($datos);
    }

    protected function revisionIndex(Request $request)
    {
        /**
         * petición de la solicitud
         */
        $fecha = Carbon::now()->format('Y-m-d');
        $hora = Carbon::now()->format('H:i:s');
        // $MAC = exec('getmac');
        // $MAC = strtok($MAC, ' ');
        $tipo_peticion = 'GET';
        $path = '/solicitud/bitacora/revision/index';
        $peticion = ['operacion' => 'Revisión de Bitácora indice', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 2, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);
        /**
         * programar el mes actual - del periodo
         */
        $meses = array("Enero" => 1, "Febrero" => 2, "Marzo" => 3,"Abril" => 4, "Mayo" => 5, "Junio" => 6, "Julio" => 7, "Agosto" => 8, "Septiembre" => 9, "Octubre" => 10 , "Noviembre" => 11, "Diciembre" => 12);
        // $fecha = Carbon::now();
        // $anio_actual = $fecha->year;
        // $mes = $meses[($fecha->format('n')) - 1];
        // $mes_numero = $fecha->month;

        $solicitudRevision = Solicitud::select('solicitud.fecha', 'solicitud.periodo', 
        'solicitud.numero_factura_compra', 'solicitud.id',
        'solicitud.status_proceso', 'catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo',
        'catalogo_vehiculo.tipo', 'catalogo_vehiculo.placas', 'seguimiento_status.estado', 'solicitud.es_comision')
            ->leftjoin('catalogo_vehiculo', 'solicitud.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
            ->leftjoin('seguimiento_solicitud', 'solicitud.id', '=', 'seguimiento_solicitud.solicitud_id')
            ->leftjoin('seguimiento_status', 'seguimiento_solicitud.status_seguimiento_id', '=', 'seguimiento_status.id')
            ->where('seguimiento_solicitud.status_seguimiento_id', '!=', 5)
            ->get();
        return view('theme.dashboard.layouts.solicitud_revision_bitacora', compact('solicitudRevision', 'meses'));
    }

    /**
     * revisión detalle
     */
    protected function revisionDetalle(Request $request, $id)
    {
        /**
         * petición de la solicitud
         */
        $fecha = Carbon::now()->format('Y-m-d');
        $hora = Carbon::now()->format('H:i:s');
        // $MAC = exec('getmac');
        // $MAC = strtok($MAC, ' ');
        $tipo_peticion = 'GET';
        $path = '/solicitud/revision/detail/'.$id;
        $peticion = ['operacion' => 'Revisión de Bitácora de Recorrido final', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 2, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);
        /**
         * 
         */
        $idSol = base64_decode($id);
        $solicitud_por_id = Solicitud::select('solicitud.fecha', 
                'solicitud.periodo', 
                'solicitud.km_inicial', 
                'solicitud.numero_factura_compra', 
                'solicitud.periodo_actual', 
                'solicitud.anio_actual', 'catalogo_vehiculo.color',
                'solicitud.conductor',
                'catalogo_vehiculo.numero_motor', 
                'catalogo_vehiculo.marca',
                'catalogo_vehiculo.modelo', 
                'catalogo_vehiculo.tipo', 'catalogo_vehiculo.placas', 'catalogo_vehiculo.numero_serie',
                'catalogo_vehiculo.linea', 'catalogo_vehiculo.importe_combustible', 'resguardante.resguardante_unidad',
                'resguardante.puesto_resguardante_unidad', 
                'solicitud.litros_totales', 'solicitud.importe_total',
                'solicitud.total_km_recorridos', 'solicitud.status_proceso', 'solicitud.id', 'solicitud.catalogo_vehiculo_id', 'solicitud.observacion')
                ->leftjoin('seguimiento_solicitud', 'solicitud.id', '=', 'seguimiento_solicitud.solicitud_id')
                ->leftjoin('seguimiento_status', 'seguimiento_solicitud.status_seguimiento_id', '=', 'seguimiento_status.id')
                ->leftjoin('catalogo_vehiculo', 'solicitud.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
                ->leftjoin('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')
                ->where('solicitud.id', '=', $idSol)->first();

        $recorrido_bitacora = Bitacora::where('solicitud_id', $idSol)->get();
        // dd($recorrido_bitacora);
        return view('theme.dashboard.forms.revision_bitacora_form', compact('solicitud_por_id', 'recorrido_bitacora', 'idSol'));
    }

    /**
     * solicitud guardado previamente
     */
    protected function indexsolicitudprevia(Request $request)
    {
        /**
         * petición de la solicitud
         */
        $fecha = Carbon::now()->format('Y-m-d');
        $hora = Carbon::now()->format('H:i:s');
        // $MAC = exec('getmac');
        // $MAC = strtok($MAC, ' ');
        $tipo_peticion = 'GET';
        $path = '/solicitud/previo/index';
        $peticion = ['operacion' => 'solicitudes de bitácora guardadas previamente indice', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 2, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);
        /**
         * registro normal
         */
        $userId = auth()->id();
        $nombre_usuario = auth()->user()->name;
        $solicitud = Temporal::select('temporal.fecha', 'temporal.periodo', 
        'temporal.numero_factura_compra', 'temporal.id',
        'temporal.status_proceso', 'catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo',
        'catalogo_vehiculo.tipo', 'catalogo_vehiculo.placas', 'temporal.nombre_elabora')
                ->leftjoin('catalogo_vehiculo', 'temporal.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
                ->where([
                    ['temporal.users_id', '=', $userId],
                    ['temporal.enviado', '=', false]
                ])->get();

        return view('theme.dashboard.layouts.bitacora_pre_guardadas', compact('solicitud', 'nombre_usuario'));
    }

    /**
     * función de solicitud - pre guardado
     */
    protected function preguardado(Request $request, $id)
    {
        /**
         * petición de la solicitud
         */
        $fecha = Carbon::now()->format('Y-m-d');
        $hora = Carbon::now()->format('H:i:s');
        // $MAC = exec('getmac');
        // $MAC = strtok($MAC, ' ');
        $tipo_peticion = 'GET';
        $path = '/solicitud/detalle/pre-guardado/'.$id;
        $peticion = ['operacion' => 'Detalle de la solicitud pre-guardada', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 3, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);

        $idSolPre = base64_decode($id);
        $solicitud_pre_id = Temporal::select('temporal.fecha', 
                'temporal.periodo', 
                'temporal.km_inicial', 
                'temporal.numero_factura_compra', 
                'temporal.periodo_actual', 
                'temporal.anio_actual', 'catalogo_vehiculo.color',
                'temporal.conductor',
                'catalogo_vehiculo.numero_motor', 
                'catalogo_vehiculo.marca',
                'catalogo_vehiculo.modelo', 
                'catalogo_vehiculo.tipo', 'catalogo_vehiculo.placas', 'catalogo_vehiculo.numero_serie',
                'catalogo_vehiculo.linea', 'catalogo_vehiculo.importe_combustible', 'resguardante.resguardante_unidad',
                'resguardante.puesto_resguardante_unidad', 
                'temporal.litros_totales', 'temporal.importe_total',
                'temporal.total_km_recorridos', 'temporal.id', 'temporal.catalogo_vehiculo_id')
                ->leftjoin('catalogo_vehiculo', 'temporal.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
                ->leftjoin('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')
                ->where([
                    ['temporal.id', '=', $idSolPre],
                    ['temporal.enviado', '=', false]
                ])->first();

                $bitacora_temporal = BitacoraTemporal::where([
                    ['solicitud_id', '=' ,$idSolPre],
                    ['enviado', '=', false]
                ])->get();
                return view('theme.dashboard.forms.bitacora_pre_save', compact('solicitud_pre_id', 'bitacora_temporal'));
    }

    /**
     * modificaciones -- 
     */

    protected function storeBitacora(Request $request)
    {
        $request->validate([
            // 'memo_comision' => 'required|max:255',
            // 'fecha' => 'date',
            'placas' => 'required|max:70',
            '_kilometroInicial' => 'required'

        ],[
            // 'memo_comision.required' => 'El memo de comisión es requerido',
            // 'fecha.date' => 'Se requiere una fecha valida',
            'placas.required' => 'Las placas son requeridos',
            '_kilometroInicial.required' => 'El kilometro incial es requerido'
        ]);
        // vamos a hacer un try catch
        try {

            switch ($request->get('ejecutar')) {
                case 'save':
                        # guardar registros al momento de ejecutar el post
                        $bitacora_id = base64_decode($request->get('bitacora_id'));
                        /**
                         * obtener el año de la solicitud de la bitácora
                         */
                        $fecha_solicitud = Carbon::parse($request->get('fecha'));
                        $anio_solicitud = $fecha_solicitud->year;
                        /**
                         * petición de la solicitud 
                        */
                        $fecha = Carbon::now()->format('Y-m-d');
                        $hora = Carbon::now()->format('H:i:s');
                        // $MAC = exec('getmac');
                        // $MAC = strtok($MAC, ' ');
                        $tipo_peticion = 'POST';
                        $path = '/solicitud/pre/store';
                        $peticion_parcial =  (array)$request->all();
                        $solicitud_total = json_encode($peticion_parcial);
                        $peticion = ['operacion' => 'Actualizar el registro de la bitácora temporal', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 6, 'tipo_peticion' => $tipo_peticion, 'httpRequest' => $solicitud_total];
                        $this->storeLog($peticion);
                        /**
                         * se trabajará en la actualización de la tabla temporal ya que aún no se enviará hacía 
                         */
                        Temporal::where('id', $bitacora_id)->update([
                            'fecha' => $request->fecha,
                            'periodo' => $request->periodo,
                            'catalogo_vehiculo_id' => $request->idcatvehiculo,
                            'km_inicial' => $request->_kilometroInicial,
                            'numero_factura_compra' => $request->no_factura_compra,
                            'conductor' => $request->nombreConductor,
                            'nombre_elabora' => Auth::user()->name,
                            'anio_actual' => $anio_solicitud,
                            'periodo_actual' => $request->periodo_actual,
                            'litros_totales' => $request->litros_totales,
                            'total_km_recorridos' => $request->km_totales,
                            'importe_total' => $request->importe_total,
                            'puesto_elabora' => Auth::user()->puesto,
                            'users_id' => Auth::user()->id,
                        ]);
                        /**
                         * eliminar las bitácoras temporales - para poder cargar nuevamente en el bucle
                         */

                        /**
                         * trabajaremos en un bucle para guardar información en otra tabla
                        */
                        BitacoraTemporal::where('solicitud_id', $bitacora_id)->delete();
                        // se trabaja como un contador con la variable que contiene el arreglo de objetos
                        $numItems = count($request->agregarItem);
                        $k = 0;
                        foreach ($request->agregarItem as $key => $value) {
                            # entramos en el bucle
                            $temporalbitacora = new BitacoraTemporal();
                            $temporalbitacora->fecha = $value['fecha_bitacora'];
                            $temporalbitacora->kilometraje_inicial = $value['kminicial'];
                            $temporalbitacora->kilometraje_final = $value['kmfinal'];
                            $temporalbitacora->litros = $value['litros'];
                            $temporalbitacora->division_vale = $value['dv'];
                            $temporalbitacora->importe = $value['importe'];
                            $temporalbitacora->actividad_inicial = Str::upper($value['de']);
                            $temporalbitacora->actividad_final = Str::upper($value['a']);
                            $temporalbitacora->vales = $value['vales'];
                            $temporalbitacora->solicitud_id = $bitacora_id;
                            // guardar el registro
                            $temporalbitacora->save();
                        }

                        /**
                         * después dé insertar la información lo que hacemos será redireccionar
                        */
                        return redirect()->route('solicitud.bitacora.previo.guardado')->with('success', 'BITÁCORA DE RECORRIDO GUARDADA!');

                    break;
                case 'send':
                    # enviar los registros al momento de enviar a la tabla de solicitud
                        /**
                         * petición de la solicitud 
                        */
                        $fecha = Carbon::now()->format('Y-m-d');
                        $hora = Carbon::now()->format('H:i:s');
                        // $MAC = exec('getmac');
                        // $MAC = strtok($MAC, ' ');
                        $tipo_peticion = 'POST';
                        $path = '/solicitud/pre/store';
                        $peticion_parcial =  (array)$request->all();
                        $solicitud_total = json_encode($peticion_parcial);
                        $peticion = ['operacion' => 'Enviar registro de la bitacora de recorrido hacia la tabla solicitud', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 4, 'tipo_peticion' => $tipo_peticion, 'httpRequest' => $solicitud_total];
                        $this->storeLog($peticion);
                        /**
                         * obtenemos la fecha actual con el método carbon
                        */
                        $fecha_actual = Carbon::now();
                        $anio = $fecha_actual->year;
                        /**
                         * obtener el año de la solicitud de la bitácora
                         */
                        $fecha_solicitud = Carbon::parse($request->get('fecha'));
                        $anio_solicitud = $fecha_solicitud->year;
                        //parte de código dónde vamos a realizar el proceso de guardado en la base de datos
                        /**
                         * insertar a la base de datos
                        */
                        $solicitud_model = new Solicitud;
                        $solicitud_model->catalogo_vehiculo_id = $request->get('idcatvehiculo');
                        // $solicitud_model->directorio_id = $request->get('');
                        $solicitud_model->fecha = $request->get('fecha');
                        $solicitud_model->periodo = Str::upper($request->get('periodo'));
                        $solicitud_model->km_inicial = $request->get('_kilometroInicial');
                        $solicitud_model->numero_factura_compra = Str::upper($request->get('no_factura_compra'));
                        $solicitud_model->nombre_elabora = Str::upper(Auth::user()->name);
                        $solicitud_model->puesto_elabora = Str::upper(Auth::user()->puesto);
                        $solicitud_model->conductor = Str::upper($request->get('nombreConductor'));
                        $solicitud_model->anio_actual = $anio;
                        $solicitud_model->periodo_actual = Str::upper($request->get('periodo_actual'));
                        $solicitud_model->litros_totales = $request->get('litros_totales');
                        $solicitud_model->anio_solicitud = $anio_solicitud;
                        // $solicitud_model->km_final_antes_cargar_combustible = $request->get('');
                        // $solicitud_model->km_inicial_cargar_combustible = $request->get('');
                        $solicitud_model->total_km_recorridos = $request->get('km_totales');
                        $solicitud_model->importe_total = $request->get('importe_total');
                        // $solicitud_model->numero_economico = $request->get('');
                        $solicitud_model->status_proceso = true;
                        $solicitud_model->users_id = Auth::user()->id;
                        // guardar registros y obteneer el último id
                        $solicitud_model->observacion = Str::upper($request->get('observaciones'));
                        $solicitud_model->save();
                        $lastId = $solicitud_model->id;

                        /**
                         * actualizamos el registro en el sistema por generación de los temporales
                        */
                        Temporal::where('id', base64_decode($request->get('bitacora_id')))
                        ->update(['enviado' => true]);
                        /**
                         * se guarda la información seguimiento_solicitud se guarda el registro
                        */
                        $seguimientoSolicitud = new SeguimientoSolicitud;
                        $seguimientoSolicitud->solicitud_id = $lastId;
                        $seguimientoSolicitud->status_seguimiento_id = 2;
                        $seguimientoSolicitud->fecha_inicio = Carbon::now();
                        $seguimientoSolicitud->save();
                        /**
                         * trabajaremos en un bucle para guardar información en otra tabla
                        */
                        // se trabaja como un contador con la variable que contiene el arreglo de objetos
                        $numItems = count($request->agregarItem);
                        $k = 0;
                        foreach ($request->agregarItem as $key => $value) {
                            # entramos en el bucle
                            $bitacora = new Bitacora();
                            $bitacora->fecha = $value['fecha_bitacora'];
                            $bitacora->kilometraje_inicial = $value['kminicial'];
                            $bitacora->kilometraje_final = $value['kmfinal'];
                            $bitacora->litros = $value['litros'];
                            $bitacora->division_vale = $value['dv'];
                            $bitacora->importe = $value['importe'];
                            $bitacora->actividad_inicial = Str::upper($value['de']);
                            $bitacora->actividad_final = Str::upper($value['a']);
                            $bitacora->vales = $value['vales'];
                            $bitacora->solicitud_id = $lastId;
                            // guardar el registro
                            $bitacora->save();

                            if (++$k === $numItems) {
                                # último indice ahora vamos a actualizar un registro
                                Solicitud::where('id', $lastId)
                                ->update(['km_final_antes_cargar_combustible' => $value['kmfinal']]);
                            }

                            if (!empty($value['bitacora_temp_id'])) {
                                # code...
                                BitacoraTemporal::where('id', $value['bitacora_temp_id'])
                                ->update(['enviado' => true]);
                            }
                        }
                        /**
                         * después del recorrido del bucle se necesita obtener el km_final_antes_cargar_combustible para la tabla catalogo_vehiculo
                         */
                        $catVehiculo = CatalogoVehiculo::where('id', $request->get('idcatvehiculo'))->first();
                        if (is_null($catVehiculo->km_final)) {
                            # si es nulo vamos a obtener los valores de los km iniciales
                            $kmFinal = $catVehiculo->km_inicial + $request->get('km_totales');
                            CatalogoVehiculo::where('id', $request->get('idcatvehiculo'))->update([ 'km_final' => $kmFinal ]);
                        } else {
                            # si no es nulo vamos a obtener el km final y agregar los km totales
                            $kmFinal = $catVehiculo->km_final + $request->get('km_totales');
                            CatalogoVehiculo::where('id', $request->get('idcatvehiculo'))->update([ 'km_final' => $kmFinal ]);
                        }
                        /**
                         * después dé insertar la información lo que hacemos será redireccionar
                         */
                        return redirect()->route('solicitud.bitacora.index')->with('success', 'BITÁCORA DE RECORRIDO AGREGADA ÉXITOSAMENTE.');
                    break;
                default:
                    # code...
                    break;
            }

        } catch (QueryException $th) {
            //cachando excepcion y retornando a la vista
            return back()->with('error', $th->getMessage());
        }
    }

    protected function getreview(Request $request, $review)
    {
        $idrevision = base64_decode($review);
        try {
            /**
             * petición de la solicitud 
             */
            $fecha = Carbon::now()->format('Y-m-d');
            $hora = Carbon::now()->format('H:i:s');
            // $MAC = exec('getmac');
            // $MAC = strtok($MAC, ' ');
            $tipo_peticion = 'GET';
            $path = '/solicitud/bitacora/revision/'.$review;
            $peticion = ['operacion' => 'Activar Revisión de la Bitácora', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 5, 'tipo_peticion' => $tipo_peticion];
            $this->storeLog($peticion);
            //hacemos un update a la tabla Solicitud
            Solicitud::where('id', $idrevision)->update(['status_proceso' => 3]);
            //ahora actualizamos también
            SeguimientoSolicitud::where('solicitud_id', $idrevision)->update(['status_seguimiento_id' => 3]);
            // redireccionar
            return redirect()->route('revision.bitacora.detalle', ['id' => base64_encode($idrevision)]);
        } catch (QueryException $th) {
            // redireccionamos con errores - redirección de vuelta
            return back()->with('error', $th->getMessage());
        }
    }

    protected function done(Request $request)
    {
        $solicitud = base64_decode($request->solicitud_id);
        try {
            // /solicitud/bitacora/terminar
            /**
             * petición de la solicitud 
             */
            $fecha = Carbon::now()->format('Y-m-d');
            $hora = Carbon::now()->format('H:i:s');
            // $MAC = exec('getmac');
            // $MAC = strtok($MAC, ' ');
            $tipo_peticion = 'POST';
            $path = '/solicitud/bitacora/terminar';
            $peticion_parcial =  (array)$request->all();
            $solicitud_total = json_encode($peticion_parcial);
            $peticion = ['operacion' => 'Terminar Bitácora de recorrido y enviar a firma', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 4, 'tipo_peticion' => $tipo_peticion, 'httpRequest' => $solicitud_total];
            $this->storeLog($peticion);
            // hacemos un update en la tabla solicitud con el estado del proceso
             /**
             * obtenemos la fecha actual con el método carbon
             */
            $factual = Carbon::now();
            $anioactual = $factual->year;

            Solicitud::where('id', $solicitud)->update([
                'status_proceso' => 5,
                'fecha' => $request->fecha,
                'periodo' => $request->periodo,
                'catalogo_vehiculo_id' => $request->catalogo_vehiculo_id,
                'km_inicial' => $request->_kilometroInicial,
                'numero_factura_compra' => $request->no_factura_compra,
                'conductor' => $request->nombreConductor,
                'nombre_elabora' => Auth::user()->name,
                'anio_actual' => $anioactual,
                'periodo_actual' => $request->periodo_actual,
                'litros_totales' => $request->litros_totales,
                'total_km_recorridos' => $request->km_totales,
                'importe_total' => $request->importe_total,
                'observacion' => $request->observaciones,
                'puesto_elabora' => Auth::user()->puesto,
                'users_id' => Auth::user()->id,
            ]);


            /**
             * borrar contenido de la tabla solicitud_bitacora
             */
            foreach ($request->agregarItem as $key => $value) {
                # entramos en un bucle que hace agregar nuevamente los datos
                $sol_bitacora = Bitacora::findOrfail($value['id']);
                $sol_bitacora->fecha = $value['fecha_bitacora'];
                $sol_bitacora->kilometraje_inicial = $value['kminicial'];
                $sol_bitacora->kilometraje_final = $value['kmfinal'];
                $sol_bitacora->litros = $value['litros'];
                $sol_bitacora->division_vale = $value['dv'];
                $sol_bitacora->importe = $value['importe'];
                $sol_bitacora->actividad_inicial = $value['de'];
                $sol_bitacora->actividad_final = $value['a'];
                $sol_bitacora->vales = $value['vales'];
                $sol_bitacora->save(); // guardar el registro

            }
            /**
             * actualizar registro
             * después del recorrido del bucle se necesita obtener el km_final_antes_cargar_combustible para la tabla catalogo_vehiculo
             */
            $catVehiculo = CatalogoVehiculo::where('id', $request->catalogo_vehiculo_id)->first();
            if (is_null($catVehiculo->km_final)) {
                # si es nulo vamos a obtener los valores de los km iniciales
                $kmFinal = $catVehiculo->km_inicial + $request->km_totales;
                CatalogoVehiculo::where('id', $request->catalogo_vehiculo_id)->update([ 'km_final' => $kmFinal ]);
            } else {
                # si no es nulo vamos a obtener el km final y agregar los km totales
                $kmFinal = $catVehiculo->km_final + $request->km_totales;
                CatalogoVehiculo::where('id', $request->catalogo_vehiculo_id)->update([ 'km_final' => $kmFinal ]);
            }
            /**
             * calcular la diferencia de fechas - obtener la fecha del seguimiento Solicitud
             * $currentDate = Carbon::createFromFormat('Y-m-d', $fechaActual);
             * queremos obtener la diferencia en dias
             */
            $getDate = SeguimientoSolicitud::where('solicitud_id', $solicitud)->first();
            $shippingDate = Carbon::parse($getDate->fecha_inicio);
            $currentDate = Carbon::parse(Carbon::now()->format('Y-m-d'));
            $diferencia_en_dias = $currentDate->diffInDays($shippingDate);
            /**
             * actualizamos también el seguimiento de la solicitud
             */
            SeguimientoSolicitud::where('solicitud_id', $solicitud)->update(['status_seguimiento_id' => 5, 'fecha_fin' => Carbon::now()->format('Y-m-d'), 'tiempo_solicitud' => $diferencia_en_dias]);
             // redireccionar
             return redirect()->route('solicitud.bitacora.revision')->with('success', 'BITÁCORA REVISADA Y LISTA PARA FIRMA!');
        } catch (QueryException $e) {
           // redireccionamos con errores - redirección de vuelta
           return back()->with('error', $e->getMessage());
        }
    }

    protected function archived(Request $request)
    {
        /**
         * petición de la solicitud 
         */
        $fecha = Carbon::now()->format('Y-m-d');
        $hora = Carbon::now()->format('H:i:s');
        // $MAC = exec('getmac');
        // $MAC = strtok($MAC, ' ');
        $tipo_peticion = 'GET';
        $path = '/solicitud/bitacora/generar/documento';
        $peticion = ['operacion' => 'Indice Bitácoras terminadas', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora , 'tipo_interaccion' => 2, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);

        $meses = array("Enero" => 1, "Febrero" => 2, "Marzo" => 3,"Abril" => 4, "Mayo" => 5, "Junio" => 6, "Julio" => 7, "Agosto" => 8, "Septiembre" => 9, "Octubre" => 10 , "Noviembre" => 11, "Diciembre" => 12);
        // $fecha = Carbon::now();
        // $anio_actual = $fecha->year;
        // $mes = $meses[($fecha->format('n')) - 1];
        // $mes_numero = $fecha->month;

        $bitacoraTerminada = Solicitud::select('solicitud.fecha', 'solicitud.periodo', 
        'solicitud.numero_factura_compra', 'solicitud.id',
        'solicitud.status_proceso', 'catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo',
        'catalogo_vehiculo.tipo', 'catalogo_vehiculo.placas', 'seguimiento_status.estado')
            ->leftjoin('catalogo_vehiculo', 'solicitud.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
            ->leftjoin('seguimiento_solicitud', 'solicitud.id', '=', 'seguimiento_solicitud.solicitud_id')
            ->leftjoin('seguimiento_status', 'seguimiento_solicitud.status_seguimiento_id', '=', 'seguimiento_status.id')
            ->where('seguimiento_solicitud.status_seguimiento_id', '=', 5)
            ->get();
        return view('theme.dashboard.layouts.bitacora_generada', compact('bitacoraTerminada', 'meses'));
    }

    protected function solicitud_detalle_archived($id)
    {
        $idSolicitud = base64_decode($id);
        /**
         * solicitud
         */
        $solicitud_terminada = Solicitud::select('solicitud.fecha', 'solicitud.periodo', 
        'solicitud.numero_factura_compra', 'solicitud.id',
        'solicitud.status_proceso', 'catalogo_vehiculo.marca', 'catalogo_vehiculo.modelo',
        'catalogo_vehiculo.tipo', 'catalogo_vehiculo.placas', 'seguimiento_status.estado', 'catalogo_vehiculo.color', 'catalogo_vehiculo.numero_motor',
        'catalogo_vehiculo.linea', 'catalogo_vehiculo.importe_combustible', 
        'catalogo_vehiculo.numero_serie', 'solicitud.km_inicial', 'solicitud.conductor', 
        'resguardante.resguardante_unidad', 'resguardante.puesto_resguardante_unidad', 'solicitud.litros_totales', 
        'solicitud.importe_total', 'solicitud.total_km_recorridos', 'solicitud.es_comision', 'solicitud.km_final_antes_cargar_combustible')
            ->leftjoin('catalogo_vehiculo', 'solicitud.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
            ->leftjoin('seguimiento_solicitud', 'solicitud.id', '=', 'seguimiento_solicitud.solicitud_id')
            ->leftjoin('seguimiento_status', 'seguimiento_solicitud.status_seguimiento_id', '=', 'seguimiento_status.id')
            ->leftjoin('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')
            ->where([
                ['solicitud.id', '=' ,$idSolicitud],
                ['seguimiento_solicitud.status_seguimiento_id', '=', 5]
            ])
            ->first();
        /**
         * solicitud Bitácora que está vinculado a la solicitud
         */
        /**
         * se obtiene el comision de la solicitud para que podamos utilizar un switch
         */
        switch ($solicitud_terminada->es_comision) {
            case true:
                # si hay una comision
                $bitacoraComision = BitacoraComision::where('solicitud_id', $idSolicitud)->get();
                $recorridoComision = RecorridoComision::where('solicitud_id', $idSolicitud)->get();
                $bitacora_recorrido_terminado = '';
            break;
            case false:
                # no es una comision
                $bitacora_recorrido_terminado = Bitacora::where('solicitud_id', $idSolicitud)->get();
                $bitacoraComision = '';
                $recorridoComision = '';
            break;
        }
        
        return view('theme.dashboard.layouts.detalle_bitacora_terminada', compact('solicitud_terminada', 'bitacora_recorrido_terminado', 'bitacoraComision', 'recorridoComision'));
    }

    /**
     * funcion de autocompletado - para los choferes de los vehículos
     */
    protected function fetch(Request $request)
    {
        $termino = Str::upper($request->term);

        $data = Chofer::select("nombre")
                ->where("nombre","LIKE","%{$termino}%")
                ->get();
                
        $array_name = array();
        foreach ($data as $hsl)
        {
            $array_name[] = $hsl->nombre;
        }
   
        return response()->json($array_name);

    }
}
