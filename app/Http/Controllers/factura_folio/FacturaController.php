<?php

namespace App\Http\Controllers\factura_folio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\factura_folio\Factura;
use App\Http\Traits\UploadFileTrait;
use Illuminate\Database\QueryException;
use App\Http\Requests\FacturaRequest;
use App\Interfaces\FacturaRepositoryInterface;
use App\Interfaces\ProveedorRepositoryInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class FacturaController extends Controller
{
    use UploadFileTrait;
    private FacturaRepositoryInterface $facturaRepository;
    private ProveedorRepositoryInterface $proveedorRepository;
    // crear constructor
    public function __construct(FacturaRepositoryInterface $facturaRepository, ProveedorRepositoryInterface $proveedorRepository){
        $this->facturaRepository = $facturaRepository;
        $this->proveedorRepository = $proveedorRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // regreso a la vista
        $factura = $this->facturaRepository->facturaAll($request);
        return view('theme.dashboard.layouts.facturas_folio.indexfolio', compact('factura'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedores = $this->proveedorRepository->proveedoresAll();
        // retornamos una vista del formulario
        return view('theme.dashboard.layouts.facturas_folio.Forms.frmaddfacturas', compact('proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FacturaRequest $request)
    {
        // guardar los registros
        try {
            /**
             * obtener el último ID -  se envía al método crearFactura de la interface
             * FacturaRepositoryInterface
             */

            $factura = $this->facturaRepository->createFactura($request);

            if ($factura){
                // retornaremos una llamada json porque no necesito un retornar una vista
                $doneArray = [
                    'success' => true,
                    'message' => 'Factura Agregada Exitosamente!',
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
            //throw $th;
            $errorArray = [
                'Error' => $th->getMessage(),
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$this->facturaRepository->getFactura($id);
        $getFactura = $this->facturaRepository->getFactura($id);
        $proveedores = $this->proveedorRepository->proveedoresAll();
        return view('theme.dashboard.layouts.facturas_folio.Forms.frmupdatefacturas', compact('getFactura', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FacturaRequest $request, $id)
    {
        //
        try {
            //actualizar registro
            $this->facturaRepository->updateFactura($id, $request);
            $doneArray = [
                'success' => true,
                'message' => 'Factura Actualizada Exitosamente!',
                'data' => 'OK'
            ];
            return response()->json($doneArray, 200);
        } catch (QueryException $e) {
            //excepción de consulta
            $wrongArray = [
                'success' => false,
                'message' => 'Error al procesar la solicitud!',
                'data' => 'ERROR'
            ];
            return response()->json($wrongArray, 500);
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
        try {
            //realizar la operación
            $response = $this->facturaRepository->eliminarDetalleFactura($id);
            return redirect()->route('factura.edit', ['id' => base64_encode($response)])->with('success', 'REGISTRO ELIMINADO ÉXITOSAMENTE.');
        } catch (QueryException $th) {
            //mandamos mensaje de regreso de excepción
            return back()->with('error', $th->getMessage());
        }
    }

    public function getFile($filename)
    {
        $files = Factura::WHERE('id', $filename)->first();
        if (!$files)
        {
            abort(500);
        } else {
            $filepath = $files->archivo;
            if (!File::exists(storage_path('app/'.$filepath))) {
                # checando si el archivo éxiste
                abort(404); // si no hay abortamos
            }
            $file = File::get($files->archivo);
            $type = File::mimetype($files->archivo);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDetail(Request $request){
        try {
            //agregar nuevo registro
            $detalle_factura = $this->facturaRepository->addDetalle($request);
            if ($detalle_factura) {
                # si la condición no es verdadera
                $doneArray = [
                    'success' => true,
                    'message' => 'Factura Actualizada Exitosamente!',
                    'data' => 'OK'
                ];
                return response()->json($doneArray, 200);
            } else {
                // si no es verdadera
                $wrongArray = [
                    'success' => false,
                    'message' => 'Error al procesar la solicitud!',
                    'data' => 'ERROR'
                ];
                return response()->json($wrongArray, 500);
            }
        } catch (QueryException $t) {
            //arrojar una excepción
            $wrongArray = [
                'success' => false,
                'message' => $t->getMessage(),
                'data' => 'ERROR'
            ];
            return response()->json($wrongArray, 500);
        }
    }
}
