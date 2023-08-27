 {{-- desarrollado y diseñado por MIS. DANIEL MÉNDEZ CRUZ - DERECHOS RESERVADOS ICATECH 2021 --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte Bitácora</title>
    <style>
        body{font-family: sans-serif}
        @page {margin: 40px 30px 10px 30px;}
            header { position: fixed; left: 0px; top: 10px; right: 0px; text-align: center;}
            header h1{height:0; line-height: 14px; padding: 9px; margin: 0;}
            header h2{margin-top: 20px; font-size: 8px; border: 1px solid gray; padding: 12px; line-height: 18px; text-align: justify;}
            footer {position:fixed;   left:0px;   bottom:-170px;   height:150px;   width:100%;}
            footer .page:after { content: counter(page, sans-serif);}
            img.izquierda {float: left;width: 200px;height: 60px;}
            img.izquierdabot {position: absolute;left: 50px;width: 350px;height: 60px;}
            img.derechabot {position: absolute;right: 50px;width: 350px;height: 60px;}
            img.derecha {float: right;width: 200px;height: 60px;}
        .tablas{border-collapse: collapse;width: 100%;}
        .tablas tr td{font-size: 8px; border: gray 1px solid; text-align: center; padding: 1px 1px;}
        .tablas th{font-size: 8px; border: gray 1px solid; text-align: center; padding: 1px 1px;}
        .tablaf { border-collapse: collapse; width: 100%;}
        .tablaf tr td { font-size: 8px; text-align: center; padding: 0px 0px;}
        .tablad { border-collapse: collapse; width: 100%;}
        .tablad tr td{ font-size: 8px; text-align: left; padding: 2px;}
        .tablag { border-collapse: collapse; width: 100%; /*border: 1px solid black;*/}
        .tablag tr td{ font-size: 8px; padding: 0px; /*border: 1px solid black;*/}
        .tablas_notas{border-collapse: collapse;width: 100%;}
        .tablas_notas tr td{font-size: 8px; border: gray 1px solid; text-align: justify; padding: 1px 1px; height: 2em;}
        .tablas_notas th{font-size: 8px; border: gray 1px solid; text-align: justify; padding: 1px 1px;}
        .variable{ border-bottom: gray 1px solid;border-left: gray 1px solid;border-right: gray 1px solid}
        /** Definir las reglas del pie de página **/
        /* footer {
                position: fixed;
                bottom: 0cm;
                left: 0cm;
                right: 0cm;
                height: 1cm;
        } */
    </style>
</head>
<body>
    <div class= "container g-pt-30">
        <div id="content">
            <img class="izquierda" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/reportes/logohorizontalica1.png'))) }}">
            <img class="derecha" src="{{ public_path('assets/img/reportes/chiapas.png') }}">
            <div id="wrappertop">
                <div align=center><br>
                    <font size=1><b>INSTITUTO DE CAPACITACIÓN Y VINCULACIÓN TECNOLOGICA DEL ESTADO DE CHIAPAS</b></font><br/>
                    <font size=1><b>"2022, Año de Ricardo Flores Magón, Precursor de la Revolución Mexicana"</b></font><br/>
                    <font size=1><b>UNIDAD DE APOYO ADMINISTRATIVO</b> <br/>
                    <font size=1><b>ÁREA DE RECURSOS MATERIALES Y SERVICIOS</b></font><br/>
                    <br><font size=1><b>BITÁCORA DE RECORRIDO</b></font>
                </div><br><br><br>
            </div>
            <table class="tablag">
                <body>
                    <tr>
                        <td style="width: 20%"><b>KILOMETRO INICIAL: </b></td>
                        <td style="width: 20%"><b>No. DE FACTURA DE COMPRA: {{ $data['temporal']['numero_factura_compra']}}</b></td>
                        <td style="width: 20%"></td>
                        <td style="width: 20%"></td>
                        <td style="width: 20%"></td>
                    </tr>
                    <tr>
                        <td style="width: 20%">&nbsp;</td>
                        <td style="width: 20%">&nbsp;</td>
                        <td style="width: 20%">&nbsp;</td>
                        <td style="width: 20%">&nbsp;</td>
                        <td style="width: 20%">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width: 20%"><b>MEMORANDUM DE COMISION No. </b></td>
                        <td style="width: 20%"><b>No. DE MOTOR: {{ $data['temporal']['numero_motor'] }}</b></td>
                        <td style="width: 20%"><b>COLOR: {{ $data['temporal']['color'] }}</b></td>
                        <td style="width: 20%"><b>FECHA: {{ $data['temporal']['fecha'] }}</b></td>
                        <td style="width: 20%"><b>PERIODO: {{ $data['temporal']['periodo'] }}</b></td>
                    </tr>
                    <tr>
                        <td style="width: 20%"><b>VEHICULO MARCA: {{ $data['temporal']['marca'] }}</b></td>
                        <td style="width: 20%"><b>MODELO: {{ $data['temporal']['modelo'] }}</b></td>
                        <td style="width: 20%"><b>TIPO: {{ $data['temporal']['tipo'] }}</b></td>
                        <td style="width: 20%"><b>PLACAS: {{ $data['temporal']['placas'] }}</b></td>
                        <td style="width: 20%"><b>No. DE SERIE: {{ $data['temporal']['numero_serie'] }}</b></td>
                    </tr>
                </body>
            </table>
            <br><br>
            <div class="table table-responsive">
                       {{-- es comisión --}}
                      @php
                       $i = 0;
                       $j = 0;
                       $contador = 0;
                      @endphp
                        <table class="tablas">
                            <thead>
                                <tr>
                                    <th colspan="5"><b>RECORRIDO DE COMISIÓN</b></th>
                                    <th colspan="5"><b>GASOLINA</b></th>
                                </tr>
                                <tr>
                                    <th>Fecha</th>
                                    <th>KM inicial</th>
                                    <th>De:</th>
                                    <th>A:</th>
                                    <th>Tipo Recorrido:</th>
                                    <th>KM final</th>
                                    <th>Factura</th>
                                    <th>Litros</th>
                                    <th>P.U</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['recorrido'] as $k => $v)
                                    @php
                                        $i ++;
                                        $j ++;
                                        $contador ++;
                                    @endphp
                                    <tr>
                                        <td data-label="KM inicial">
                                            {{ $v->fecha_comision }}
                                        </td>
                                        <td data-label="KM inicial">
                                        @if ($i  == 1)
                                            {{ $v->km_inicial }}
                                        @endif
                                        </td>
                                        <td data-label="De:">
                                            {{ $v->de_comision }}
                                        </td>
                                        <td data-label="A:">
                                            {{ $v->a_comision }}
                                        </td>
                                        <td data-label="Tipo Recorrido:">
                                            {{ $v->tipo }}
                                        </td>
                                        <td data-label="KM final">
                                        @if ($j == 1)
                                            {{ $v->km_final }}
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                    <td>KILOMETROS TOTALES:</td>
                                    <td><b>{{ $data['temporal']['total_km_recorridos'] }} KMS</b></td>
                                    <td>&nbsp;</td>
                                    <td>LITROS:</td>
                                    <td><b>{{ $data['temporal']['litros_totales'] }}</b></td>
                                    <td><b>$ {{ $data['temporal']['importe_total'] }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                <br>
                <table class="tablag">
                    <tbody>
                        <tr>
                            <td style="width: 100%">
                                <b>Conductor: &nbsp; {{ $data['temporal']['conductor'] }}</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br><br>
                <table class="tablaf">
                    <tr>
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                        <td align="center"><b>ELABORO</b><br><br><br></td>
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                        <td align="center"><b>VO.BO.</b><br><br><br></td>
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                        <td align="center"><b>RESPONSABLE/COMISIONADO</b><br><br><br></td>
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                    </tr>
                    <tr>
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                        <td align="center"><br>_____________________________________________________</td>
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                        <td align="center"><br>_____________________________________________________</td>
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                        <td align="center"><br>_____________________________________________________</td>
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                    </tr>
                    <tr>
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                        {{-- <td align="center"><b>{{ $solicitud->nombre_elabora }}</b></td> --}}
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                        <td align="center"><b>LIC. ISABEL CRISTINA RÍOS MIJANGOS</b></td>
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                        {{-- <td align="center"><b>{{ $solicitud->resguardante_unidad }}</b></td> --}}
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                    </tr>
                    <tr>
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                        {{-- <td align="center"><b>{{ $solicitud->puesto_elabora }}</b></td> --}}
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                        <td align="center"><b>JEFA DEL DEPARTAMENTO DE RECURSOS MATERIALES</b></td>
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                        {{-- <td align="center"><b>{{ $solicitud->puesto_resguardante_unidad }}</b></td> --}}
                        <td> </td><td> </td><td> </td><td> </td><td> </td>
                    </tr>
                </table>
                <br/> <br/>
                <table class="tablad">
                    <tr>
                        <td colspan="3"><b>NOTA: EL LLENADO DE ESTA BITACORA DEBERA SER EN BASE AL RECORRIDO PARA LLEVAR A CABO LA COMISIÓN, EL CUAL SERA REVISADO POR EL AREA DE RECURSOS MATERIALES Y SERVICIOS.</b></td>
                    </tr>
                </table>
                <hr style="border:1px dotted black; width:100%" />
                <br>
                <table class="tablas_notas">
                    <tr>
                        <td colspan="2">
                            <b>PARA USO EXCLUSIVO DEL AREA DE RECURSOS MATERIALES Y SERVICIOS</b>
                        </td>
                    </tr>
                    <tr>
                        <td>KM INICIAL: {{ $data['temporal']['km_inicial'] }}</td>
                        <td>PUESTO DEL RESGUARDANTE: {{ $data['temporal']['puesto_resguardante_unidad'] }}</td>
                    </tr>
                    <tr>
                        <td>KM. FINAL: {{ $data['temporal']['km_final_antes_cargar_combustible'] }}</td>
                        <td>RESGUARDANTE: {{ $data['temporal']['resguardante_unidad'] }}.</td>
                    </tr>
                    <tr>
                        <td>KMS. RECORRIDOS: {{ $data['temporal']['total_km_recorridos'] }}</td>
                        <td>No. DE UNIDAD O ECONOMICO: 63100161002</td>
                    </tr>
                    <tr>
                        <td>LTS. DE GASOLINA: {{ $data['temporal']['litros_totales'] }}</td>
                        {{-- <td>OBSERVACIONES: {{ $solicitud->observacion }}</td> --}}
                    </tr>
                    <tr>
                        <td>RENDIMIENTO: {{ $data['temporal']['rendimiento_mixto'] }} KM / LTS</td>
                        <td>MONTO TOTAL DE RENDIMIENTO: {{ $data['temporal']['monto_total_rendimiento'] }}</td>
                    </tr>
                    <tr>
                        <td>
                            <b>AREA DE RECURSOS MATERIALES Y SERVICIOS</b>
                        </td>
                        <td>
                            <b>D.V: DIVISION DEL VALE.</b>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <script type="text/php">
        if ( isset($pdf) ) {
            $font = $fontMetrics->getFont("helvetica", "bold");
            $pdf->page_text(370, 570, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
        }
    </script>
</body>
</html>
