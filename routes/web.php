<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController; // Necesario para los módulos de administración
use App\Http\Controllers\DiagnosticoController; // <-- AGREGADO PARA EL DIAGNÓSTICO
use App\Http\Controllers\QuizController;
use App\Http\Controllers\InstrumentoController;
use App\Http\Controllers\MaterialAsignadoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\TematicaController;


/*
|--------------------------------------------------------------------------
| Rutas Públicas (Landing Page)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('home');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación (Login, Registro y Recuperación)
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    // Login
    Route::get('/login', 'showLogin')->name('login');
    Route::post('/login', 'login')->name('login.post');
    
    // Registro
    Route::get('/registro', 'showRegistro')->name('registro');
    Route::post('/registro', 'registro')->name('registro.post');
    
    // Recuperación de Contraseña
    Route::get('/recuperar', 'showRecuperar')->name('password.request');
    Route::post('/recuperar', 'recuperar')->name('password.email');
    
    // Logout
    Route::post('/logout', 'logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| Rutas Protegidas (Requieren inicio de sesión)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // DASHBOARD PRINCIPAL ADMINISTRADOR
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // MÓDULOS DE ADMINISTRACIÓN (Basados en tus bocetos)
    Route::controller(AdminController::class)->group(function () {
        // Administrar Instituciones
        Route::get('/admin/instituciones', 'instituciones')->name('admin.instituciones');
        
        // Administrar Instrumentos de Evaluación
        Route::get('/admin/instrumentos', 'instrumentos')->name('admin.instrumentos');
        
        // Estadísticas del Sistema
        Route::get('/admin/estadisticas', 'estadisticas')->name('admin.estadisticas');
    });

    // PANELES DE USUARIO
    Route::get('/panel-estudiante', function () {
        return view('panel_estudiante');
    })->name('estudiante.dashboard');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard-estudiante', function () {
        return view('dashboard_estudiante');
    })->name('estudiante.dashboard');
});

// Ruta para mostrar el formulario de diagnóstico
Route::get('/diagnostico', function () {
    return view('diagnostico');
})->name('estudiante.diagnostico');

// <-- RUTA AGREGADA PARA GUARDAR EL DIAGNÓSTICO -->
Route::post('/diagnostico/guardar', [DiagnosticoController::class, 'guardar'])->name('diagnostico.guardar');

// Ruta para VER los resultados
Route::get('/resultados', [DiagnosticoController::class, 'resultados'])->name('estudiante.resultados');

// (Esta es la que vas a crear después para el Material de Apoyo)
Route::get('/material-apoyo', function () {
    return view('material_apoyo'); // Crearemos esta vista más adelante
})->name('estudiante.material');

// Ruta de Material de Apoyo
Route::get('/material-apoyo', function () {
    return view('material_apoyo');
})->name('estudiante.material');

// Ruta del Quiz (que haremos a continuación)
Route::get('/quiz', function () {
    return view('quiz');
})->name('estudiante.quiz');

Route::post('/quiz/guardar', [QuizController::class, 'guardar'])->name('quiz.guardar');

// Ruta para Contactos de Apoyo
Route::get('/contactos', function () {
    return view('contactos');
})->name('estudiante.contactos');

// PANEL DEL TUTOR
    Route::get('/panel-tutor', function () {
        return view('panel_tutor');
    })->name('tutor.dashboard');

    // Vista de Grupos del Tutor
    Route::get('/tutor/grupos', function () {
        return view('tutor_grupos');
    })->name('tutor.grupos');

    // Vista de Resultados del Tutor
    Route::get('/tutor/resultados', function () {
        return view('tutor_resultados');
    })->name('tutor.resultados');

    // Vista Principal de Instrumentos (Tabla CRUD)
    Route::get('/tutor/instrumentos', function () {
        return view('tutor_instrumentos');
    })->name('tutor.instrumentos');

    Route::get('/tutor/instrumentos', [InstrumentoController::class, 'index'])->name('tutor.instrumentos');
    Route::get('/tutor/instrumentos/crear', [InstrumentoController::class, 'create'])->name('tutor.instrumentos.crear');
    Route::post('/tutor/instrumentos', [InstrumentoController::class, 'store'])->name('tutor.instrumentos.store');
    Route::delete('/tutor/instrumentos/{id}', [InstrumentoController::class, 'destroy'])->name('tutor.instrumentos.destroy');

    // Ruta para mostrar el formulario de edición con los datos cargados
Route::get('/tutor/instrumentos/{id}/editar', [InstrumentoController::class, 'edit'])->name('tutor.instrumentos.editar');

// Ruta para procesar la actualización en la base de datos
Route::put('/tutor/instrumentos/{id}', [InstrumentoController::class, 'update'])->name('tutor.instrumentos.update');

Route::get('/tutor/material-asignado', [MaterialAsignadoController::class, 'index'])->name('tutor.material.index');
Route::get('/tutor/material-asignado/crear', [MaterialAsignadoController::class, 'create'])->name('tutor.material.crear');
Route::post('/tutor/material-asignado', [MaterialAsignadoController::class, 'store'])->name('tutor.material.store');
Route::delete('/tutor/material-asignado/{id_material}/{id_grupo}', [MaterialAsignadoController::class, 'destroy'])->name('tutor.material.destroy');

// Ruta para mostrar el formulario de edición
Route::get('/tutor/material-asignado/{id_material}/{id_grupo}/editar', [MaterialAsignadoController::class, 'edit'])->name('tutor.material.editar');

// Ruta para procesar la actualización (ya la teníamos, pero asegúrate de que se llame así)
Route::put('/tutor/material-asignado/{old_material}/{old_grupo}', [MaterialAsignadoController::class, 'update'])->name('tutor.material.update');

// 1. Ruta para ver el formulario (GET)
Route::get('/tutor/reportes', [ReporteController::class, 'index'])->name('tutor.reportes.index');

// 2. Ruta para procesar el reporte y mostrar gráficas (POST)
Route::post('/tutor/reportes/generar', [ReporteController::class, 'generar'])->name('tutor.reportes.generar');

// Asegúrate de usar el middleware de autenticación
Route::middleware(['auth'])->group(function () {
    
    // Ruta para el Dashboard del Directivo
    Route::get('/directivo/dashboard', function () {
        return view('directivo_dashboard'); // Asegúrate de que tu vista se llame así
    })->name('directivo.dashboard');

    // Aquí irán las otras rutas del directivo después (Temáticas, Asignar Tutor, Resumen)
});

Route::get('/directivo/dashboard', function () {
    return view('directivo_dashboard');
})->name('directivo.dashboard');

// Grupo de rutas para el directivo (puedes meterlo dentro de tu middleware 'auth')
Route::prefix('directivo')->group(function () {
    
    // Vista principal de temáticas
    Route::get('/tematicas', [TematicaController::class, 'index'])->name('directivo.tematicas');
    
    // Rutas para el CRUD (Crear, Editar, Eliminar)
    Route::post('/tematicas/guardar', [TematicaController::class, 'store'])->name('tematicas.store');
    Route::put('/tematicas/actualizar', [TematicaController::class, 'update'])->name('tematicas.update');
    Route::delete('/tematicas/eliminar', [TematicaController::class, 'destroy'])->name('tematicas.destroy');
});

use App\Http\Controllers\AsignacionController;

Route::prefix('directivo')->group(function () {
    Route::get('/asignar-tutor', [AsignacionController::class, 'index'])->name('directivo.asignar.index');
    Route::post('/asignar-tutor', [AsignacionController::class, 'store'])->name('directivo.asignar.store');
    Route::delete('/asignar-tutor/{id}', [AsignacionController::class, 'destroy'])->name('directivo.asignar.destroy');
});

use App\Http\Controllers\RiskController;

// Ruta para ver la pantalla con las gráficas
Route::get('/directivo/resumen-riesgo', [RiskController::class, 'resumen'])->name('directivo.resumen');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios.index');
    Route::post('/admin/usuarios', [AdminController::class, 'storeUsuario'])->name('admin.usuarios.store');
    Route::put('/admin/usuarios/update', [AdminController::class, 'updateUsuario'])->name('admin.usuarios.update');
    Route::delete('/admin/usuarios/{id}', [AdminController::class, 'destroyUsuario'])->name('admin.usuarios.destroy');
});

// CRUD Instituciones
Route::get('/admin/instituciones', [AdminController::class, 'instituciones'])->name('admin.instituciones.index');
Route::post('/admin/instituciones', [AdminController::class, 'storeInstitucion'])->name('admin.instituciones.store');
Route::put('/admin/instituciones/update', [AdminController::class, 'updateInstitucion'])->name('admin.instituciones.update');
Route::delete('/admin/instituciones/{id}', [AdminController::class, 'destroyInstitucion'])->name('admin.instituciones.destroy');

Route::get('/admin/instituciones', [AdminController::class, 'instituciones'])->name('admin.instituciones.index');



Route::get('/directivo/logs-mysql', [AdminController::class, 'logsMysql'])->name('directivo.logs');
Route::get('/directivo/bitacora', [AdminController::class, 'bitacoraMovimientos'])->name('directivo.bitacora');

/* --- RUTAS DE INSTRUMENTOS (SIN PREFIJO ADMIN) --- */

// 1. Ver la lista de instrumentos
Route::get('/instrumentos', [AdminController::class, 'instrumentos'])->name('admin.instrumentos.index');

// 2. Guardar un nuevo instrumento
Route::post('/instrumentos', [AdminController::class, 'storeInstrumento'])->name('admin.instrumentos.store');

// 3. Actualizar un instrumento existente
Route::put('/instrumentos/update', [AdminController::class, 'updateInstrumento'])->name('admin.instrumentos.update');

// 4. Eliminar (Soft Delete)
Route::delete('/instrumentos/{id}', [AdminController::class, 'destroyInstrumento'])->name('admin.instrumentos.destroy');

// Ver las estadísticas
Route::get('/estadisticas', [AdminController::class, 'estadisticas'])->name('admin.estadisticas.index');