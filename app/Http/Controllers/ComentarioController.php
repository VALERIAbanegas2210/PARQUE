<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     * para mostrar todos los comentarios de una comunidad
     */
    public function index($idComunidad)
    {
        /*$comunidad=Comentario::findOrFail($idComunidad);
        $comentarios=$comunidad->comentarios;
        
        switch ($comunidad) {
            //mataracu
            case 1:
                # code...
                return view('comunidad.show_villa_amoboro',compact('comentarios'));
            //la chonta
            case 2:
                    # code..
                    return view('comunidad.show_la_chonta',compact('comentarios'));    
            //oriente
            case 3:
                    # code...
                    return view('comunidad.show_oriente',compact('comentarios'));
                break;
            //jardin de las delicias
            case 7:
                    # code...
                    return view('comunidad.show_jardin_de_las_delicias',compact('comentarios'));
            //villa amboro
            case 5:
                return view('comunidad.show_villa_amoboro',compact('comentarios'));
            default:
                # mandamos error
                break;
        }*/
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
     * para almacenar un comentario en una comunidad
     */
        public function store(Request $request)
        {
            //valido los comentarios
            
            $request->validate([
                'descripcion' => 'required|string|max:500',
                'puntuacion' => 'required|integer|min:0|max:5',
            ]);
            
            //creo el comentario
            Comentario::create([
                'descripcion' => $request->input('descripcion'),
                'puntuacion' => $request->input('puntuacion'),
                'comunidad_id' => $request->input('comunidad_id'),
                'usuario_id' => Auth::id(), // ID del usuario autenticado
            ]);
        
            return redirect()->back()->with('success', 'Comentario añadido con éxito.');

        }

    /**
     * Display the specified resource.
     */
    public function show(Comentario $comentario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comentario $comentario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $idComentario)
    {
        
        //validaciones al momento de actualizar
//        dd($request->all());
        $request->validate([
            'descripcion' => 'required|string|max:500',
            'puntuacion' => 'required|integer|min:0|max:5',
        ]);
    
        $comentario = Comentario::findOrFail($idComentario);
    
        // Verificar que el usuario sea el autor
        if ($comentario->usuario_id !== Auth::id()) {
            return redirect()->back()->with('error', 'No tienes permisos para editar este comentario.');
        }
    
        $comentario->update($request->only('descripcion', 'puntuacion'));
    
        return redirect()->back()->with('success', 'Comentario actualizado con éxito.');
    }
    //para actualizar como admin,no pregunto lo de si es usuario o no
    public function updateForAdmin(Request $request, $idComentario)
    {   
        
        // Validaciones al momento de actualizar
        $request->validate([
            'descripcion' => 'required|string|max:500',
            'puntuacion' => 'required|integer|min:0|max:5',
        ]);

        // Buscar el comentario por ID
        $comentario = Comentario::findOrFail($idComentario);

        // Actualizar el comentario sin restricciones de usuario
        $comentario->update($request->only('descripcion', 'puntuacion'));

        return redirect()->back()->with('success', 'Comentario actualizado con éxito.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $comentario=Comentario::findOrFail($id);
        $comentario->delete();
        return redirect()->back()->with('success', 'Comentario borrado con éxito.');

    }

    public function destroyForAdmin($id)
    {
        $comentario=Comentario::findOrFail($id);
        $comentario->delete();
        return redirect()->back()->with('success', 'Comentario borrado con éxito.');

    }
}
