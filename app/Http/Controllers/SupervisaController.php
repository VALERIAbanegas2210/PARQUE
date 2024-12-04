<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Supervisa;
use Illuminate\Http\Request;

class SupervisaController extends Controller
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
        //valido los datos
        $request->validate([
            'guardaparque_id'=>'required|exists:guardaparques,id',
            'comunidad_id' => 'required|exists:comunidads,id',
            'dias' => 'required|array',
            'dias.*' => 'exists:dias,id',
            'hora_inicio_*' => 'required|nullable|date_format:H:i',
            'hora_fin_*' => 'required|nullable|date_format:H:i|after:hora_inicio_*',
        ]);

        
        try {
            $supervisaId =0;
            $idGuarda=$request->input('guardaparque_id');
            $idComunidad=$request->input('comunidad_id');
            $existeLaAsignacion=Supervisa::where('guardaparque_id',$idGuarda)->where('comunidad_id',$idComunidad)->exists();   
            if(!$existeLaAsignacion){
                //primero creo el supervisa
                $supervisa = new Supervisa();
                //le seteo la foranea de guardaparque(guardaparqur_id) desde el input con el guardaparque_id
                $supervisa->guardaparque_id = $idGuarda;   
                //lo mismo ,pero esta vez le seteo la foranea de comunidad(comunidad_id) desde el input con comunidad_id
                $supervisa->comunidad_id = $idComunidad;
                //guardo en la bd
                $supervisa->save();
                $supervisaId = $supervisa->id;
            }else{
                //agarro el id que existe
                $supervisaId=Supervisa::where('guardaparque_id',$idGuarda)->where('comunidad_id',$idComunidad)->first()->id;
                //return redirect()->back()->with('error', 'la comunidad asignada ya tiene un horario,verifiquelo..' );
            }
            //faltaria validar los dias

            // Paso 3: Crear los horarios asociados a `supervisa`

            //ahora lo que hago es para cada dia creo un nuevo objeto horario
            //con el id correspondiente

            //lo creo con la llave del supervisa para hacer notar que de el son los horarios
            $dias = $request->input('dias');
            foreach ($dias as $diaId) {
                // Crear un nuevo registro en la tabla `horarios` por cada día seleccionado
                $horario = new Horario();
                $horario->supervisa_id = $supervisaId;
                $horario->dia_id = $diaId;
                $horario->hora_inicio = $request->input('hora_inicio_' . $diaId);
                $horario->hora_fin = $request->input('hora_fin_' . $diaId);
                $horario->save();
            }

            return redirect()->back()->with('success', 'Asignación creada exitosamente.');
        } catch (\Exception $e) {
            //dd($e);
            return redirect()->back()->with('error', 'Hubo un problema al crear la asignación: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supervisa $supervisa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supervisa $supervisa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supervisa $supervisa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Encuentra el objeto supervisa
            $supervisa = Supervisa::findOrFail($id);
            //lo elimino y por cascada deberia borrar
            $supervisa->delete();

            //en el caso de no pillar o algun otro error entonces mando un error 
            return response()->json(['success' => 'Asignación eliminada correctamente.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo eliminar la asignación.'], 500);
        }
    }
}
