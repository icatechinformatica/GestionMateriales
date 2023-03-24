<form method="POST" action="{{ route('solicitud.comision.validar.bitacora', base64_encode($sqlComisionGetRevision->solicitudId)) }}">
 
    <div class="form-row">
        <div class="col-md-2 mb-3">
            <label for="memo_comision">&nbsp;</label>
            <div class="custom-file">
                <h3><b>REVISADO</b></h3>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="memo_comision">MEMORANDUM DE COMISION No.</label>
            <div class="custom-file">
                <input type="text" name="memo_comision" id="memo_comision" class="form-control" autocomplete="off" value="{{ $sqlComisionGetRevision->memorandum_comision }}" readonly>
                @error('memo_comision')
                    <div class="alert alert-danger mt-1 mb-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div> 
    </div>
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="fecha_comision">Fecha</label>
            <div class="custom-file">
                <input type="date" name="fecha_comision" id="fecha_comision" class="@error('fecha_comision') is-invalid @enderror form-control" value="{{ $sqlComisionGetRevision->fecha }}" disabled>
                @error('fecha_comision')
                    <div class="alert alert-danger mt-1 mb-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="periodo_comision">Periodo</label>
            <div class="custom-file">
                <input type="text" class="form-control" id="periodo_comision" name="periodo_comision" placeholder="click aquí" disabled value="{{ $sqlComisionGetRevision->periodo }}">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="placas_comision">Placas de Vehiculo</label>
            <div class="custom-file">
                <input type="text" class="@error('placas_comision') is-invalid @enderror typeahead form-control" id="placas_comision" name="placas_comision" placeholder="Placas de Vehiculo" autocomplete="off" value="{{ $sqlComisionGetRevision->placas }}" disabled>
                @error('placas_comision')
                    <div class="alert alert-danger mt-1 mb-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="marca_vehiculo">Marca del Vehiculo</label>
            <div class="custom-file">
                <input type="text" class="form-control " id="marca_vehiculo" name="marca_vehiculo" placeholder="Marca del Vehiculo"  readonly value="{{ $sqlComisionGetRevision->marca }}">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="modelo">Modelo</label>
            <div class="custom-file">
                <input type="text" class="form-control " id="modelo" name="modelo" placeholder="Modelo"  readonly value="{{ $sqlComisionGetRevision->modelo }}">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="tipo">Tipo de Vehiculo</label>
            <div class="custom-file">
                <input type="text" class="form-control " id="tipo" name="tipo" placeholder="Tipo de Vehiculo"  readonly value="{{ $sqlComisionGetRevision->tipo }}">
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="color">Color</label>
            <div class="custom-file">
                <input type="text" class="form-control " id="color" name="color" placeholder="Color"  readonly value="{{ $sqlComisionGetRevision->color }}">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="no_serie">N° de Serie</label>
            <div class="custom-file">
                <input type="text" class="form-control" id="no_serie" name="no_serie" placeholder="N° de Serie" readonly value="{{ $sqlComisionGetRevision->numero_serie }}">
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <label for="no_motor">N° de Motor</label>
            <div class="custom-file">
                <input type="text" class="@error('no_motor') is-invalid @enderror form-control " id="no_motor" name="no_motor" placeholder="N° de Motor" readonly value="{{ $sqlComisionGetRevision->numero_motor }}">
                @error('no_motor')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="placas">Responsable de la Unidad</label>
            <div class="custom-file">
                <input type="text" class="form-control" id="responsableUnidad" name="responsableUnidad" readonly value="{{ $sqlComisionGetRevision->resguardante_unidad }}">
            </div> 
        </div>
        <div class="col-md-6 mb-3">
            <label for="placas">Puesto del responsable de la unidad</label>
            <div class="custom-file">
                <input type="text" class="form-control" id="puestoResponsableUnidad" readonly name="puestoResponsableUnidad" readonly value="{{ $sqlComisionGetRevision->puesto_resguardante_unidad }}">
            </div> 
        </div>
    </div>
    <hr>
    <div class="form-row">
        <div class="col-md-8 mb-3">
            <label for="placas">Nombre del Conductor</label>
            <div class="custom-file">
                <input type="text" class="form-control" id="nombreConductor" name="nombreConductor" autocomplete="off" value="{{ $sqlComisionGetRevision->conductor }}" disabled>
            </div> 
        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="kmInicial">Kilometro Inicial</label>
            <div class="custom-file">
                <input type="text" class="form-control" id="kmInicial" name="kmInicial" autocomplete="off" value="{{ $sqlComisionGetRevision->km_inicial }}" disabled>
            </div> 
        </div>
        <div class="col-md-6 mb-3">
            <label for="kmFinal">Kilometro Final</label>
            <div class="custom-file">
                <input type="text" class="form-control" id="kmFinal" name="kmFinal" autocomplete="off" value="{{ $sqlComisionGetRevision->km_final_antes_cargar_combustible }}" disabled>
            </div> 
        </div> 
    </div>
    <input type="hidden" class="form-control" name="idcatvehiculo" id="idcatvehiculo" readonly value="{{ $sqlComisionGetRevision->vehiculoId }}">
    <hr>

    <br>
    {{-- botón de agregar elemento de la bitacora END --}}
    <div class="field_wrapper">
        <table class="table table-bordered" id="recorridotable">
            <thead>
              <tr>
                <th  style="width: 11%;">Fecha</th>
                <th  style="width: 13%;">De:</th>
                <th  style="width: 13%;">a: </th>
                <th style="width: 7%;">Tipo Recorrido</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($recorrido_comision as $k => $i)
               <tr>
                    <td>
                        <input type="date" name="addcomision[{{ $i->id }}][fecha_comision]" class="form-control" value="{{ $i->fecha_comision }}" disabled/>
                    </td>
                    <td>
                        <textarea name="addcomision[{{ $i->id }}][de_comision]" class="form-control" disabled>{{ $i->de_comision }}</textarea>
                    </td>
                    <td>
                        <textarea name="addcomision[{{ $i->id }}][a_comision]" class="form-control" disabled>{{ $i->a_comision }}</textarea>
                    </td>
                    <td data-label="...">
                        <input type="text" name="tipo" id="tipo" value="{{ $i->tipo }}" class="form-control" disabled>
                    </td>
                    <input type="hidden" name="addcomision[{{ $i->id }}][recoridoComision_id]" id="" value="{{ $i->id }}">
                <tr>
              @endforeach 
            </tbody>
        </table>
    </div>
    <hr>

    <br>
    {{-- botón de agregar elemento de la bitacora END --}}
    <div class="table_wrapper">
        <table class="table table-bordered" id="comisiontable">
            <thead>
                <tr>
                  <th  style="width: 11%;">FACTURA</th>
                  <th  style="width: 13%;">LITROS</th>
                  <th  style="width: 13%;">PRECIO UNITARIO</th>
                  <th style="width: 7%;">IMPORTE</th>
                  <th style="width: 7%;">...</th>
                </tr>
            </thead>
            <tbody>
               @if (count($bitacora_comision) > 0)
                  @foreach ($bitacora_comision as $k => $v)
                    <tr>
                        <td>
                            <input type="text" class="form-control" name="addcomisiones[{{ $v->id }}][factura]" id="facturas[]" value="{{ $v->factura_comision }}" disabled/>
                        </td>
                        <td>
                            <input type="text" name="addcomisiones[{{ $v->id }}][litros]" id="litros[]" onchange="calcularLitrosTotales(this);" class="form-control lts_comision" autocomplete="off" value="{{ $v->litros_comision }}" disabled/>
                        </td>
                        <td>
                            <input type="text" class="form-control unitario_precio" name="addcomisiones[{{ $v->id }}][pu]" id="precioUnitario[]" onchange="calcularPrecioUnitario(this);" autocomplete="off" value="{{ $v->precio_unitario_comision }}" disabled/>
                        </td>
                        <td>
                            <input type="text" class="form-control importe" name="addcomisiones[{{ $v->id }}][importe]" id="totalImporte[]" onchange="calcularImporteTotal(this);" autocomplete="off" value="{{ $v->importe_comision }}" disabled/>
                        </td>
                        <td data-label="...">

                        </td>
                        <input type="hidden" name="addcomisiones[{{ $v->id }}][comisionTemporalId]" value="{{ $v->id }}">
                    </tr>
                  @endforeach
               @endif
            </tbody>
        </table>
    </div>
    <div class="table_wrapper">
        <table class="table table-bordered" id="totalesDinamicos">
            <thead>
                <tr>
                    <th>TOTAL DE KILOMETROS</th>
                    <th>LITROS TOTALES</th>
                    <th>IMPORTE TOTAL</th>
                </tr>
            </thead>
            <tbody>
              <tr>
                <td data-label="TOTAL DE KILOMETROS">
                    <input type="text" name="km_totales" id="km_totales"   class="form-control" readonly value="{{ $sqlComisionGetRevision->total_km_recorridos }}"/>
                </td>
                <td data-label="LITROS TOTALES">
                    <input type="text" name="litros_totales" id="litros_totales" class="form-control" readonly value="{{ $sqlComisionGetRevision->litros_totales }}"/>
                </td>
                <td data-label="IMPORTE TOTAL">
                    <input type="text" name="importe_total" id="importe_total" value="{{ $sqlComisionGetRevision->importe_total }}"  class="form-control importe" readonly/>
                </td>
              </tr>
            </tbody>
        </table>
    </div>
    {{-- comentarios --}}
    <div class="form-row">
        <div class="col-md-12 mb-3">
            <label for="placas">OBSERVACIONES</label>
            <div class="custom-file">
                <textarea name="observaciones" id="observaciones" cols="30" rows="5" class="form-control" disabled>{{ $sqlComisionGetRevision->observacion }}</textarea>
            </div> 
        </div>
    </div>
    {{-- comentarios END --}}
    <hr>
    @role('capturista')
        <button class="btn btn-success" type="submit" name="ejecutar" value="enviar">
            <i class="fas fa-paper-plane"></i>
            Enviar
        </button>
    @endrole
    <input type="hidden" name="periodo_comision_actual" id="periodo_comision_actual" value="{{ $sqlComisionGetRevision->periodo_actual }}"/>
    {{-- <input type="hidden" name="solicitudId" id="solicitudId" value="{{ base64_encode($sqlComisionGetRevision->solicitudId) }}"> --}}
    {{-- <input type="hidden" name="pre_comision_id" id="pre_comision_id" value="{{ base64_encode($id_precomision) }}"> --}}
</form>