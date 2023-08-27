<?php

namespace App\Http\Controllers\factura_folio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\FacturaRepositoryInterface;
use App\Interfaces\FolioRepositoryInterface;
use Illuminate\Database\QueryException;
use App\Models\factura_folio\Factura;
use App\Models\factura_folio\Folio;

class FolioController extends Controller
{
    private FacturaRepositoryInterface $facturaRepository;
    private FolioRepositoryInterface $folioRepository;

    // crear constructor
    public function __construct(FacturaRepositoryInterface $facturaRepository, FolioRepositoryInterface $folioRepository){
        $this->facturaRepository = $facturaRepository;
        $this->folioRepository = $folioRepository;
    }

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
        // vamos a traer una consulta
        $getFoliosDisponibles = $this->folioRepository->getFoliosByStatus();
        $getDenominacion = $this->folioRepository->getDenominacionByFactura();
        $chkFactura = $this->facturaRepository->checkFactura();
        return view('theme.dashboard.layouts.facturas_folio.Forms.frmasignacionfolio', compact('getFoliosDisponibles', 'getDenominacion', 'chkFactura'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // ejecutando el guardado
        try {
            //agregamos el código
            $folioFactura = $this->folioRepository->addFolioFactura($request);
            if ($folioFactura) {
                // retornaremos una llamada json porque no necesito un retornar una vista
                $doneArray = [
                    'success' => true,
                    'message' => 'Folio Agregado Exitosamente!',
                    'data' => 'OK'
                ];
                return response()->json($doneArray, 200);
            } else {
                $wrongArray = [
                    'success' => false,
                    'message' => 'Error al procesar la solicitud!',
                    'data' => 'ERROR'
                ];
                return response()->json($wrongArray, 500);
            }
        } catch (QueryException $th) {
            //lanzar la excepción;
            $errorArray = [
                'message' => $th->getMessage(),
            ];
            return response()->json($errorArray, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        $getFactura = $this->folioRepository->getFolio($request, $id);
        $descripcionSelect = $this->facturaRepository->getFacturaDetalle();
        return view('theme.dashboard.layouts.facturas_folio.Forms.frmfolios', compact('getFactura', 'descripcionSelect'));
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_voucher(){
        $catVehiculo = $this->folioRepository->folioAsignadoIndex(); // obtener los vehiculos que tienen una asignación de folios
        return view('theme.dashboard.layouts.facturas_folio.indexvouchers', compact('catVehiculo'))->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function folioSearch(Request $request)
    {
        $array = $this->folioRepository->searchFolio($request);
        return response()->json($array);
    }

    public function loadData(Request $request){
        $datos = $this->folioRepository->loadData($request);
        return response()->json($datos);
    }

    public function cargarVales(Request $req){
        try {
            //enviamos la petición en el try
            $data = $this->folioRepository->cargarFolios($req);
            return response()->json(['response' => $data], 200);
        } catch (\Throwable $th) {
            //lanzando la excepción
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * método para guardar - asociar registros con el cat_vehiculos y los folios
     */
    public function attachCatVehiculoFolio(Request $request){
        try {
            //se ejecuta el código que necesitamos
            $reqSol = $this->folioRepository->asignarFoliosVehiculo($request);
            return response()->json(['res' => $reqSol]);
        } catch (\Throwable $th) {
            //envía un mensaje de excepción
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
    /**
     * obtener detalles del id asociado
     */
    public function getDetails($id){
        try {
            //ejecución de código que se necesita
            $respuesta = $this->folioRepository->getDetails($id);
            return response()->json(['res' => $respuesta], 200);
        } catch (\Throwable $th) {
            //enviar mensaje de excepción
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * checar si hay folios con status "REASIGNAR"
     */
    public function getFolioReasignar($id)
    {
        try {
            //se carga el código y se visualiza
            $res = $this->folioRepository->getReasignar($id);
            return response()->json(['res' => $res], 200);
        } catch (\Throwable $th) {
            //enviar mensaje de excepción
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }
}
