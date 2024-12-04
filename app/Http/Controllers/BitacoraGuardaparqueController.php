<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Bitacora_Guardaparque;

class BitacoraGuardaparqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener la lista de bitácoras paginada, 10 registros por página
        $bitacoras = Bitacora_Guardaparque::paginate(10);

        // Retornar una vista con la lista de bitácoras paginadas
        return view('administracion.guardaparques.indexBitacoraGuardaparque', compact('bitacoras'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($idGuardaparque)
    {
        // Hacer la consulta nativa a la base de datos
        $bitacora = DB::select('SELECT * FROM bitacora__guardaparques WHERE id_guardaparque = ?', [$idGuardaparque]);

        // Pasar los resultados a la vista
        return view('administracion.guardaparques.BitacoraGuardaParqueSeleccionado', ['bitacora' => $bitacora]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bitacora_Guardaparque $bitacora_Guardaparque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bitacora_Guardaparque $bitacora_Guardaparque)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bitacora_Guardaparque $bitacora_Guardaparque)
    {
        //
    }
}
