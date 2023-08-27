<?php

namespace App\Http\Controllers\pdfControllers;

use App\Http\Controllers\Controller;
use App\Interfaces\ReporteRepositoryInterface;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\solicitud\Solicitud;
use App\Models\solicitud\Bitacora;
use App\Models\solicitud\BitacoraComision;
use App\Models\solicitud\RecorridoComision;

class ReporteBitacoraController extends Controller
{
    private ReporteRepositoryInterface $reporteRepository;

    public function __construct(ReporteRepositoryInterface $reporteRepository)
    {
        $this->reporteRepository = $reporteRepository;
    }
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
       $data = $this->reporteRepository->getReporte($id);

        $pdf = PDF::setOptions(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);
        $pdf->loadView('theme.dashboard.reportes.reporte_test', compact('data'));
        //Establecer el tamaño de hoja en DOMPDF
        $pdf->setPaper('A4', 'Portrait');//x inicio, y inicio, ancho final, alto final
        $pdf->getDomPDF()->setHttpContext(
            stream_context_create([
                'ssl' => [
                    'allow_self_signed'=> TRUE,
                    'verify_peer' => FALSE,
                    'verify_peer_name' => FALSE,
                ]
            ])
        );
        return $pdf->stream('bitacora.pdf');
        // return view('theme.dashboard.reportes.reportebitacora', compact('data'));
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
