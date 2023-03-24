<?php

namespace App\Http\Controllers\requisicion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\requisicion\Momorandum;
use Illuminate\Database\QueryException;
use App\Http\Requests\MemoRequest;
use App\Models\requisicion\Requisicion;
use App\Http\Requests\FileRequest;
use Illuminate\Support\Facades\Storage;

class MemoController extends Controller
{
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
    public function create($idrequisicion)
    {
        $id = base64_decode($idrequisicion);
        // creamos el enlace para conectarnos con el memo
        return view('theme.dashboard.layouts.requesicion.memo_requisicion', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileRequest $request)
    {
        //se enviará a guardar el registro
        try {
            $id = base64_decode($request->get('idRequisicion'));
            /**
             * nuevo código para cargar un archivo al servidor
             */
            if ($request->file('textmemorandum')) {
                $file = $request->file('textmemorandum');
                # si contiene un archivo entramos a generar la operación
                $nombreArchivo = time().'_'.'MEMORANDUM_DOCUMENTO_ID_'.$id.'.'.$file->getClientOriginalExtension();
                $requisicion = Requisicion::findOrFail($id);
                //ruta
                $rutaArchivo = $request->file('textmemorandum')->storeAs('uploads', $nombreArchivo, 'public');
                //código para cargar el memorandum
                $nuevo_memo = new Momorandum;
                $nuevo_memo->memorandum = '/app/public/'.$rutaArchivo;
                $nuevo_memo->tipo = $nombreArchivo;
                $nuevo_memo->extension = $file->getClientOriginalExtension();
                $nuevo_memo->cargado = true;

                // guardar el memorandum con la requisición que corresponde
                $requisicion->memorandum()->save($nuevo_memo);

                return redirect()->route('requisicion.index')->with('success', sprintf('¡EL ARCHIVO FUE SUBIDO SATISFACTORIAMENTE!'));
            }
            
        } catch (QueryException $ex) {
            //cachando la excepcion sql
            return back()->with('error', $ex->getMessage());
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
        $id_requisicion = base64_decode($id);
        
        $getMemo = Momorandum::WHERE('id_requisicion',$id_requisicion)->get();
        // mostramos la vista del dato y las funciones para el memorandum
        return view('theme.dashboard.layouts.requesicion.edit.memorandum_edit', compact('id_requisicion', 'getMemo'));
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
        // modificaciones vamos a eliminar el archivo guardado en la carpeta uploads y vamos a reemplazarla por la que subimos

        try {
            $idReq = base64_decode($request->get('idRequisicion')); // id requisicion
            /**
             * vamos a eliminar el archivo por la forma File System
             */
            $getMemo = Momorandum::where('id_requisicion', $idReq)->first();
            $path = storage_path('app\\public\\uploads\\'.$getMemo->tipo);
            if (\File::exists($path)) {
                # si el archivo existe se eliminará
                \File::delete($path);

            } else {
                // enviar mensaje de error
                return back()->with('error', 'El archivo no existe');
            }
            // actualizar el registro
            if ($request->file('memoupdate')) {
                # si el archivo de la solicitud existe vamor a actualiza el registro
                $archivo = $request->file('memoupdate');
                # si contiene un archivo entramos a generar la operación
                $nombreArchivo = time().'_'.'MEMORANDUM_DOCUMENTO_ID_'.$idReq.'.'.$archivo->getClientOriginalExtension();
                // obtener la ruta
                $rutaArchivo = $request->file('memoupdate')->storeAs('uploads', $nombreArchivo, 'public');
                $array = [
                    'memorandum' => '/app/public/'.$rutaArchivo,
                    'tipo' => $nombreArchivo,
                    'extension' => $archivo->getClientOriginalExtension(),
                ];
            }
            //modificación del memorandum
            Momorandum::WHERE('id_requisicion', $idReq)->update($array);
            // redireccionar
            return redirect()->route('requisicion.index')->with('warning', sprintf('¡MEMORANDUM ACTUALIZADO EXÍTOSAMENTE!'));
        } catch (QueryException $th) {
            //cachando excepciones sql
            return back()->with('error', $th->getMessage());
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

    public function download($idmemo)
    {
        $id = base64_decode($idmemo);
        $memorandum = Momorandum::findOrFail($id)->first();
        $path = storage_path('app\\public\\uploads\\'.$memorandum->tipo);
        if (!\File::exists($path)) {
            abort(404);
        }

        $file = \File::get($path);
        $type = \File::mimeType($path);
        $response = \Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}
