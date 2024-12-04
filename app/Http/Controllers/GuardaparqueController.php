<?php

namespace App\Http\Controllers;

use App\Models\Dia;
use App\Models\usuario;
use App\Models\comunidad;
use App\Models\Guardaparque;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\TryCatch;

class GuardaparqueController extends Controller
{
    /**
     * Mostrar una lista de los guardaparques.
     */
    public function index()
    {
         // Obtener todos los usuarios que tienen el rol de "guardaparque"
        $usuariosGuardaparques = usuario::role(['guardaparque'])->pluck('id'); // Obtener solo los IDs de los usuarios con rol 'guardaparque'
        //dd($usuariosGuardaparques);
        // Buscar los guardaparques que tienen un ID en la lista de IDs de usuarios con el rol 'guardaparque'
        $guardaparques = Guardaparque::whereIn('id', $usuariosGuardaparques)->get();
        //$guardaparques=Guardaparque::all();
        //dd($guardaparques);
        #$guardaparques = Guardaparque::all();


        return view('administracion.guardaparques.indexGuarda', compact('guardaparques'));
    }

     /**
     * Mostrar el formulario para crear un nuevo guardaparque.
     */
    public function create()
    {
        return view('administracion.guardaparques.crearGuardaparque');
    }

    /**
     * Almacenar un nuevo guardaparque en la base de datos.
     * y almacena un usuario en la tabla usuario, con rol de guardaparque
     */
    public function store(Request $request)
    {   
        //dd($request->all());
        //validacion
        try{
            DB::beginTransaction();
            $request->validate([
                'CI' => 'required|string|max:255',
                'nombre' => 'required|string|max:255',
                'edad' => 'required|integer|min:3',
                'sexo' => 'nullable|string|max:10',
                'correo' => 'required|email|unique:guardaparques',
                'nroCelular' => 'required|string|max:15',
                'contraseña' => 'required|string|min:4',
            ]);
            
            //creo un usuario con las caracteristicas del guardaparque,por defecto el usuario sera portador de usuario,entonces lo eliminamos ese rol por defecto
            $usuario = Usuario::create([
                'nombre' => $request->nombre,
                'usuario' => $request->nombre,
                'correo' => $request->correo,
                'contraseña' => Hash::make($request->contraseña),
                'ci' => $request->CI,
                'edad' => $request->edad,
                'sexo' => $request->sexo,
                'pasaporte' => null,
                'nacionalidad' => 'Bolivia',
                'profile_image' => null,
                'nroCelular'=>$request->nroCelular
            ]);

            $guardaparque=Guardaparque::create([
                'id'=>$usuario->id,
                'CI' => $request->CI,
                'nombre' => $request->nombre,
                'edad' => $request->edad,
                'sexo' => $request->sexo,
                'correo' => $request->correo,
                'nroCelular' => $request->nroCelular,
                'contraseña' => $usuario->contraseña,
            ]);
            
            
    
            if($usuario->hasRole('usuario')){
                $usuario->removeRole('usuario');
            }
            // Asignar el rol 'guardaparque'
            $usuario->assignRole('guardaparque');
        }catch(Exception $e){
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'error al crear Guardaparque.');    
        }
        DB::commit();
        return redirect()->back()->with('success', 'Guardaparque creado con éxito.');
    }

    //mediante el id del Usuario yo sacare el carnet
    //aqui lo que hago es mostrar el horario que tiene el guardaparque
    public function showModificado($idUsuario){

        $usuario=usuario::findOrFail($idUsuario);
        //quizas se vaya si se implementa la supuesta herencia
        //$carnetUsuario=$usuario->ci;
        //$guardaparque=Guardaparque::where('CI',$carnetUsuario)->first();
        $guardaparque=Guardaparque::findOrFail($idUsuario);
        $idGuardaparque=$guardaparque->id;

        //$lugaresHorariosAsignadosAGuardaparque=DB::select('CALL OBTENER_COMUNIDADES_Y_HORARIO_DE_GUARDAPARQUES(?)',[$idGuardaparque]);
        $lugaresHorariosAsignadosAGuardaparque=Guardaparque::obtenerComunidadesYHorarios($idGuardaparque);
          // Convertir horas de 'H:i:s' a 'H:i'
          /*foreach ($lugaresHorariosAsignadosAGuardaparque as $asignacion) {
            $asignacion->HORA_INICIO = substr($asignacion->HORA_INICIO, 0, 5); // Extraer 'H:i'
            $asignacion->HORA_FIN = substr($asignacion->HORA_FIN, 0, 5);       // Extraer 'H:i'
        }*/

         $comunidadesAsignadas = DB::select("
        SELECT supervisas.id AS supervisa_id, comunidads.nombre AS comunidad_nombre 
        FROM guardaparques
        JOIN supervisas ON guardaparques.id = supervisas.guardaparque_id
        JOIN comunidads ON supervisas.comunidad_id = comunidads.id
        WHERE guardaparques.id = ?", [$idGuardaparque]);

        return view('administracion.guardaparques.horarioGuardaparque',compact('guardaparque','comunidadesAsignadas','lugaresHorariosAsignadosAGuardaparque'));


    }

    
    /**
     * Mostrar los detalles de un guardaparque específico.
     */
    public function show(Guardaparque $guardaparque)
    {
        return view('guardaparques.show', compact('guardaparque'));
    }


    public function verHorarioGuardaparque($id){


    }
     /**
     * Mostrar el formulario para editar un guardaparque específico.
     */
    public function edit($id)
    {
        //guardaparques
        $guardaparque=Guardaparque::findOrFail($id);
        //capaz se vaya si se implementa la supuesta herencia
        //$usuarioIdRolActual=Usuario::where('ci',$guardaparque->CI)->first()->roles->first()->id;
        $usuarioIdRolActual=Usuario::find($id)->roles->first()->id;
        $roles=Role::all();
        
        /* $queryListaSupervisa="SELECT SUPERVISAS.ID AS SUPERVISA_ID,COMUNIDADS.NOMBRE,COMUNIDADS.ZONA,HORARIOS.ID AS HORARIO_ID,DIAS.NOMBRE,HORA_INICIO,HORA_FIN
    FROM GUARDAPARQUES,SUPERVISAS,HORARIOS,DIAS,COMUNIDADS
    WHERE GUARDAPARQUES.ID=SUPERVISAS.GUARDAPARQUE_ID AND SUPERVISAS.ID=SUPERVISA_ID AND DIA_ID=DIAS.ID
    AND COMUNIDADS.ID=COMUNIDAD_ID
    AND GUARDAPARQUES.ID=$id;"*/
        $lugaresHorariosAsignadosAGuardaparque=Guardaparque::obtenerComunidadesYHorarios($id);
        //dd($lugaresHorariosAsignadosAGuardaparque);
         // Convertir horas de 'H:i:s' a 'H:i'
        /*foreach ($lugaresHorariosAsignadosAGuardaparque as $asignacion) {
            $asignacion->HORA_INICIO = substr($asignacion->HORA_INICIO, 0, 5); // Extraer 'H:i'
            $asignacion->HORA_FIN = substr($asignacion->HORA_FIN, 0, 5);       // Extraer 'H:i'
        }*/
        $comunidades = comunidad::all();
        $dias = Dia::all();

        $comunidadesAsignadas = DB::select("
        SELECT supervisas.id AS supervisa_id, comunidads.nombre AS comunidad_nombre 
        FROM guardaparques
        JOIN supervisas ON guardaparques.id = supervisas.guardaparque_id
        JOIN comunidads ON supervisas.comunidad_id = comunidads.id
        WHERE guardaparques.id = ?", [$id]);
    
        return view('administracion.guardaparques.editarGuardaparque', compact(
            'guardaparque', 'lugaresHorariosAsignadosAGuardaparque',
             'comunidades', 'dias','comunidadesAsignadas','usuarioIdRolActual','roles'));
        
    }

    /**
     * Update the specified resource in storage.
     * 
     * para actualizar el guardaparque
     *  lo que se hara es que actualizaremos el usuario, y un trigger lo actualizara la tabla guardaparque o lo eliminara dependiendo si cambio de rol
     */
    public function update(Request $request, $id)
    {
        // Encuentra el guardaparque
        //dd($request->all());
        $guardaparque = Guardaparque::findOrFail($id);
        //capaz se vaya si se implementa la herencia
        // Busca al usuario relacionado por el CI
        $usuarioGuardaparque = Usuario::findOrFail($id);

        // Validación de los datos del request
        $request->validate([
            'CI' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'edad' => 'required|integer|min:18',
            'sexo' => 'nullable|string|max:10',
            'correo' => 'required|email|unique:guardaparques,correo,' . $guardaparque->id,
            'nroCelular' => 'required|string|max:15',
            'contraseña' => 'nullable|string|min:8',
            'role' => 'nullable|exists:roles,id'
        ]);

        // Actualiza los datos en el modelo Guardaparque
        /*$data = $request->except(['contraseña', 'role']);
        if ($request->filled('contraseña')) {
            $data['contraseña'] = Hash::make($request->contraseña);
        }*/
        /*$guardaparque->fill($data);
        $guardaparque->save();*/

        // Actualiza los datos en el modelo Usuario
        $usuarioGuardaparque->nombre = $request->nombre;
        $usuarioGuardaparque->correo = $request->correo;
        $usuarioGuardaparque->ci = $request->CI;
        $usuarioGuardaparque->edad = $request->edad;
        $usuarioGuardaparque->sexo = $request->sexo;
        $usuarioGuardaparque->nroCelular = $request->nroCelular;

        // Actualiza la contraseña solo si fue proporcionada
        if ($request->filled('contraseña')) {
            $usuarioGuardaparque->contraseña = Hash::make($request->contraseña);
        }

        // Cambia el rol del usuario si se proporciona uno nuevo
        if ($request->filled('role')) {
            $nombreRol = Role::find($request->input('role'))->name;
            $usuarioGuardaparque->syncRoles([$nombreRol]);
        }

        $usuarioGuardaparque->save();
        //lo vuelvo a buscar por si se elimino
        $guardaparque = Guardaparque::find($id);
        //si el usuario no existe
        if(!$guardaparque){
            return redirect()->route('admin.guardaparque.index');
        }
        return redirect()->back()->with('success', 'Guardaparque actualizado con éxito.');
    }

    /**
     * Eliminar un guardaparque de la base de datos.
     */

    public function destroy($id)
    {
        $guardaparque = Guardaparque::findOrFail($id);
        try {
            //capaz se vaya si se implementa la herencia
     //       $usuario = usuario::where('ci', $guardaparque->CI)->first();
            $usuario = usuario::findOrFail($id);
            if($usuario&&!$usuario->hasRole('admin')){
                $usuario->delete();
            }
            
            $guardaparque->delete();
            //return redirect()->back()->with('success', 'Guardaparque eliminado con éxito.');
            return redirect()->route('admin.guardaparque.index')->with('success', 'Guardaparque eliminado con éxito.');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo eliminar el guardaparque. Puede estar relacionado con otros datos.');
        }
    }
}
