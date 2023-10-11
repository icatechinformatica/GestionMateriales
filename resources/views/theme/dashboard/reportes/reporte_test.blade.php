 {{-- desarrollado y diseñado por MIS. DANIEL MÉNDEZ CRUZ - DERECHOS RESERVADOS ICATECH 2021 --}}
 @extends('theme.plantilla.vertical_layout', ['title' => __('Reporte de Recorrido')])

 @section('name')
 @endsection

 @section('contenido_css')
     <style>
         table,
         th,
         td {
             /* border: 1px solid black; */
             border-collapse: collapse;
             border: none;
         }

         th,
         td {
             padding: 2px;
         }

         th {
             text-align: left;
         }

         .tablas {
             width: 100%
         }

         .tablas tr td {
             font-size: 11px;
             border: none;
             text-align: center;
             padding: 1px 1px;
         }

         .tablas th {
             font-size: 8px;
             text-align: center;
             padding: 1px 1px;
         }

         .tabla_con_border {
             border-collapse: collapse;
             font-size: 10px;
             font-family: sans-serif;
         }

         .tabla_con_border tr td {
             border: 1px solid #000000;
             word-wrap: break-word;
         }

         .tabla_con_border td {
             page-break-inside: avoid;
         }

         .tabla_con_border thead tr th {
             border: 1px solid #000000;
         }

         /* espaciado */
         center.espaciado {
             padding-top: 10px;
             font-size: 11px;
         }

         .celdaAsignado {
             word-break: break-all !important;
             white-space: nowrap !important;
             width: 40px !important;
         }

         .tablas_notas {
             border-collapse: collapse;
             width: 100%;
         }

         .tablas_notas tr td {
             font-size: 9px;
             border: #000000 1.8px solid;
             text-align: justify;
             padding: 1px 1px;
             height: 2em;
         }

         .tablas_notas th {
             font-size: 9px;
             border: gray 1px solid;
             text-align: justify;
             padding: 1px 1px;
         }

         /* tablas para firmas */
         .tablaf {
             border-collapse: collapse;
             width: 100%;
             margin-top: 1em;
         }

         .tablaf tr td {
             font-size: 8px;
             text-align: center;
             padding: 0px 0px;
         }

         /* tabla para notas */
         .tablad {
             border-collapse: collapse;
             width: 100%;
             margin-top: 0.6em;
         }

         .tablad tr td {
             font-size: 8px;
             text-align: left;
             padding: 2px;
         }

         .page-break {
             page-break-after: always;
         }
     </style>
 @endsection

 @section('contenido')
     {{-- contenido del documento --}}
     <div class="container-fluid">
         <table>
             <tr>
                 <td width=70%>
                     <table class="tablas">
                         <tr>
                             <td colspan="3"><b>INSTITUTO DE CAPACITACIÓN Y VINCULACIÓN TECNOLOGICA DEL ESTADO DE
                                     CHIAPAS</b></td>
                         </tr>
                         <tr>
                             <td colspan="3"><b>UNIDAD DE APOYO ADMINISTRATIVO</b></td>
                         </tr>
                         <tr>
                             <td colspan="3"><b>ÁREA DE RECURSOS MATERIALES Y SERVICIOS</b></td>
                         </tr>
                         <tr>
                             <td rowspan="2" style="text-align: center;" width="33%"><img
                                     src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/reportes/logohorizontalica1.png'))) }}"
                                     style="width: 150px; height: 50px;" /></td>
                             <td style="text-align: left;" width="34%"><b>BITÁCORA DE RECORRIDO</b></td>
                             <td style="text-align: center;" width="33%"><img
                                     src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/reportes/chiapas.png'))) }}"
                                     style="width: 120px; height: 45px;"></td>
                         </tr>
                         <tr>
                             <td>Kilometraje Inicial: {{ $data['temporal']['km_inicial'] }}</td>
                             <td>No. FACTURA DE COMPRA V: {{ $data['temporal']['numero_factura_compra'] }}</td>
                         </tr>
                     </table>
                 </td>
                 <td width=32%>

                 </td>
             </tr>
         </table>
         <table class="tabla_con_border">
             <tr>
                 <td colspan="2"><b>MEMORANDUM DE COMISIÓN N°</b></td>
             </tr>
             <tr>
                 <td style="border-right:none; border-bottom:none;">N°. DE MOTOR:
                     {{ $data['temporal']['numero_motor'] }}</td>
                 <td style="border-left:none; border-bottom:none;">COLOR: {{ $data['temporal']['color'] }}</td>
             </tr>
             <tr>
                 <td style="border-right:none; border-bottom:none; border-top:none;">FECHA:</td>
                 <td style="border-left:none; border-bottom:none; border-top:none;">PERIODO
                     {{ $data['temporal']['periodo'] }}</td>
             </tr>
             <tr>
                 <td colspan="2">VEHICULO MARCA: {{ $data['temporal']['marca'] }}</td>
             </tr>
             <tr>
                 <td style="border-right:none; border-bottom:none; border-top:none;">MODELO
                     {{ $data['temporal']['modelo'] }}</td>
                 <td style="border-left:none; border-bottom:none; border-top:none;">TIPO:
                     {{ $data['temporal']['tipo'] }}</td>
             </tr>
             <tr>
                 <td style="border-right:none;">PLACAS: {{ $data['temporal']['placas'] }}</td>
                 <td style="border-left:none;">SERIE: {{ $data['temporal']['numero_serie'] }}</td>
             </tr>
         </table>
         {{-- body table --}}
         @php
             $i = 0;
             $j = 0;
             $contador = 0;
         @endphp
         <table class="tabla_con_border">
             <thead style="background-color:#D5DADB;">
                 <tr>
                     <th style="text-align: center;" colspan="5"><b>ACTIVIDADES</b></th>
                     <th style="text-align: center;" colspan="4"><b>GASOLINA</b></th>
                 </tr>
                 <tr>
                     <th style="text-align: center;">Fecha</th>
                     <th style="text-align: center;">KM inicial</th>
                     <th style="text-align: center;">De:</th>
                     <th style="text-align: center;">A:</th>
                     <th style="text-align: center;">KM final</th>
                     <th style="text-align: center;">VALES</th>
                     <th style="text-align: center;">Litros</th>
                     <th style="text-align: center;">D.V.</th>
                     <th style="text-align: center;">Importe</th>
                 </tr>
             </thead>
             <tbody>
                 @php
                     $n = 0;
                     $valoresImpresos = [];
                     $primeraIteracion = true;
                 @endphp
                 @foreach ($data['recorrido'] as $k => $v)
                     @php
                         if ($primeraIteracion) {
                             # code...
                             $primerValor = $v->kilometraje_inicial; // Obtén el primer valor
                             $primeraIteracion = false; // Marca que ya pasó la primera iteración
                         }
                         $i++;
                         $j++;
                         $contador++;
                         $now = \Carbon\Carbon::parse($v->fecha);
                         $arrayElementos = explode(',', $v->vales);
                         $secuencial = true;
                         // Inicializa arrays para elementos secuenciales y no secuenciales
                         $elementosSecuenciales = '';
                         $elementosNoSecuenciales = '';

                         // Verifica si los elementos están en secuencia
                         $elementoActual = null;
                         $secuenciaActual = '';

                         for ($i = 0; $i < count($arrayElementos) - 1; $i++) {
                             # convertir los elementos en enteros para asegurar que sean números
                             $elementoAct = intval($arrayElementos[$i]);
                             $elementoSig = intval($arrayElementos[$i + 1]);

                             if ($elementoAct + 1 !== $elementoSig) {
                                 # no hay secuencia
                                 $secuencial = false;
                                 break;
                             }
                         }

                         foreach ($arrayElementos as $element) {
                             if ($elementoActual === null) {
                                 # si es primer elemento, inicializa la secuencia
                                 $elementoActual = intval($element);
                                 $secuenciaActual = $elementoActual;
                             } else {
                                 $elementoSiguiente = intval($element);

                                 if ($elementoSiguiente === $elementoActual + 1) {
                                     # Los elementos están en secuencia, agrégalos a la secuencia actual
                                     $elementoActual = $elementoSiguiente;
                                     $secuenciaActual .= ',' . $elementoActual;
                                 } else {
                                     # Los elementos no están en secuencia, agrega la secuencia actual al array correspondiente
                                     if (strlen($secuenciaActual) > strlen($elementosSecuenciales)) {
                                         $elementosSecuenciales = $secuenciaActual;
                                     } else {
                                         if (!empty($elementosNoSecuenciales)) {
                                             $elementosNoSecuenciales .= ',';
                                         }
                                         $elementosNoSecuenciales .= $secuenciaActual;
                                     }
                                     // Inicia una nueva secuencia
                                     $elementoActual = $elementoSiguiente;
                                     $secuenciaActual = strval($element);
                                 }
                             }
                         }

                         if (strlen($secuenciaActual) > strlen($elementosSecuenciales)) {
                             $elementosSecuenciales = $secuenciaActual;
                         } else {
                             if (!empty($elementosNoSecuenciales)) {
                                 $elementosNoSecuenciales .= ',';
                             }
                             $elementosNoSecuenciales .= $secuenciaActual;
                         }
                     @endphp
                     <tr>
                         <td data-label="KM inicial" style="width: 55px; text-align: center;">
                             {{ $now->format('d/m/Y') }}
                         </td>
                         <td data-label="KM inicial" style="width: 40px; text-align: center;">
                             {{ $v->kilometraje_inicial }}
                         </td>
                         <td data-label="De:" style="width: 160px; text-align: left; font-size: 9px;">
                             {{ $v->actividad_inicial }}
                         </td>
                         <td data-label="A:" style="width: 160px; text-align: left;  font-size: 9px;">
                             {{ $v->actividad_final }}
                         </td>
                         <td data-label="KM final" style="width: 40px; text-align: center;">
                             {{ $v->kilometraje_final }}
                         </td>
                         @if (!in_array($v->vales, $valoresImpresos))
                             @if ($secuencial == true)
                                 @if (count($arrayElementos) > 1)
                                     @php
                                         $primerElemento = $arrayElementos[0];
                                         $ultimoElemento = end($arrayElementos);
                                     @endphp
                                     <td data-label="VALES" style="width: 50px; text-align: center;">
                                         {{ $primerElemento . ' al ' . $ultimoElemento }}
                                     </td>
                                 @else
                                     @php
                                         $unicoElemento = $arrayElementos[0];
                                     @endphp
                                     <td data-label="VALES" style="width: 50px; text-align: center;">
                                         {{ $unicoElemento }}
                                     </td>
                                 @endif
                             @else
                                 @php
                                     $elemSec = explode(',', $elementosSecuenciales);
                                     $elemFin = end($elemSec);
                                 @endphp
                                 <td data-label="VALES" style="width: 50px; text-align: center;">
                                     {{ $elemSec[0] . " \nal " . PHP_EOL . $elemFin . ' - ' . $elementosNoSecuenciales }}
                                 </td>
                             @endif
                             <td data-label="Litros" class="celdaAsignado" style="text-align: center;">
                                 {{ $v->litros }}
                             </td>
                             <td data-label="D.V." style="width: 50px; text-align: center;">
                                 @money($v->division_vale)
                             </td>
                             @php
                                 $valoresImpresos[] = $v->vales;
                             @endphp
                         @else
                             <td data-label="VALES" style="width: 75px; text-align: center;">
                             </td>
                             <td data-label="Litros" class="celdaAsignado" style="text-align: center;">
                             </td>
                             <td data-label="D.V." style="width: 50px; text-align: center;">
                             </td>
                         @endif
                         <td data-label="Importe" style="width: 50px; text-align: center;">
                             @money($v->importe)
                         </td>
                     </tr>

                     @if ($n > 30)
                         <div class="page-break"></div>
                     @endif

                     @php
                         $n++;
                     @endphp
                 @endforeach
                 {{--  --}}
                 <tr>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>&nbsp;</td>
                     <td>TOTALES:</td>
                     <td>{{ $data['temporal']['total_km_recorridos'] }} KMS</td>
                     <td>LITROS:</td>
                     <td><b>{{ $data['temporal']['litros_totales'] }}</b></td>
                     <td><b>$ {{ $data['temporal']['importe_total'] }}</b></td>
                     <td>$ {{ $data['temporal']['importe_total'] }}</td>
                 </tr>
             </tbody>
         </table>
         {{-- body table END --}}
         {{-- tag center --}}
         <center class="espaciado">CÁLCULO DEL COMBUSTIBLE A UTILIZAR</center>
         {{-- tag center --}}
         <table class="tabla_con_border">
             <tr>
                 <td colspan="3">CONDUCTOR: {{ $data['temporal']['conductor'] }}</td>
             </tr>
         </table>
         {{-- firmar --}}
         <table class="tablaf">
             <tr>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td align="center">ELABORÓ<br><br><br></td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td align="center">VO.BO.<br><br><br></td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td align="center">RESPONSABLE/COMISIONADO<br><br><br></td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
             </tr>
             <tr>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td align="center"><br>_____________________________________________________</td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td align="center"><br>_____________________________________________________</td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td align="center"><br>____________________________________________________</td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
             </tr>
             <tr>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td align="center" style="padding-top: 10px;">{{ auth()->user()->name }}</td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td align="center" style="padding-top: 10px;">LIC. ISABEL CRISTINA RÍOS MIJANGOS</td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td align="center" style="padding-top: 10px;">{{ $data['temporal']['resguardante_unidad'] }}</td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
             </tr>
             <tr>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td align="center">{{ auth()->user()->puesto }}</td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td align="center">JEFA DEL DEPARTAMENTO DE RECURSOS MATERIALES</td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td align="center">{{ $data['temporal']['puesto_resguardante_unidad'] }}</td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
                 <td> </td>
             </tr>
         </table>
         {{-- NOTAS --}}
         <table class="tablad">
             <tr>
                 <td colspan="3">NOTA: EL LLENADO DE ESTA BITACORA DEBERA SER EN BASE AL RECORRIDO PARA LLEVAR A CABO LA
                     COMISIÓN, EL CUAL SERA REVISADO POR EL AREA DE RECURSOS MATERIALES Y SERVICIOS.</td>
             </tr>
         </table>
         {{-- notas --}}
         <br>
         <table class="tablas_notas">
             <tr>
                 <td colspan="3" style="text-align: center;">
                     <b>PARA USO EXCLUSIVO DEL AREA DE RECURSOS MATERIALES Y SERVICIOS</b>
                 </td>
             </tr>
             <tr>
                 <td style="border-top:none; border-right:none; border-bottom: none; width:15%;">KM INICIAL:</td>
                 <td style="border-left:none; width:20%; text-align: right; border-top:none;">
                     {{ is_null($data['temporal']['km_inicial']) ? $primerValor : $data['temporal']['km_inicial'] }}</td>
                 <td style="width:55%; border-bottom: none; border-top:none;">PUESTO DEL RESGUARDANTE: &nbsp;
                     {{ $data['temporal']['puesto_resguardante_unidad'] }}</td>
             </tr>
             <tr>
                 <td style="border-top:none; border-right:none; width:15%; border-bottom:none;">KM. FINAL:</td>
                 <td style="border-left:none; width:20%; text-align: right;">{{ $data['temporal']['km_final'] }}</td>
                 <td style="width:55%; border-bottom: none; border-top:none;">RESGUARDANTE: &nbsp;
                     {{ $data['temporal']['resguardante_unidad'] }}.</td>
             </tr>
             <tr>
                 <td style="border-top:none; border-right:none; width:15%; border-bottom:none;">KMS. RECORRIDOS:</td>
                 <td style="border-left:none; width:20%; text-align: right;">
                     {{ $data['temporal']['total_km_recorridos'] }}
                 </td>
                 <td style="width:55%;border-top:none;">No. DE UNIDAD O ECONOMICO:
                     {{ $data['temporal']['numero_economico'] }}</td>
             </tr>
             <tr>
                 <td style="border-top:none; border-right:none; width:15%; border-bottom:none;">LTS. DE GASOLINA:</td>
                 <td style="border-left:none; width:20%; text-align: right;">{{ $data['temporal']['litros_totales'] }}
                 </td>
                 <td rowspan="3" style="border-bottom: none; vertical-align: text-top;">OBSERVACIONES: <br>
                     <div style="padding-top: 5px;">
                         {{ $data['temporal']['comentario'] }}
                     </div>
                 </td>
             </tr>
             <tr>
                 <td style="border-top:none; border-right:none; width:15%; border-bottom:none;">RENDIMIENTO POR LTS:</td>
                 <td style="border-left:none; width:20%; text-align: right;">{{ $data['temporal']['rendimiento_mixto'] }}
                 </td>
             </tr>
             <tr>
                 <td style="border-top:none; border-right:none; width:15%; border-bottom:none;"></td>
                 <td style="border-left:none; width:20%;"></td>
             </tr>
             <tr>
                 <td colspan="2" style="text-align: center;">
                     <b>AREA DE RECURSOS MATERIALES Y SERVICIOS</b>
                 </td>
                 <td style="border-top:none;">
                     D.V: DIVISION DEL VALE.
                 </td>
             </tr>
         </table>
     </div>
     {{-- contenido del documento END --}}
 @endsection

 @section('contentJS')
     <script type="text/php">
        if (isset($pdf) ) {
            $font = $fontMetrics->getFont("helvetica", "bold");
            $pdf->page_text(370, 570, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
        }
    </script>
 @endsection
