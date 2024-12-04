<?php

namespace App\Http\Controllers;

//use App\Models\comunidad;
use App\Models\comunidad;
use App\Models\RutaTuristica;
use Exception;
use Illuminate\Http\Request;
//use App\Models\RutaTuristica;

class RutaTuristicaController extends Controller
{
    // Método para mostrar las rutas y el formulario de creación al administrador
    public function adminIndex()
    {
        $rutas = RutaTuristica::with('comunidad')->get(); // Obtiene todas las rutas con sus comunidades
        
        $comunidades = comunidad::all(); // Obtiene todas las comunidades para el formulario
        
        return view('administracion.rutas.admin',compact('comunidades','rutas'));
    }
    
    // Método para almacenar una nueva ruta en la base de datos
    public function store(Request $request)
    {
        try {
            //code...
            $request->validate([
                'nombre' => 'required|string|max:255',
                'comunidad_id' => 'required|exists:comunidads,id', // Cambiado a "comunidads" en la validación
    
            ]);
    
            RutaTuristica::create([
                'nombre' => $request->nombre,
                'comunidad_id' => $request->comunidad_id,
                'disponibilidad'=>'DISPONIBLE'
            ]);
    
            return redirect()->route('admin.rutas.index')->with('success', 'Ruta creada exitosamente.');
        } catch (Exception $th) {
            return redirect()->route('admin.rutas.index')->with('error', 'error...hubo un error al crear las rutas.');
        }
    }

    // Método para mostrar las rutas al usuario sin opciones de edición
    public function userIndex()
    {
        $rutas = RutaTuristica::with('comunidad')->get();
        return view('administracion.rutas.user', compact('rutas'));
    }

    // Método para mostrar una ruta específica con su comunidad
    public function show($id)
    {
        // Encuentra una ruta específica y carga la comunidad asociada
        $ruta = RutaTuristica::with('comunidad')->findOrFail($id); // Usar "with" para cargar la relación

        // Retorna la vista 'ruta.show' con los datos de la ruta y su comunidad
        return view('ruta.show', compact('ruta'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        try {
            //code...
            $request->validate([
                'nombre' => 'required|string|max:255',
                'comunidad_id' => 'required|exists:comunidads,id',
            ]);
    
            $ruta = RutaTuristica::findOrFail($id);
            $ruta->update([
                'nombre' => $request->nombre,
                'comunidad_id' => $request->comunidad_id,
                'disponibilidad'=>$request->disponibilidad
            ]);
            return redirect()->route('admin.rutas.index')->with('success', 'Ruta actualizada exitosamente.');
        } catch (Exception $th) {
            return redirect()->route('admin.rutas.index')->with('error', 'hubo un error al actualizar la ruta.');
        }
    }

    // Método para eliminar una ruta
    public function destroy($id)
    {
        $ruta = RutaTuristica::findOrFail($id);
        $ruta->delete();

        return redirect()->route('admin.rutas.index')->with('success', 'Ruta eliminada exitosamente.');
    }

}
