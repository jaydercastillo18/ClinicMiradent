<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Pago;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin panel dashboard with real statistics.
     */
    public function index()
    {
        // 1. Core KPIs
        $pacienteCount = Paciente::count();
        $citasHoyCount = Cita::whereDate('fecha_hora', Carbon::today())->count();
        
        // Sum payments for current month that are fully or partially paid
        $ingresosMes = Pago::whereMonth('fecha_pago', Carbon::now()->month)
            ->whereYear('fecha_pago', Carbon::now()->year)
            ->whereIn('estado', ['pagado', 'parcial'])
            ->sum('monto');
            
        $serviciosCount = Servicio::where('activo', true)->count();

        // 2. Appointments List for Today
        $citasHoy = Cita::with([
                'paciente:id,nombre,apellido,telefono',
                'servicio:id,nombre,duracion_minutos'
            ])
            ->whereDate('fecha_hora', Carbon::today())
            ->orderBy('fecha_hora', 'asc')
            ->get();

        // 3. Completed appointments count for today
        $citasCompletadasHoyCount = Cita::whereDate('fecha_hora', Carbon::today())
            ->where('estado', 'completada')
            ->count();

        return view('dashboard', compact(
            'pacienteCount',
            'citasHoyCount',
            'ingresosMes',
            'serviciosCount',
            'citasHoy',
            'citasCompletadasHoyCount'
        ));
    }
    public function getNotificaciones()
    {
        $notifCitas = Cita::with(['paciente:id,nombre,apellido', 'servicio:id,nombre'])
            ->where('estado', 'pendiente')
            ->orderBy('fecha_hora', 'asc')
            ->get()
            ->map(function ($cita) {
                $pacienteNombre = trim(($cita->paciente?->nombre ?? 'Paciente') . ' ' . ($cita->paciente?->apellido ?? ''));
                $servicioNombre = $cita->servicio?->nombre ?? 'Tratamiento';

                return [
                    'id' => $cita->id,
                    'tipo' => 'cita',
                    'paciente' => $pacienteNombre ?: 'Paciente',
                    'detalle' => $servicioNombre . ' - ' . \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m H:i'),
                    'url' => url('/admin/citas')
                ];
            });

        $notifPagos = Pago::with(['paciente:id,nombre,apellido'])
            ->whereIn('estado', ['pendiente', 'parcial'])
            ->orderBy('fecha_pago', 'desc')
            ->get()
            ->map(function ($pago) {
                $pacienteNombre = trim(($pago->paciente?->nombre ?? 'Paciente') . ' ' . ($pago->paciente?->apellido ?? ''));

                return [
                    'id' => $pago->id,
                    'tipo' => 'pago',
                    'paciente' => $pacienteNombre ?: 'Paciente',
                    'monto' => number_format($pago->monto, 2),
                    'estado_pago' => $pago->estado,
                    'url' => route('finanzas.index')
                ];
            });

        return response()->json([
            'citas' => $notifCitas,
            'pagos' => $notifPagos,
            'total' => $notifCitas->count() + $notifPagos->count()
        ]);
    }
}
