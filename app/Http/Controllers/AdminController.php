<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * DASHBOARD PRINCIPAL: Muestra las métricas globales
     */
    public function index()
    {
        // Variables para que no salga "Undefined variable"
        $totalUsuarios = Persona::count();
        $totalEstudiantes = Persona::where('id_rol', 4)->count();
        $totalTutores = Persona::where('id_rol', 3)->count();
        $totalDirectivos = Persona::where('id_rol', 2)->count();
        $totalInstituciones = DB::table('instituciones')->count(); 
        $totalDiagnosticos = 0; 

        return view('admin_dashboard', compact(
            'totalUsuarios', 'totalEstudiantes', 'totalTutores', 
            'totalDirectivos', 'totalInstituciones', 'totalDiagnosticos'
        ));
    }

    /**
     * GESTIÓN DE USUARIOS (CRUD)
     */
    public function usuarios()
    {
        $usuarios = Persona::where('id_rol', '!=', 4)->get();
        return view('admin_usuarios', compact('usuarios'));
    }

    public function storeUsuario(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:personas,email',
            'password' => 'required|min:6',
            'id_rol' => 'required'
        ]);

        // Mapeo de rol para evitar errores de texto vs entero
        $rol_mapping = ['administrador' => 1, 'admin' => 1, 'directivo' => 2, 'tutor' => 3];
        $rol_id = $rol_mapping[strtolower($request->id_rol)] ?? $request->id_rol;

        Persona::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password_hash' => Hash::make($request->password),
            'id_rol' => $rol_id, 
            'id_institucion' => Auth::user()->id_institucion ?? 1,
        ]);

        return back()->with('success', '¡Usuario creado exitosamente!');
    }

    public function updateUsuario(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:personas,id',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:personas,email,' . $request->id,
        ]);

        $user = Persona::find($request->id);
        $user->nombre = $request->nombre;
        $user->apellidos = $request->apellidos;
        $user->email = $request->email;
        
        $rol_mapping = ['administrador' => 1, 'directivo' => 2, 'tutor' => 3];
        $user->id_rol = $rol_mapping[strtolower($request->id_rol)] ?? $request->id_rol;

        if ($request->filled('password')) {
            $user->password_hash = Hash::make($request->password);
        }

        $user->save();
        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroyUsuario($id)
    {
        Persona::destroy($id);
        return back()->with('success', 'El usuario ha sido eliminado.');
    }

    /**
     * GESTIÓN DE INSTITUCIONES (CRUD)
     */
    public function instituciones()
    {
        $instituciones = DB::table('instituciones')->get();
        return view('admin_instituciones', compact('instituciones'));
    }

    public function storeInstitucion(Request $request)
    {
        // Quitamos la validación de 'cct' porque no existe en tu tabla
        $request->validate(['nombre' => 'required|string|max:255']);

        DB::table('instituciones')->insert([
            'nombre_institucion' => $request->nombre,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Institución registrada.');
    }

    public function updateInstitucion(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'nombre' => 'required|string|max:255',
            'cct' => 'required|string|unique:instituciones,cct,' . $request->id . ',id_institucion',
            'direccion' => 'required|string',
            'director_responsable' => 'required|string'
        ]);

        DB::table('instituciones')
            ->where('id_institucion', $request->id) // 🔥 ID corregido según tu BD
            ->update([
                'nombre_institucion' => $request->nombre, // 🔥 Nombre corregido
                'cct' => $request->cct,
                'direccion' => $request->direccion,
                'director_responsable' => $request->director_responsable,
                'updated_at' => now()
            ]);

        return redirect()->route('admin.instituciones.index')->with('success', 'Institución actualizada.');
    }

    public function destroyInstitucion($id)
    {
        DB::table('instituciones')->where('id_institucion', $id)->delete(); // 🔥 ID corregido
        return back()->with('success', 'Institución eliminada.');
    }

    public function logsMysql()
    {
        $logPath = storage_path('logs/mysql.log');
        
        if (!file_exists($logPath)) {
            $logContent = "El sistema de MySQL está en línea. Aún no hay consultas registradas.";
        } else {
            // Leemos el archivo y sacamos solo las últimas 50 líneas
            $lineas = file($logPath);
            $logContent = implode("", array_slice($lineas, -50));
        }

        // Retornamos la vista (ajusta el nombre según tu estructura, ej: admin.logs)
        return view('admin_logs', compact('logContent'));
    }

    public function bitacoraMovimientos()
    {
        // Traemos los últimos 50 movimientos de MySQL
        $movimientos = \Illuminate\Support\Facades\DB::table('bitacora_movimientos')
                        ->orderBy('created_at', 'desc')
                        ->limit(50)
                        ->get();

        // Convertimos el JSON de la columna 'detalles' para leerlo en la vista
        foreach ($movimientos as $mov) {
            $mov->datos_json = json_decode($mov->detalles, true);
        }

        return view('admin_bitacora', compact('movimientos'));
    }

    // --- DENTRO DE AdminController.php ---

public function instrumentos()
{
    // Obtenemos todos los instrumentos de la tabla 'instrumentos'
    $instrumentos = DB::table('instrumentos')->whereNull('deleted_at')->get();
    return view('admin_instrumentos', compact('instrumentos'));
}

public function storeInstrumento(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'required|string'
    ]);

    DB::table('instrumentos')->insert([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return back()->with('success', '¡Instrumento creado con éxito!');
}

public function updateInstrumento(Request $request)
{
    DB::table('instrumentos')->where('id', $request->id)->update([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
        'updated_at' => now()
    ]);

    return redirect()->route('admin.instrumentos.index')->with('success', 'Instrumento actualizado.');
}

public function destroyInstrumento($id)
{
    // Usamos Soft Delete (llenamos la columna deleted_at) ya que la tienes en tu BD
    DB::table('instrumentos')->where('id', $id)->update(['deleted_at' => now()]);
    return back()->with('success', 'Instrumento eliminado.');
}

// --- AGREGAR A AdminController.php ---

public function estadisticas()
{
    // Contamos los usuarios según el ID de su rol en la tabla personas
    $estudiantes = \App\Models\Persona::where('id_rol', 4)->count();
    $tutores = \App\Models\Persona::where('id_rol', 3)->count();
    $directivos = \App\Models\Persona::where('id_rol', 2)->count();
    $administradores = \App\Models\Persona::where('id_rol', 1)->count();

    return view('admin_estadisticas', compact('estudiantes', 'tutores', 'directivos', 'administradores'));
}

}