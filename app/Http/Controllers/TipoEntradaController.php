<?php

namespace App\Http\Controllers;

use App\Models\tipo_entrada;
use App\Http\Requests\Storetipo_entradaRequest;
use App\Http\Requests\Updatetipo_entradaRequest;
use Illuminate\Http\Request;

class TipoEntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo_entrada = tipo_entrada::all();
        return view('administracion.tipo_entrada.index', compact('tipo_entrada'));
    }
    public function usuariosIndex()
    {
        $tipo_entrada = tipo_entrada::all();
        return view('usuarios.tipo_entrada', compact('tipo_entrada'));
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
        // Validación de los datos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descripcion' => 'required|string|max:500',
        ]);

        // Crear nueva entrada
        tipo_entrada::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('admin.tipo_entrada.index')->with('success', 'Entrada creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(tipo_entrada $tipo_entrada)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tipo_entrada $tipo_entrada)
    {
        return view('admin.tipo_entrada.edit', compact('tipo_entrada'));
    }

    public function update(Request $request, tipo_entrada $tipo_entrada)
    {
        $request->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'descripcion' => 'required',
        ]);

        $tipo_entrada->update($request->all());

        return redirect()->route('admin.tipo_entrada.index')->with('success', 'Entrada actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tipo_entrada $tipo_entrada)
    {
        $tipo_entrada->delete();
        return redirect()->route('admin.tipo_entrada.index')->with('success', 'Entrada eliminada correctamente');
    }
}