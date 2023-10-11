<?php

namespace App\Http\Controllers\solicitud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\DevolucionFolioRepositoryInterface;

class DevolucionesFolioController extends Controller
{
    private DevolucionFolioRepositoryInterface $devolucionFolioRepository;

    public function __construct(DevolucionFolioRepositoryInterface $devolucionFolioRepository)
    {
        $this->devolucionFolioRepository = $devolucionFolioRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiculos = $this->devolucionFolioRepository->getVehiculos();
        // dd($vehiculos);
        // indice del dato
        return view('theme.dashboard.layouts.devoluciones_folio.indexdevoluciones', compact('vehiculos'));
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
        //
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
        try {
            $reqFolios = $this->devolucionFolioRepository->getFolioByVehicle($id);
            //iniciamos el proceso
            $doneArray = [
                'data' => $reqFolios, // debe devolver un valor booleano
                'message' => true,
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

    public function deleteimtem($id, $folio)
    {
        $paramId = base64_decode($id);
        $idFolio = $folio;
        try {
            //delete item
            $devolucion =  $this->devolucionFolioRepository->returnFolio($idFolio, $paramId);

            $doneArray = [
                'Data' => $devolucion, // debe devolver un valor booleano
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
