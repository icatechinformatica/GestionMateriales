<?php

namespace App\Http\Controllers\requisicion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\requisicion\Requisicion;
use App\Http\Requests\RequisicionPostRequest;
use Illuminate\Database\QueryException;
use App\Models\requisicion\RequisicionUnidad;
use App\Models\catalogos\Directorio;
use Illuminate\Support\Str;
use App\Models\solicitud\Area;
use App\Models\requisicion\PartidaPresupuestal;
use App\Models\requisicion\Partida;
use App\Models\catalogos\OrganoAdministrativo;

class RequisicionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         // obtener todas las requisiciones
         $requisiciones = Requisicion::with(['memorandum', 'area', 'partidapresupuestal'])->where('id_estado', 6)->get();
         return view('theme.dashboard.layouts.requesicion.requesicion_create')->with('requisiciones', $requisiciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
       return view('theme.dashboard.forms.requisiciones.nueva_requisicion');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequisicionPostRequest $request)
    {
        try {
            //se intenta cargar la información y también los registros de la requisición
            $requisicion = new Requisicion;
            $requisicion->fechaRequisicion = $request->get('fechaRequisicion');
            $requisicion->solicita = $request->get('solicita');
            $requisicion->id_area = $request->get('id_departamento');
            $requisicion->autoriza = $request->get('autoriza');
            $requisicion->justificacion = $request->get('justificacion');
            $requisicion->id_estado = 6;
            $requisicion->save();

            $requisicionId = $requisicion->id;
            /**
             * creamos un arreglo dónde enviaremos la información a guardarse en la tabla pivote
             * se tiene que validar si el arreglo contiene algún registro o si la longitud es mayor a cero
             */
            if (count($request->itemPartida) > 0) {
                # checamos que la condición se cumpla para ingresar a los bucles
                $array_counter = count($request->itemPartida);
                for ($j=1; $j <= $array_counter; $j++) {
                    // vamos a insertar el registro y obtenemos el id
                    $getIdPartida = PartidaPresupuestal::insertGetId([
                        'partida_presupuestal' => $request->itemPartida[$j]['partida_presupuestal'],
                        'concepto' => $request->itemPartida[$j]['concepto'],
                        'id_partida' => $request->itemPartida[$j]['id_partida_presupuestal'],
                        'id_requisicion' => $requisicionId,
                    ]);
                    # checamos el ciclo para obtener los dos primeros arreglos principales
                    foreach ($request->itemPartida[$j] as $key => $value) {
                        # imprimimos en un foreach
                        if (is_array($value) || is_object($value)) {
                            # es un arreglo entonces vamor a actualizar un contador
                            $reqUnidad = new RequisicionUnidad([
                                'cantidad' => $value['cantidad'],
                                'unidad' => $value['unidad'],
                                'descripcion' => $value['descripcion'],
                                'id_partida_presupuestal' => $getIdPartida,
                            ]);
                            $reqUnidad->save();
                        }
                    }
                }
            }

            // redireccionamiento
            return redirect()->route('requisicion.index')->with('success', sprintf('REQUISICIÓN DE MATERIAL AGREGADO EXÍTOSAMENTE!'));

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
        $req = base64_decode($id);
        $requisicion_editar = Requisicion::with(['memorandum', 'area', 'partidapresupuestal', 'partidapresupuestal.requisicionunidad'])->where('id', $req)->first();
        return view('theme.dashboard.layouts.requesicion.edit.requisicion_edit')->with('requisicion_editar', $requisicion_editar);
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
        // actualizar el registro de la requisición
        try {
            $idReq = base64_decode($id);
            Requisicion::WHERE('id', $idReq)
            ->update(['id_estado' => 1]);
            //enviar al indice
            return redirect()->route('requisicion.index')->with('info', sprintf('¡REQUISICIÓN ENVIADA CON ÉXITO!'));
        } catch (QueryException $ex) {
            //cachando excepcion y retornando a la vista
            return back()->with('error', $ex->getMessage());
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
    }

    public function getsolicita(Request $request){
        $termino = Str::upper($request->term);

        $data = Directorio::select("nombre")
                ->where("nombre","LIKE","%{$termino}%")
                ->get();

        $array_name = array();
        foreach ($data as $hsl)
        {
            $array_name[] = $hsl->nombre;
        }

        return response()->json($array_name);
    }

    public function getdepto(Request $request){
        $termino = Str::upper($request->term);

        $data = Area::select("id","nombre")
                ->where("nombre","LIKE","%{$termino}%")
                ->get();

        $array_name = [];
        foreach ($data as $hsl)
        {
            $array_name[] = array(
                "value" => $hsl->nombre,
                "id" => $hsl->id,
            );
        }

        return response()->json($array_name);
    }

    public function modify(RequisicionPostRequest $request, $id)
    {
        try {
            //carga de datos - información
            $data = [
                'fechaRequisicion' => $request->get('fechaRequisicion'),
                'partida_presupuestal' => $request->get('partida_presupuestal'),
                'concepto' => $request->get('concepto'),
                'solicita' => $request->get('solicita'),
                'id_area' => $request->get('id_departamento'),
                'autoriza' => $request->get('autoriza'),
            ];
            // actualizar registro con $id
            $requisicionUpdate = Requisicion::whereId($id)->first();
            $requisicionUpdate->update($data);
            //checamos si hay más de un item para "actualizar"
            if (count($request->itemRequisicion) > 0) {
                //borrar los registros previos guardados -  relacionados
                $requisicionUpdate->requisicionunidad()->delete();

                $itemReqUpdate = [];
                foreach ($request->itemRequisicion as $key => $value) {
                    # bucle para cargar los datos que vienen del formulario de captura
                    $reqUpdate = new RequisicionUnidad;
                    $reqUpdate->cantidad = $value['cantidad'];
                    $reqUpdate->unidad = $value['unidad'];
                    $reqUpdate->descripcion = $value['descripcion'];
                    $reqUpdate->justificacion = $value['justificacion'];
                    // guardar el registro
                    $itemReqUpdate[] = $reqUpdate;
                }
                /**
                 * guardarmos los registros completos Many to Many
                 */
                $requisicionUpdate->requisicionunidad()->saveMany($itemReqUpdate);
                /**
                 * limpiamos el arreglo
                 */
                unset($itemReqUpdate);
            }
            // redireccionamos
            return redirect()->route('requisicion.index')->with('warning', sprintf('¡REGISTROS DE LA REQUISICIÓN ACTUALIZADOS!'));
        } catch (QueryException $ex) {
            //cachando excepcion y retornando a la vista
            return back()->with('error', $ex->getMessage());
        }

    }

    public function getcatalogo(Request $request){
        $busqueda = Str::upper($request->term);
        $datos = Partida::select('id', 'descripcion', 'clave_partida')
                    ->where("clave_partida", $busqueda)
                    ->get();

        $array_result = [];

        foreach ($datos as $key) {
            # bucle para cargar el arreglo
            $array_result[] = array(
                "value" => $key->clave_partida,
                "id" => $key->id,
                "descripcion" => $key->descripcion,
            );
        }

        return response()->json($array_result);
    }

    protected function getArea(Request $request){
        $Qry = Str::upper($request->term);
        $data = OrganoAdministrativo::select("id","nombre", "descripcion")
                ->where("nombre","LIKE","%{$Qry}%")
                ->get();

        $arr_name = [];

        foreach ($data as $orgadmin) {
            # blucle para sacar la información y pasarlo a un arreglo
            $arr_name[] = array(
                "value" => $orgadmin->nombre,
                "id" => $orgadmin->id,
            );
        }

        return response()->json($arr_name); //enviamos el arreglo en un formato json como respuesta
    }

    protected function getDeptos($iddepto){
        $deptos = Area::where('organo_administrativo_id', '=', $iddepto)->get();
        return response()->json($deptos);
    }
}
