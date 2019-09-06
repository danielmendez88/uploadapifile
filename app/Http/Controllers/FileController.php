<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\Models\Catalogo\Imagen;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {
            $imagenes = Imagen::all();
            $data = $imagenes->toArray();
            return response()->json($data, 200);
        } catch (Exception $e) {
            return Response::json(['error' => $e->getMessage(), 'code' => 409], 409);
        }
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
    /**
    * @param 
    */
    public function uploadFile(Request $request)
    {
        try {
            $validador = Validator::make($request->all(), [
                'inputFile' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048'
            ]);
            if ($validador->fails()) {
                # mensaje de fallo
                return response()->json(['error' => $validador->errors()], 409);
            } else {
                if ($request->hasFile('inputFile')) {
                    # si se encuentra la imagen comenzamos a subirlo...
                    $file = $request->file('inputFile');
                    $tamanio = $file->getSize();
                    $extensionImagen = $file->getClientOriginalExtension(); // extension de la imagen
                    $destinationPath = public_path('/uploadFiles/'); // upload path
                    $imagenFile = date('YmdHis') . "." . $extensionImagen; // nombre de la imagen al momento de subirla
                    $file->move($destinationPath, $imagenFile); // subir imagen al servidor
                    $imagenUrl = url('/uploadFiles/'.$imagenFile);
                }

                // base de datos
                $imagenDB = new Imagen;
                $imagenDB->nombreArchivo = trim($imagenFile);
                $imagenDB->extensionArchivo = trim($extensionImagen);
                $imagenDB->rutaArchivo = trim($imagenUrl);
                $imagenDB->tamanioArchivo = trim($tamanio);
                $imagenDB->save();

                return response()->json(['success' => 'Archivo subido con éxito. '.$imagenUrl], 200);
            }
        } catch (Exception $e) {
            return Response::json(['error' => $e->getMessage(), 'code' => 409], 409); 
        }
    }
}
