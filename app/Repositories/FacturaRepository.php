<?php
namespace App\Repositories;

use App\Interfaces\FacturaRepositoryInterface;
use App\Models\catalogos\Denominaciones;
use App\Models\factura_folio\Factura;
use App\Models\factura_folio\FacturaDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class FacturaRepository implements FacturaRepositoryInterface {
    public function createFactura(Request $facturaData): bool
    {
        //Log::debug("Mensaje", [json_decode($facturaData['itemsData'])]);
        // print_r($facturaData->all());
        //se realiza el guardado de datos
        $nuevaFactura = new Factura;
        $nuevaFactura->certificado_emisor = strtoupper($facturaData['certificado_emisor']);
        $nuevaFactura->folio_fiscal = strtoupper($facturaData['folio_fiscal']);
        $nuevaFactura->certificado_sat = strtoupper($facturaData['certificado_sat']);
        $nuevaFactura->tipo_comprobante = strtoupper($facturaData['tipo_comprobante']);
        $nuevaFactura->fecha_emision	 = date('Y-m-d h:i:s', strtotime($facturaData['fecha_emision']));
        $nuevaFactura->fecha_certificacion = date('Y-m-d h:i:s', strtotime($facturaData['fecha_certificacion']));
        $nuevaFactura->serie = strtoupper($facturaData['serie_folio']);
        $nuevaFactura->id_catproveedor = $facturaData['proveedor'];
        $nuevaFactura->save(); // se guardan los registros
        // retornamos un id que guarda * sólo en esta función
        $lastId = $nuevaFactura->id;

        $arrData =  html_entity_decode($facturaData['itemsData']); // Convierte todas las entidades HTML a sus caracteres correspondientes
        $arrayway = json_decode($arrData, true);
        // Log::debug("index",[$arrayway]);

        foreach ($arrayway as $index => $value) {
            # vamos a insertar en bitacora comision temporal
            $facturaDetalle = new FacturaDetalle;
            $facturaDetalle->factura_id = $lastId;
            $facturaDetalle->clave_producto = strtoupper($value['claveProducto']);
            $facturaDetalle->cantidad = $value['cantidad'];
            $facturaDetalle->clave_unidad = strtoupper($value['claveUnidad']);
            $facturaDetalle->descripcion = strtoupper($value['descripcion']);
            $facturaDetalle->valor_unitario = $value['valorUnitario'];
            $facturaDetalle->impuestos = $value['impuestos'];
            $facturaDetalle->importe = $value['importe'];

            // guardando el resgistro
            $facturaDetalle->save();
        }

        return true;
    }

    public function facturaAll(Request $request): LengthAwarePaginator {
        /**
         * obtenemos todas las facturas con un poco con paginación
         */
        return Factura::with("proveedores")->paginate(
            $perPage = 15, $columns = ['*'], $pageName = 'factura'
        );
    }

    public function getFactura($id) {
        $idfactura = base64_decode($id);
        return Factura::with(["facturadetalles", "proveedores"])->where('id', $idfactura)->first();
    }

    public function updateFactura($id, Request $request) {
        $idfactura = base64_decode($id);
        return Factura::where('id', $idfactura)->update([
            'certificado_emisor' => strtoupper($request->get('certificado_emisor')),
            'folio_fiscal' => strtoupper($request->get('folio_fiscal')),
            'certificado_sat' => strtoupper($request->get('certificado_sat')),
            'tipo_comprobante' => strtoupper($request->get('tipo_comprobante')),
            'fecha_emision'	 => date('Y-m-d h:i:s', strtotime($request->get('fecha_emision'))),
            'fecha_certificacion' => date('Y-m-d h:i:s', strtotime($request->get('fecha_certificacion'))),
            'serie' => strtoupper($request->get('serie_folio')),
            'id_catproveedor' => $request->get('proveedor'),
            'subtotal' => $request->get('subtotal'),
            'impuestos_trasladados' => $request->get('impuestos_trasladados'),
            'total' => $request->get('total'),
        ]);
        // actualizar registro de la tabla
    }

    public function addDetalle(Request $request): bool
    {
        if (!empty($request['FormDetalleFactura'])) {
            // Hacer cosas porque el $miArray tiene elementos
            $idfactura = base64_decode($request['FormDetalleFactura']);
            $detalleFactura = new FacturaDetalle();

            $detalleFactura->factura_id = $idfactura;
            $detalleFactura->clave_producto = strtoupper($request['clave_producto']);
            $detalleFactura->cantidad = $request['cantidad'];
            $detalleFactura->clave_unidad = strtoupper($request['clave_unidad']);
            $detalleFactura->descripcion = strtoupper($request['descripcion']);
            $detalleFactura->valor_unitario = $request['valor_unitario'];
            $detalleFactura->impuestos = $request['impuestos'];
            $detalleFactura->importe = $request['importe'];

            // guardando el resgistro
            $detalleFactura->save();

            /**
             * operación de ejecución de calculo
             */
            $impuestoTrasladado = json_decode(html_entity_decode($request['impuestoTrasladado']));
            $subtotal = json_decode(html_entity_decode($request['subtotal']));
            $totalFactura = json_decode(html_entity_decode($request['totalFactura']));

            $imp_trasladado = floatval($impuestoTrasladado) + floatval($request['impuestos']);
            $sbtotal = floatval($subtotal) + floatval($request['valor_unitario']);

            $tt = $imp_trasladado + $sbtotal;
            // actualizar registros en factura
            Factura::where('id', $idfactura)->update([
                'subtotal' => number_format($sbtotal, 2, '.', ''),
                'impuestos_trasladados' => number_format($imp_trasladado, 2, '.', ''),
                'total' => number_format($tt, 2, '.', '')
            ]);

            return true;

        } else {
            return false;
        }
    }

    public function eliminarDetalleFactura($id): int
    {
        $idDetalleFactura = base64_decode($id); // id factura detalle
        // obteniendo los campos necesarios para hacer el calculo desde la tabla FacturaDetalle
        $fd = FacturaDetalle::with("facturas")->where('id', $idDetalleFactura)->first();
        // obtendo los valores a módidifcar convertir valores a flotantes, como ya se encuentran en decimales no pasa nada
        $valorUnitario = floatval($fd->valor_unitario);
        $imp = floatval($fd->impuestos);

        $subT = floatval($fd->facturas->subtotal);
        $impTrasladados = floatval($fd->facturas->impuestos_trasladados);

        // realizar el calculo el reajuste a los cambios en Factura y la eliminación del elemento seleccionado
        $nsubtotal = $subT - $valorUnitario;
        $nimpuestosT = $impTrasladados - $imp;

        $ntotal = $nsubtotal + $nimpuestosT;

        // actualizar registros en factura
        Factura::where('id', $fd->factura_id)->update([
            'subtotal' => number_format($nsubtotal, 2, '.', ''),
            'impuestos_trasladados' => number_format($nimpuestosT, 2, '.', ''),
            'total' => number_format($ntotal, 2, '.', '')
        ]);

        // eliminar registro
        $res = FacturaDetalle::destroy($fd->id);

        if ($res) {
            # si es verdadero envío el id de la factura
            return $fd->factura_id;
        } else {
            return 0;
        }
    }

    public function getFacturaDetalle() {
        // return FacturaDetalle::where('clave_unidad', 'H87')->pluck('descripcion', 'id');
        return Denominaciones::pluck('denominacion', 'valor')->toArray();
    }

    public function checkFactura(){
        // obtener sólo las facturas que tienen folios cargados y con status
        return Factura::with(['folios' => function ($query) {
            $query->where('status', '=', 'DISPONIBLE');
            $query->orderBy('created_at', 'asc');
        }])->pluck('serie', 'id')->toArray();
    }

    public function getAllFacturas(Request $request){
        /**
         * get all object from factura
         */
        $Qry = Factura::select('serie')->where('serie', 'LIKE', '%'.$request->get('query').'%')->get();
        $json = [];
        foreach ($Qry as $value) {
            $json[] = $value->serie;
        }

        return json_encode($json);
    }
}
