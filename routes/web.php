<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/debug-db', function () {
    try {
        DB::connection()->getPdo();
        return "Conexión a la base de datos exitosa.";
    } catch (\Exception $e) {
        return "Error de base de datos: " . $e->getMessage() . " | " . $e->getFile() . " linea " . $e->getLine();
    }
});
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\PromocionesController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\DoctoraController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CasosExitoController;
use App\Http\Controllers\TestimoniosController;
use App\Http\Controllers\GastosController;
use App\Http\Controllers\FinanzasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\PaymentSettingController;

// Web Pública (Landing Page & Secciones)
Route::get('/', [PublicController::class, 'home'])->name('public.home');
Route::get('/doctora', [PublicController::class, 'nosotros'])->name('public.nosotros');
Route::get('/servicios', [PublicController::class, 'servicios'])->name('public.servicios');
Route::get('/servicios/{id}', [PublicController::class, 'showServicio'])->name('public.servicios.detalle');
Route::get('/promociones', [PublicController::class, 'promociones'])->name('public.promociones');
Route::get('/antes-y-despues', [PublicController::class, 'casosExito'])->name('public.casos');
Route::get('/testimonios', [PublicController::class, 'testimonios'])->name('public.testimonios');
Route::get('/horarios', [PublicController::class, 'horarios'])->name('public.horarios');
Route::get('/contacto', [PublicController::class, 'contacto'])->name('public.contacto');
Route::get('/reservar-cita', [PublicController::class, 'reservarCita'])->name('public.reservar-cita');
Route::post('/validar-referido', [PublicController::class, 'validarReferido'])
    ->middleware('throttle:5,1')
    ->name('public.validar-referido');

// Autenticación (Login / Logout)
Route::get('/doctora-acceso', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/doctora-acceso', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Panel Administrativo Protegido (Solo Doctora)
Route::redirect('/admin', '/admin/dashboard');
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notificaciones', [DashboardController::class, 'getNotificaciones'])->name('admin.notificaciones');

    // Pacientes
    Route::get('/pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
    Route::get('/pacientes/buscar', [PacientesController::class, 'buscar'])->middleware('throttle:30,1')->name('pacientes.buscar');
    Route::get('/pacientes/nuevo', [PacientesController::class, 'create'])->name('pacientes.create');
    Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
    Route::get('/pacientes/{id}', [PacientesController::class, 'show'])->name('pacientes.show');
    Route::get('/pacientes/{id}/edit', [PacientesController::class, 'edit'])->name('pacientes.edit');
    Route::put('/pacientes/{id}', [PacientesController::class, 'update'])->name('pacientes.update');
    Route::delete('/pacientes/{id}', [PacientesController::class, 'destroy'])->name('pacientes.destroy');
    Route::get('/pacientes/{id}/ficha-pdf', [PacientesController::class, 'descargarFicha'])->name('pacientes.ficha-pdf');

    // Citas
    Route::get('/citas', [CitasController::class, 'index'])->name('citas.index');
    Route::get('/citas/api', [CitasController::class, 'apiEvents'])->name('citas.api');
    Route::post('/citas', [CitasController::class, 'store'])->name('citas.store');
    Route::put('/citas/{id}', [CitasController::class, 'update'])->name('citas.update');
    Route::delete('/citas/{id}', [CitasController::class, 'destroy'])->name('citas.destroy');

    // Finanzas / Caja Unificada (Protegidas)
    Route::middleware(['role:doctora'])->group(function () {
        Route::get('/finanzas', [FinanzasController::class, 'index'])->name('finanzas.index');
        Route::get('/finanzas/pdf', [FinanzasController::class, 'descargarPdf'])->name('finanzas.pdf');

        Route::get('/pagos', [FinanzasController::class, 'index'])->name('pagos.index');
        Route::post('/pagos', [PagosController::class, 'store'])->name('pagos.store');
        Route::put('/pagos/{id}', [PagosController::class, 'update'])->name('pagos.update');
        Route::delete('/pagos/{id}', [PagosController::class, 'destroy'])->name('pagos.destroy');
    });

    // Servicios / Tratamientos
    Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios.index');
    Route::post('/servicios', [ServiciosController::class, 'store'])->name('servicios.store');
    Route::put('/servicios/{id}', [ServiciosController::class, 'update'])->name('servicios.update');
    Route::delete('/servicios/{id}', [ServiciosController::class, 'destroy'])->name('servicios.destroy');

    // Promociones
    Route::get('/promociones', [PromocionesController::class, 'index'])->name('promociones.index');
    Route::post('/promociones', [PromocionesController::class, 'store'])->name('promociones.store');
    Route::put('/promociones/{id}', [PromocionesController::class, 'update'])->name('promociones.update');
    Route::delete('/promociones/{id}', [PromocionesController::class, 'destroy'])->name('promociones.destroy');

    // Casos de ?xito / Antes y Después
    Route::get('/casos-exito', [CasosExitoController::class, 'index'])->name('casos-exito.index');
    Route::post('/casos-exito', [CasosExitoController::class, 'store'])->name('casos-exito.store');
    Route::put('/casos-exito/{id}', [CasosExitoController::class, 'update'])->name('casos-exito.update');
    Route::delete('/casos-exito/{id}', [CasosExitoController::class, 'destroy'])->name('casos-exito.destroy');

    // Instalaciones
    Route::get('/instalaciones', [App\Http\Controllers\InstalacionController::class, 'index'])->name('instalaciones.index');
    Route::post('/instalaciones', [App\Http\Controllers\InstalacionController::class, 'store'])->name('instalaciones.store');
    Route::put('/instalaciones/{id}', [App\Http\Controllers\InstalacionController::class, 'update'])->name('instalaciones.update');
    Route::delete('/instalaciones/{id}', [App\Http\Controllers\InstalacionController::class, 'destroy'])->name('instalaciones.destroy');


    // Testimonios
    Route::get('/testimonios', [TestimoniosController::class, 'index'])->name('testimonios.index');
    Route::post('/testimonios', [TestimoniosController::class, 'store'])->name('testimonios.store');
    Route::put('/testimonios/{id}', [TestimoniosController::class, 'update'])->name('testimonios.update');
    Route::delete('/testimonios/{id}', [TestimoniosController::class, 'destroy'])->name('testimonios.destroy');

    // --- RUTAS PROTEGIDAS (Solo Doctora) ---
    Route::middleware(['role:doctora'])->group(function () {
        // Reportes (incluye totales de ingresos, egresos y balance: dato financiero)
        Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');

        // Gastos y Egresos
        Route::get('/gastos', [FinanzasController::class, 'index'])->name('gastos.index');
        Route::get('/gastos/pdf', [GastosController::class, 'descargarPdf'])->name('gastos.pdf');
        Route::post('/gastos', [GastosController::class, 'store'])->name('gastos.store');
        Route::put('/gastos/{id}', [GastosController::class, 'update'])->name('gastos.update');
        Route::delete('/gastos/{id}', [GastosController::class, 'destroy'])->name('gastos.destroy');

        // Perfil de la Doctora
        Route::get('/doctora', [DoctoraController::class, 'profile'])->name('doctora.profile');
        Route::put('/doctora', [DoctoraController::class, 'updateProfile'])->name('doctora.updateProfile');

        // Configuración
        Route::get('/configuracion', [DoctoraController::class, 'config'])->name('doctora.config');
        Route::put('/configuracion', [DoctoraController::class, 'updateConfig'])->name('doctora.updateConfig');

        // Gestión de Usuarios
        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
        Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

        // Auditoría
        Route::get('/auditoria', [AuditController::class, 'index'])->name('auditoria.index');

        // Configuración de Pagos (imagen QR de Yape)
        Route::get('/configuracion-pagos', [PaymentSettingController::class, 'edit'])->name('payment-settings.edit');
        Route::put('/configuracion-pagos', [PaymentSettingController::class, 'update'])->name('payment-settings.update');
    }); // Fin Rutas Protegidas Doctora
});
