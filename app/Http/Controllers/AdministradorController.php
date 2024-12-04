<?php

namespace App\Http\Controllers;

use App\Models\usuario; // Asegúrate de que el modelo se llame 'Usuario'
//use App\Http\Requests\StoreUsuarioRequest;
//use App\Http\Requests\UpdateUsuarioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\File; // Asegúrate de tener esta línea
//use Illuminate\Support\Facades\Log;

class AdministradorController extends Controller
{
    /**
     * Display a listing of the resource.
     * listar todos los recursos
     */
    public function index()
    {
        return view('administradores.index'); // Asegúrate de que la vista se llame correctamente
    }

    /**
     * Show the form for creating a new resource.
     * 
     */
    public function create()
    {
        return view('administradores.create'); // Vista para crear un nuevo perfil
    }

    /**
     * Store a newly created resource in storage.
     * guarda o crea en la base de datos
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

        return redirect()->route('admin.index')->with('success', 'Usuario registrado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     * 
     */
    public function edit($id)
    {
        $usuario = usuario::findOrFail($id); // Busca el usuario
        return view('administradores.edit', compact('usuario')); // Asegúrate de que la vista sea correcta
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
        //$usuario->save();

        return redirect()->route('admin.index')->with('success', 'Perfil actualizado correctamente.');
    }



    // Método para eliminar imagen de perfil
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

    public function login()
    {
        return view('administracion.login');
    }

    public function registro()
    {
        return view('administracion.registro');
    }
}