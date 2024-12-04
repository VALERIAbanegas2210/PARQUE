<?php

namespace App\Http\Controllers;

use App\Models\usuario; // Asegúrate de que el modelo se llame 'Usuario'
use App\Http\Requests\StoreusuarioRequest;
use App\Http\Requests\UpdateusuarioRequest;
use App\Models\Guardaparque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Obtén los usuarios que tienen el rol 'usuario'
        $usuarios = usuario::role('usuario')->paginate(10); // Ajusta la paginación según lo necesites
        $roles=Role::all();
        //dd($roles);
        return view('usuarios.index', compact('usuarios','roles'));
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
        $request->validate([
            'nombre' => 'required|string|max:255',
            'usuario' => 'required|string|max:255|unique:usuarios',
            'correo' => 'required|string|email|max:255|unique:usuarios',
            'contraseña' => 'required|string|min:8|confirmed',
            'nacionalidad' => 'required|string|max:255',
            'ci' => 'required_if:nacionalidad,boliviana|string|max:20',
            'edad' => 'required|integer|min:1',
            'sexo' => 'required|string|max:10',
            'pasaporte' => 'required_if:nacionalidad,ext|string|max:20',
        ]);

        $usuario = new usuario();
        $usuario->nombre = $request->nombre;
        $usuario->usuario = $request->usuario;
        $usuario->correo = $request->correo;
        $usuario->contraseña = Hash::make($request->contraseña);
        $usuario->nacionalidad = $request->nacionalidad;
        $usuario->ci = $request->ci; // Asegúrate de que tu modelo tiene este campo
        $usuario->edad = $request->edad;
        $usuario->sexo = $request->sexo;
        $usuario->pasaporte = $request->pasaporte; // Asegúrate de que tu modelo tiene este campo
        $usuario->save();
        return redirect()->route('usuarios.perfil');
    }


    /**
     * Display the specified resource.
     */
    // Mostrar información detallada del usuario
    public function show($id)
    {
        $usuario = usuario::findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuario = usuario::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Puedes ajustar el tamaño según tus necesidades
            'fullName' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'ci' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|string|max:10',
            'passport' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
        ]);

        $usuario = Auth::guard('usuarios')->user();

        // Si se sube una nueva imagen
        if ($request->hasFile('profile_image')) {
            // Eliminar la imagen anterior si existe
            if ($usuario->profile_image) {
                Storage::delete($usuario->profile_image);
            }

            // Guardar la nueva imagen
            $path = $request->file('profile_image')->store('profile_images', 'public'); // 'public' es el disco
            $usuario->profile_image = $path;
        }

        // Actualizar otros campos
        $usuario->nombre = $request->fullName;
        $usuario->usuario = $request->username;
        $usuario->correo = $request->email;
        $usuario->ci = $request->ci;
        $usuario->edad = $request->age;
        $usuario->sexo = $request->gender;
        $usuario->pasaporte = $request->passport;
        $usuario->nacionalidad = $request->nationality;

        $usuario->save();

        return redirect()->route('usuarios.perfil')->with('success', 'Perfil actualizado correctamente.');
    }

    //esta funcion es para actualizar a un usuario de la bd siendo admin
    public function updateAdmin(Request $request, $id)
    {   
        
        // Encuentra el usuario por su ID
        $usuario = usuario::findOrFail($id);
        //dd($usuario->roles);  
        // Validar los datos que vienen del formulario
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Imagen opcional, debe ser de tipo imagen
            'fullName' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:usuarios,usuario,' . $usuario->id,
            'email' => 'required|email|max:255|unique:usuarios,correo,' . $usuario->id,
            'ci' => 'required|string|max:255|unique:usuarios,ci,' . $usuario->id,
            'age' => 'required|integer',
            'gender' => 'required|string|max:10',
            'passport' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            //rol
            //'role'=>'nullable|exists:roles,id',
            'role'=>'nullable|exists:roles,id'
            
        ]);

        // Si se sube una nueva imagen, actualizar el campo de la imagen de perfil
        if ($request->hasFile('profile_image')) {
            // Eliminar la imagen anterior si existe
            if ($usuario->profile_image) {
                Storage::delete($usuario->profile_image);
            }

            // Guardar la nueva imagen
            $path = $request->file('profile_image')->store('profile_images', 'public');
            $usuario->profile_image = $path;
        }

        // Actualizar otros campos del usuario
        $usuario->nombre = $request->fullName;
        $usuario->usuario = $request->username;
        $usuario->correo = $request->email;
        $usuario->ci = $request->ci;
        $usuario->edad = $request->age;
        $usuario->sexo = $request->gender;
        $usuario->pasaporte = $request->passport;
        $usuario->nacionalidad = $request->nationality;
        $usuario->nroCelular=$request->nroCelular;
        //para asignar rol
        //$nombreRol=Role::find($request->input('role'))->name;
        //va a la tabla rol lo busca por el valor del input role que el calor es el id del rol y obtiene su nombre,y le asigna ese nombre al usuario
        
        $nombreRol=Role::find($request->input('role'))->name;
        $usuario->syncRoles([$nombreRol]);

        // Guardar los cambios en la base de datos
        //print("actualize admin");
        $usuario->save();

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // Eliminar usuario
    public function destroy($id)
    {
        $usuario = usuario::findOrFail($id);
        $guardaparque = Guardaparque::where('CI', $usuario->ci)->first();
        $usuario->delete();
        //si existe
            if($guardaparque){
                $guardaparque->delete();
            }

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
    public function perfil()
    {
        return view('usuarios.perfil'); // Asegúrate de que esta vista exista
    }

    public function deleteProfileImage(Request $request)
    {
        $user = Auth::guard('usuarios')->user();

        // Eliminar la imagen de perfil de almacenamiento
        if ($user->profile_image) {
            Storage::delete($user->profile_image);
            $user->profile_image = null; // Limpiar el campo de la imagen en la base de datos
            $user->save();
        }

        return response()->json(['success' => true]);
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // Esto verifica el campo 'new_password_confirmation'
        ]);

        $user = Auth::guard('usuarios')->user();

        // Verificar si la contraseña actual es correcta
        if (!Hash::check($request->current_password, $user->contraseña)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.']);
        }


        // Hashear la nueva contraseña antes de almacenarla
        $user->contraseña = Hash::make($request->new_password); // Esto asegurará que se guarde como un hash Bcrypt


        $user->save();

        return redirect()->back()->with('success', 'Datos actualizados exitosamente.');
    }
    public function uploadImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::guard('usuarios')->user();

        if ($user) {
            if ($request->hasFile('profile_image')) {
                // Obtener la imagen
                $image = $request->file('profile_image');
                // Generar un nombre único para la imagen
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                // Almacenar la imagen en el directorio adecuado
                $imagePath = $image->storeAs('public/profile_images', $imageName);

                // Actualiza el campo de la imagen en la base de datos
                $user->profile_image = 'profile_images/' . $imageName;
                $user->save();

                // Devuelve un JSON con el nuevo URL de la imagen
                return response()->json(['success' => true, 'imageUrl' => asset('storage/' . $user->profile_image)]);
            }
        }

        return response()->json(['success' => false, 'error' => 'No se pudo actualizar la imagen.']);
    }
    public function getDashBoard(){
        return view('administracion.DashBoard.dashboardAdmin');
    }
}