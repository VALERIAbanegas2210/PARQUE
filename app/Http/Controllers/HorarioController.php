<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Http\Request;

class HorarioController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Horario $horario)
    {
        //
    }

    public function get($id){
        try {
            // Encontrar el horario por su ID
            $horario = Horario::findOrFail($id);
            return response()->json($horario, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se encontró el horario.'], 404);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horario $horario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request)
    {
        try {
            // Validar los datos del request
           // dd($request->all());
           //dd($request->all());
            $request->validate([
                'dia_id' => 'required|exists:dias,id',
                'hora_inicio' => 'required|date_format:H:i',
                'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            ]);

            // Encontrar el horario por su ID
            //dd($id) ;
            $horario = Horario::findOrFail($id);

            // Actualizar los datos del horario
            $horario->dia_id = $request->dia_id;
            $horario->hora_inicio = $request->hora_inicio;
            $horario->hora_fin = $request->hora_fin;
            $horario->save();

            // Retornar una respuesta JSON para el fetch en el frontend
            /*return response()->json([
                'success' => true,
                'message' => 'Horario actualizado con éxito.'
            ]);*/
            return redirect()->back()->with('success', 'Horario actualizado con éxito.');
        } catch (\Exception $e) {
            /*return response()->json([
                'success' => false,
                'message' => 'Hubo un error al actualizar el horario.',
                'error' => $e->getMessage()
            ], 500);*/
            //dd($e);
            return redirect()->back()->with('error', 'error al actualizar horario..');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $horario=Horario::findOrFail($id);
            $horario->delete();
            return response()->json(['success' => 'Asignación eliminada correctamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Hubo un error en la eliminacion de horario..'], 500);
        }
    }
}
