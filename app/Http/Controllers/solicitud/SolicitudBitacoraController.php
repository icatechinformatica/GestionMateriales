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
use App\Interfaces\BitacoraRepositoryInterface;
use App\Interfaces\DriverRepositoryInterface;
use App\Interfaces\FacturaRepositoryInterface;
use App\Interfaces\FolioRepositoryInterface;
use App\Models\factura_folio\Folio;

class SolicitudBitacoraController extends Controller
{
    use LogTrait;
    private BitacoraRepositoryInterface $bitacoraRepository;
    private FolioRepositoryInterface $folioRepository;
    private FacturaRepositoryInterface $facturaRepository;
    private DriverRepositoryInterface $driverRepository;
    // crear un constructor
    public function __construct(BitacoraRepositoryInterface $bitacoraRepository, FolioRepositoryInterface $folioRepository, FacturaRepositoryInterface $facturaRepository, DriverRepositoryInterface $driverRepository)
    {
        // getBitacora
        $this->bitacoraRepository = $bitacoraRepository;
        $this->folioRepository = $folioRepository;
        $this->facturaRepository = $facturaRepository;
        $this->driverRepository = $driverRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $solicitud = Solicitud::select(
            'solicitud.fecha',
            'solicitud.periodo',
            'solicitud.numero_factura_compra',
            'solicitud.id',
            'solicitud.status_proceso',
            'catalogo_vehiculo.marca',
            'catalogo_vehiculo.modelo',
            'catalogo_vehiculo.tipo',
            'catalogo_vehiculo.placas',
            'seguimiento_status.estado',
            'seguimiento_solicitud.status_seguimiento_id'
        )
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

        $tipo_peticion = 'GET';
        $path = '/solicitud/create';
        $peticion = ['operacion' => 'Agregar una nueva solicitud de bitácora de rendimiento', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora, 'tipo_interaccion' => 3, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);
        /**
         * programar el mes actual - del periodo
         */
        $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
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

        ], [
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
            $peticion = ['operacion' => 'Agregar una bitácora de rendimiento nueva', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora, 'tipo_interaccion' => 4, 'tipo_peticion' => $tipo_peticion, 'httpRequest' => $solicitud_total];
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
        $solicitud_detalle = Solicitud::select(
            'solicitud.fecha',
            'solicitud.periodo',
            'solicitud.numero_factura_compra',
            'solicitud.id',
            'solicitud.status_proceso',
            'catalogo_vehiculo.marca',
            'catalogo_vehiculo.modelo',
            'catalogo_vehiculo.tipo',
            'catalogo_vehiculo.placas',
            'seguimiento_status.estado',
            'catalogo_vehiculo.color',
            'catalogo_vehiculo.numero_motor',
            'catalogo_vehiculo.linea',
            'catalogo_vehiculo.importe_combustible',
            'catalogo_vehiculo.numero_serie',
            'solicitud.km_inicial',
            'solicitud.conductor',
            'resguardante.resguardante_unidad',
            'resguardante.puesto_resguardante_unidad',
            'solicitud.litros_totales',
            'solicitud.importe_total',
            'solicitud.total_km_recorridos',
            'solicitud.observacion'
        )
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
            ->where("placas", "LIKE", "%{$request->term}%")
            ->get();

        $array_ = array();
        foreach ($data as $hsl) {
            $array_[] = $hsl->placas;
        }

        return response()->json($array_);
    }

    public function loaddata(Request $request)
    {
        $datos = CatalogoVehiculo::select(
            "catalogo_vehiculo.id",
            'catalogo_vehiculo.color',
            'catalogo_vehiculo.numero_motor',
            'catalogo_vehiculo.marca',
            'catalogo_vehiculo.modelo',
            'catalogo_vehiculo.rendimiento_ciudad',
            'catalogo_vehiculo.rendimiento_carretera',
            'catalogo_vehiculo.rendimiento_mixto',
            'catalogo_vehiculo.rendimiento_carga',
            'catalogo_vehiculo.tipo',
            'catalogo_vehiculo.numero_serie',
            'catalogo_vehiculo.placas',
            'catalogo_vehiculo.linea',
            'catalogo_vehiculo.importe_combustible',
            'resguardante.resguardante_unidad',
            'resguardante.puesto_resguardante_unidad',
            'catalogo_vehiculo.numero_economico'
        )
            ->join('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')
            ->where("catalogo_vehiculo.placas", "=", $request->type)
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
        $peticion = ['operacion' => 'Revisión de Bitácora indice', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora, 'tipo_interaccion' => 2, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);
        /**
         * programar el mes actual - del periodo
         */
        $meses = array("Enero" => 1, "Febrero" => 2, "Marzo" => 3, "Abril" => 4, "Mayo" => 5, "Junio" => 6, "Julio" => 7, "Agosto" => 8, "Septiembre" => 9, "Octubre" => 10, "Noviembre" => 11, "Diciembre" => 12);
        // $fecha = Carbon::now();
        // $anio_actual = $fecha->year;
        // $mes = $meses[($fecha->format('n')) - 1];
        // $mes_numero = $fecha->month;

        $solicitudRevision = Solicitud::select(
            'solicitud.fecha',
            'solicitud.periodo',
            'solicitud.numero_factura_compra',
            'solicitud.id',
            'solicitud.status_proceso',
            'catalogo_vehiculo.marca',
            'catalogo_vehiculo.modelo',
            'catalogo_vehiculo.tipo',
            'catalogo_vehiculo.placas',
            'seguimiento_status.estado',
            'solicitud.es_comision'
        )
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
        $path = '/solicitud/revision/detail/' . $id;
        $peticion = ['operacion' => 'Revisión de Bitácora de Recorrido final', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora, 'tipo_interaccion' => 2, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);
        /**
         *
         */
        $idSol = base64_decode($id);
        $solicitud_por_id = Solicitud::select(
            'solicitud.fecha',
            'solicitud.periodo',
            'solicitud.km_inicial',
            'solicitud.numero_factura_compra',
            'solicitud.periodo_actual',
            'solicitud.anio_actual',
            'catalogo_vehiculo.color',
            'solicitud.conductor',
            'catalogo_vehiculo.numero_motor',
            'catalogo_vehiculo.marca',
            'catalogo_vehiculo.modelo',
            'catalogo_vehiculo.tipo',
            'catalogo_vehiculo.placas',
            'catalogo_vehiculo.numero_serie',
            'catalogo_vehiculo.linea',
            'catalogo_vehiculo.importe_combustible',
            'resguardante.resguardante_unidad',
            'resguardante.puesto_resguardante_unidad',
            'solicitud.litros_totales',
            'solicitud.importe_total',
            'solicitud.total_km_recorridos',
            'solicitud.status_proceso',
            'solicitud.id',
            'solicitud.catalogo_vehiculo_id',
            'solicitud.observacion'
        )
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
        $peticion = ['operacion' => 'solicitudes de bitácora guardadas previamente indice', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora, 'tipo_interaccion' => 2, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);
        /**
         * registro normal
         */
        $userId = auth()->id();
        $nombre_usuario = auth()->user()->name;
        $solicitud = $this->bitacoraRepository->getBitacora();

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

        $tipo_peticion = 'GET';
        $path = '/solicitud/detalle/pre-guardado/' . $id;
        $peticion = ['operacion' => 'Detalle de la solicitud pre-guardada', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora, 'tipo_interaccion' => 3, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);

        $idSolPre = base64_decode($id);
        /**
         * obtenemos la consulta para enviar la información
         */

        $solDetalle = $this->bitacoraRepository->getBitacoraDetails($idSolPre);
        $rendimientos = [
            'Rendimiento Ciudad - ' . $solDetalle->rendimiento_ciudad,
            'Rendimiento Carretera - ' . $solDetalle->rendimiento_carretera,
            'Rendimiento Mixto - ' . $solDetalle->rendimiento_mixto,
            'Rendimiento Carga - ' . $solDetalle->rendimiento_carga,
        ];
        $getTemp = $this->bitacoraRepository->getTemporal($idSolPre);
        $getFolios = $this->folioRepository->getFolioByCatVehicle($idSolPre);
        $datos = $this->folioRepository->getSumByFoliosUsed($idSolPre);
        $getTemporalBitacora = $this->bitacoraRepository->getBitacoraTemp($idSolPre);
        $esComision = $getTemp->es_comision;

        return view('theme.dashboard.forms.bitacoraForm', compact('solDetalle', 'getFolios', 'idSolPre', 'getTemporalBitacora', 'rendimientos', 'datos', 'esComision'))->render();
    }

    /**
     * modificaciones --
     */

    protected function storeBitacora(Request $request)
    {
        try {
            //iniciamos el proceso
            $saveLog = $this->bitacoraRepository->storeRouteLog($request);
            $doneArray = [
                'res' => $saveLog['response'], // devolber valor booleano
                'message' => $saveLog['message'], // debe devolver un mensaje
                'data' => 'OK'
            ];
            return response()->json($doneArray, 200);
        } catch (\Throwable $th) {
            //enviar mensaje de excepción
            $errorArray = [
                'Error' => $th->getMessage(),
            ];
            return response()->json($errorArray, 500);
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
            $path = '/solicitud/bitacora/revision/' . $review;
            $peticion = ['operacion' => 'Activar Revisión de la Bitácora', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora, 'tipo_interaccion' => 5, 'tipo_peticion' => $tipo_peticion];
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
            $peticion = ['operacion' => 'Terminar Bitácora de recorrido y enviar a firma', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora, 'tipo_interaccion' => 4, 'tipo_peticion' => $tipo_peticion, 'httpRequest' => $solicitud_total];
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
                CatalogoVehiculo::where('id', $request->catalogo_vehiculo_id)->update(['km_final' => $kmFinal]);
            } else {
                # si no es nulo vamos a obtener el km final y agregar los km totales
                $kmFinal = $catVehiculo->km_final + $request->km_totales;
                CatalogoVehiculo::where('id', $request->catalogo_vehiculo_id)->update(['km_final' => $kmFinal]);
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
        $peticion = ['operacion' => 'Indice Bitácoras terminadas', 'usuario' => Auth::user()->name, 'ip_request' => $request->ip(), 'sistem_path' => $path, 'fecha_ejecucion' => $fecha, 'hoarario_ejecucion' => $hora, 'tipo_interaccion' => 2, 'tipo_peticion' => $tipo_peticion];
        $this->storeLog($peticion);

        $meses = array("Enero" => 1, "Febrero" => 2, "Marzo" => 3, "Abril" => 4, "Mayo" => 5, "Junio" => 6, "Julio" => 7, "Agosto" => 8, "Septiembre" => 9, "Octubre" => 10, "Noviembre" => 11, "Diciembre" => 12);
        // $fecha = Carbon::now();
        // $anio_actual = $fecha->year;
        // $mes = $meses[($fecha->format('n')) - 1];
        // $mes_numero = $fecha->month;

        $bitacoraTerminada = Solicitud::select(
            'solicitud.fecha',
            'solicitud.periodo',
            'solicitud.numero_factura_compra',
            'solicitud.id',
            'solicitud.status_proceso',
            'catalogo_vehiculo.marca',
            'catalogo_vehiculo.modelo',
            'catalogo_vehiculo.tipo',
            'catalogo_vehiculo.placas',
            'seguimiento_status.estado'
        )
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
        $solicitud_terminada = Solicitud::select(
            'solicitud.fecha',
            'solicitud.periodo',
            'solicitud.numero_factura_compra',
            'solicitud.id',
            'solicitud.status_proceso',
            'catalogo_vehiculo.marca',
            'catalogo_vehiculo.modelo',
            'catalogo_vehiculo.tipo',
            'catalogo_vehiculo.placas',
            'seguimiento_status.estado',
            'catalogo_vehiculo.color',
            'catalogo_vehiculo.numero_motor',
            'catalogo_vehiculo.linea',
            'catalogo_vehiculo.importe_combustible',
            'catalogo_vehiculo.numero_serie',
            'solicitud.km_inicial',
            'solicitud.conductor',
            'resguardante.resguardante_unidad',
            'resguardante.puesto_resguardante_unidad',
            'solicitud.litros_totales',
            'solicitud.importe_total',
            'solicitud.total_km_recorridos',
            'solicitud.es_comision',
            'solicitud.km_final_antes_cargar_combustible'
        )
            ->leftjoin('catalogo_vehiculo', 'solicitud.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
            ->leftjoin('seguimiento_solicitud', 'solicitud.id', '=', 'seguimiento_solicitud.solicitud_id')
            ->leftjoin('seguimiento_status', 'seguimiento_solicitud.status_seguimiento_id', '=', 'seguimiento_status.id')
            ->leftjoin('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')
            ->where([
                ['solicitud.id', '=', $idSolicitud],
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
            ->where("nombre", "LIKE", "%{$termino}%")
            ->get();

        $array_name = array();
        foreach ($data as $hsl) {
            $array_name[] = $hsl->nombre;
        }

        return response()->json($array_name);
    }

    public function reporteBitacora(Request $request)
    {
        return view('theme.dashboard.layouts.reporte_bitacora');
    }

    public function reporteGetInfo(Request $request)
    {
        try {
            $reqReport = $this->bitacoraRepository->getBitacoraReport($request);
            //iniciamos el proceso
            $doneArray = [
                'success' => true,
                'message' => $reqReport, // debe devolver un valor booleano
                'data' => 'OK'
            ];
            return response()->json($doneArray, 200);
        } catch (\Throwable $th) {
            //enviar mensaje de excepción
            $errorArray = [
                'Error' => $th->getMessage(),
            ];
            return response()->json($errorArray, 500);
        }
    }

    public function getFilterFactura(Request $request)
    {
        try {
            //proceso
            $response = $this->facturaRepository->getAllFacturas($request);
            $doneArray = [
                'success' => true,
                'message' => $response, // debe devolver un valor booleano
                'data' => 'OK'
            ];
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            //enviar mensaje de excepcion
            $errorArray = [
                'Error' => $th->getMessage(),
            ];
            return response()->json($errorArray, 500);
        }
    }

    public function saveDataReporte(Request $request)
    {

        try {
            $res = $this->driverRepository->saveDateBitacora($request);
            $doneArray = [
                'success' => true,
                'message' => $res, // debe devolver un valor booleano
                'data' => 'OK'
            ];
            return response()->json($doneArray, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $errorArray = [
                'Error' => $th->getMessage(),
            ];
            return response()->json($errorArray, 500);
        }
    }
}
