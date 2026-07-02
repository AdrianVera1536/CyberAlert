<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // --- VISTAS ---

    public function showLogin() { 
        return view('login'); 
    }

    public function showRegistro() { 
        return view('registro'); 
    }

    public function showRecuperar() {
        return view('recuperar'); 
    }

    // --- ACCIONES ---

    /**
     * LOGIN: Valida credenciales y redirige según el rol
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Persona::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'ERROR: El correo no existe en nuestra base de datos.'])->withInput();
        }

        // Verificamos el hash de la contraseña (columna password_hash)
        if (Hash::check($request->password, $user->password_hash)) {
            Auth::login($user);
            $request->session()->regenerate();

            // 🔥 Redirección inteligente
            return $this->redirectByRol($user);
        }

        return back()->withErrors(['email' => 'ERROR: La contraseña es incorrecta.'])->withInput();
    }

    /**
     * REGISTRO: Crea el usuario y asigna el rol correctamente
     */
    public function registro(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido_paterno' => 'required|string|max:50',
            'apellido_materno' => 'required|string|max:50',
            'email' => 'required|email|unique:personas,email',
            'password' => 'required|min:6',
            'id_institucion' => 'required',
            'id_rol' => 'nullable' // Aceptamos el rol del formulario
        ]);

        // 🔥 MAPEO DE ROLES: Evita el error de "Incorrect integer value"
        // Si el valor viene como 'administrador', 'directivo', etc., lo pasamos a su ID numérico.
        $input_rol = strtolower($request->id_rol);
        $rol_mapping = [
            '1' => 1, 'administrador' => 1, 'admin' => 1,
            '2' => 2, 'directivo' => 2,
            '3' => 3, 'tutor' => 3,
            '4' => 4, 'estudiante' => 4, 'alumno' => 4
        ];

        // Si no se encuentra el rol en el mapa, por defecto es 4 (Estudiante)
        $rol_id = $rol_mapping[$input_rol] ?? 4;

        $user = Persona::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellido_paterno . ' ' . $request->apellido_materno,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password), // Encriptamos
            'id_rol' => $rol_id, 
            'id_institucion' => $request->id_institucion,
            'telefono' => $request->telefono ?? null
        ]);

        Auth::login($user);

        return $this->redirectByRol($user);
    }

    /**
     * LOGOUT: Cierra sesión de forma segura
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * REDIRECCIÓN CENTRALIZADA
     */
    private function redirectByRol($user)
    {
        // 1 = Administrador, 2 = Directivo, 3 = Tutor, 4 = Estudiante
        if ($user->id_rol == 1) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->id_rol == 2) {
            return redirect()->route('directivo.dashboard');
        } elseif ($user->id_rol == 3) {
            return redirect()->route('tutor.dashboard');
        } else {
            return redirect()->route('estudiante.dashboard');
        }
    }

    /**
     * RECUPERAR CONTRASEÑA (Básico)
     */
    public function recuperar(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = Persona::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'ERROR: No encontramos ninguna cuenta con ese correo.'])->withInput();
        }

        return back()->with('success', '¡Enlace de recuperación enviado! Revisa tu bandeja de entrada.');
    }
}