<?php

namespace App\Http\Controllers;

use Exception;
// use Faker\Provider\Image;
use App\Models\Imagen;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        try {
            $request->validate([
                'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validación de la imagen
            ]);
        
            $comentario = Comentario::findOrFail($request->input('comentario_id'));
        
            // Subir y guardar la imagen
            if ($request->hasFile('imagen')) {
                $ruta = $request->file('imagen')->store('imagenes_comentario', 'public');
                $comentario->imagenes()->create(['ruta' => $ruta]); // Relación con ComentarioImagen
            }
        
            return redirect()->back()->with('success', 'Imagen añadida con éxito.');
            //code...
        } catch (Exception $th) {
            dd($th);
            return redirect()->back()->with('error', 'hubo un error al agregar la Imagen');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Imagen $imagene)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Imagen $imagene)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Imagen $imagene)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
         public function destroy($id)
        {
            try {
                //code...
              //  dd($id);
                $imagen = Imagen::findOrFail($id);
    
                // Elimina el archivo físico
                Storage::disk('public')->delete($imagen->ruta);
    
                // Elimina la entrada en la base de datos
                $imagen->delete();
    
                return redirect()->back()->with('success', 'Imagen eliminada con éxito.');
            } catch (Exception $th) {
                dd($th);
                return redirect()->back()->with('error', 'error hubo un error al eliminar la imagen');
            }
        }
}
