<?php

namespace App\Http\Controllers\pdfControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use App\Models\solicitud\Solicitud;
use App\Models\solicitud\Bitacora;
use App\Models\solicitud\BitacoraComision;
use App\Models\solicitud\RecorridoComision;

class ReporteBitacoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = [
            'title' => 'Welcome to OnlineWebTutorBlog.com',
            'author' => "Sanjay"
        ];
          
        $pdf = PDF::loadView('theme.dashboard.reportes.reportebitacora', $data);
        // $pdf->setOptions(['isPhpEnabled' => true]);
        $pdf->setPaper('A4', 'landscape');
        // $pdf->setPaper('legal', 'Landscape');
        return $pdf->stream('onlinewebtutorblog.pdf');
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
        $idSol = base64_decode($id);
        $solicitud = Solicitud::select('solicitud.fecha', 
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
                'solicitud.total_km_recorridos', 'solicitud.status_proceso', 'solicitud.id', 'solicitud.catalogo_vehiculo_id', 'solicitud.observacion',
                'solicitud.nombre_elabora', 'solicitud.puesto_elabora',
                'solicitud.km_final_antes_cargar_combustible', 'solicitud.es_comision', 'solicitud.km_final_antes_cargar_combustible')
                ->leftjoin('seguimiento_solicitud', 'solicitud.id', '=', 'seguimiento_solicitud.solicitud_id')
                ->leftjoin('seguimiento_status', 'seguimiento_solicitud.status_seguimiento_id', '=', 'seguimiento_status.id')
                ->leftjoin('catalogo_vehiculo', 'solicitud.catalogo_vehiculo_id', '=', 'catalogo_vehiculo.id')
                ->leftjoin('resguardante', 'catalogo_vehiculo.resguardante_id', '=', 'resguardante.id')
                ->where([
                    ['solicitud.id', '=', $idSol],
                    ['seguimiento_solicitud.status_seguimiento_id', '=', 5]
                ])->first();

            /**
             * se obtiene la comisión de la solicitud para que se pueda utilizar un switch
             */
            switch ($solicitud->es_comision) {
                case true:
                    # si hay comisión -  es comisión
                    $bitacoraComision = BitacoraComision::where('solicitud_id', $idSol)->get();
                    $recorridoComision = RecorridoComision::where('solicitud_id', $idSol)->get();
                    $recorrido_bitacora = '';
                    break;
                case false:
                    # no es una comisión
                    $bitacoraComision = '';
                    $recorridoComision = '';
                    $recorrido_bitacora = Bitacora::where('solicitud_id', $idSol)->get();
                    break;
                default:
                    # respuesta por defecto
                    break;
            }

        $pdf = PDF::loadView('theme.dashboard.reportes.reportebitacora', compact('solicitud', 'recorrido_bitacora', 'bitacoraComision', 'recorridoComision'));
        // $pdf->setOptions(['isPhpEnabled' => true]);
        $pdf->setPaper('A4', 'landscape');
        // $pdf->setPaper('legal', 'Landscape');
        return $pdf->stream('bitacora'.$solicitud->marca.'_'.$solicitud->periodo.'_'.$solicitud->anio_actual.'.pdf');
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
}
