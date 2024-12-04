<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered; // Asegúrate de incluir esto
use App\Mail\VerificationEmail; // Asegúrate de que esta clase exista
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCode; // Asegúrate de que esta clase exista
use App\Mail\VerificationCodeMail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str; // Para generar un código único
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'usuario' => 'required|string|unique:usuarios', // Asegúrate de que 'usuarios' es la tabla correcta
            'correo' => 'required|string|email|unique:usuarios', // Cambia 'usuarios' si el nombre de la tabla es diferente
            'contraseña' => 'required|string|min:8|confirmed', // Campo 'contraseña_confirmation' debe estar en el formulario
        ]);
        // Generar un código de verificación de 6 dígitos numéricos
        $verificationCode = random_int(100000, 999999);
        // Creación del usuario en la base de datos
        $usuario = usuario::create([
            'nombre' => $request->nombre,
            'usuario' => $request->usuario,
            'correo' => $request->correo,
            'contraseña' => Hash::make($request->contraseña), // Encriptar la contraseña
            'verification_code' => $verificationCode, // Guardar el código de verificación
            'nacionalidad' => $request->nacionalidad,
            'ci' => $request->ci,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'pasaporte' => $request->pasaporte,
        ]);

        // Asignar el rol 'usuario'

        //$usuario->assignRole('usuario');
        // Guardar el código en la base de datos o en la sesión (según tu preferencia)
        $usuario->verification_code = $verificationCode;
        $usuario->save();

        // Enviar el código por correo
        Mail::to($usuario->correo)->send(new VerificationCode($verificationCode));

        // Redirigir al usuario a la página de verificación
        return redirect()->route('verification.page', ['email' => $usuario->correo]);
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->only('correo', 'contraseña');

        // Verifica si las credenciales son correctas
        $user = usuario::where('correo', $credentials['correo'])->first();

        if ($user && Hash::check($credentials['contraseña'], $user->contraseña)) {
            Auth::guard('usuarios')->login($user); // Usa el guard 'usuarios'

            $request->session()->regenerate();
            // Verifica si el usuario tiene el rol de 'admin'
            if ($user->hasRole('admin')) {
                // Redirige a la vista de administrador
                return redirect()->route('admin.dashboard')->with('user', $user);
            }

            // Redirige a una vista normal si no es admin
            return redirect()->route('layouts.template')->with('user', $user);
        }

        // Si las credenciales son incorrectas
        return back()->withErrors([
            'correo' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }



    public function showVerificationForm(Request $request)
    {
        return view('auth.verification'); // Asegúrate de que esta vista exista
    }

    public function verifyCode(Request $request)
    {
        // Unir los inputs del código en una sola cadena de 6 dígitos
        $code = implode('', $request->input('code'));

        // Asegurar que el código es numérico y de 6 dígitos
        $request->merge(['code' => $code]);

        // Validación
        $request->validate([
            'code' => 'required|digits:6',
            'email' => 'required|email',
        ]);

        // Buscar al usuario por correo y código de verificación
        $usuario = usuario::where('correo', $request->email)
            ->where('verification_code', $request->code)
            ->first();

        if ($usuario) {
            // Verifica el usuario y elimina el código de verificación
            $usuario->verification_code = null; // O cualquier lógica que necesites
            $usuario->save();

            // Retorna a la misma vista con un mensaje de éxito
            return redirect()->route('verification.page', ['email' => $request->email])
                ->with('success', 'Cuenta verificada con éxito!')
                ->with('redirect', true);
        }

        // Si el código es inválido, devolver error
        return back()->withErrors(['code' => 'Código de verificación inválido.']);
    }
    // Manejar el cierre de sesión
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('usuarios')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login'); // Redirige a la página de inicio de sesión
    }
}
