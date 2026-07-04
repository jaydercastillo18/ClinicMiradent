<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Pago;
use App\Models\Gasto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportesController extends Controller
{
    /**
     * Display report statistics.
     */
    public function index(Request $request)
    {
        // Parse date inputs, default to start/end of the current calendar year
        $fecha_inicio = $request->query('fecha_inicio') ?: Carbon::now()->startOfYear()->toDateString();
        $fecha_fin = $request->query('fecha_fin') ?: Carbon::now()->endOfYear()->toDateString();

        try {
            $start_datetime = Carbon::parse($fecha_inicio)->startOfDay();
            $end_datetime = Carbon::parse($fecha_fin)->endOfDay();
        } catch (\Exception $e) {
            $start_datetime = Carbon::now()->startOfYear();
            $end_datetime = Carbon::now()->endOfYear();
            $fecha_inicio = $start_datetime->toDateString();
            $fecha_fin = $end_datetime->toDateString();
        }

        // 1. Total Patients registered within range
        $totalPacientes = Paciente::whereBetween('created_at', [$start_datetime, $end_datetime])->count();

        // 2. Total Scheduled Appointments within range
        $totalCitas = Cita::whereBetween('fecha_hora', [$start_datetime, $end_datetime])->count();

        // 3. Total Income (collected) within range
        $totalIngresos = Pago::whereIn('estado', ['pagado', 'parcial'])
            ->whereBetween('fecha_pago', [$start_datetime, $end_datetime])
            ->sum('monto');

        $totalEgresos = Gasto::whereBetween('fecha_gasto', [
                $start_datetime->toDateString(),
                $end_datetime->toDateString(),
            ])
            ->sum('monto');
        $balance = $totalIngresos - $totalEgresos;

        // 4. Appointments grouped by status
        $citasPorEstadoRaw = Cita::whereBetween('fecha_hora', [$start_datetime, $end_datetime])
            ->select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado')
            ->all();

        $citasPorEstadoDefault = [
            'pendiente' => 0,
            'confirmada' => 0,
            'en_espera' => 0,
            'completada' => 0,
            'cancelada' => 0
        ];
        $citasPorEstado = array_merge($citasPorEstadoDefault, $citasPorEstadoRaw);

        // 5. Monthly income trend lines
        $ingresosMensualesRaw = Pago::whereIn('estado', ['pagado', 'parcial'])
            ->whereBetween('fecha_pago', [$start_datetime, $end_datetime])
            ->get(['monto', 'fecha_pago'])
            ->groupBy(fn (Pago $pago): string => $pago->fecha_pago->format('Y-m'))
            ->map(fn ($pagos): float => (float) $pagos->sum('monto'));

        $ingresosMensuales = [];
        $current = Carbon::parse($fecha_inicio)->startOfMonth();
        $end = Carbon::parse($fecha_fin)->startOfMonth();
        
        // Generate months padding for cleaner charts
        while ($current->lte($end)) {
            $ingresosMensuales[$current->format('Y-m')] = 0;
            $current->addMonth();
        }
        
        foreach ($ingresosMensualesRaw as $mes => $total) {
            if (isset($ingresosMensuales[$mes])) {
                $ingresosMensuales[$mes] = (float) $total;
            }
        }

        // 6. Top 5 treatments (Services)
        $topTratamientos = Cita::join('servicios', 'citas.servicio_id', '=', 'servicios.id')
            ->whereBetween('citas.fecha_hora', [$start_datetime, $end_datetime])
            ->select('servicios.nombre', DB::raw('count(*) as total'))
            ->groupBy('servicios.id', 'servicios.nombre')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // 7. Payment methods breakdown table
        $pagosPorMetodo = Pago::whereIn('estado', ['pagado', 'parcial'])
            ->whereBetween('fecha_pago', [$start_datetime, $end_datetime])
            ->select('metodo_pago', DB::raw('count(*) as count'), DB::raw('SUM(monto) as total'))
            ->groupBy('metodo_pago')
            ->get();

        $gastosPorCategoria = Gasto::whereBetween('fecha_gasto', [
                $start_datetime->toDateString(),
                $end_datetime->toDateString(),
            ])
            ->select('categoria', DB::raw('count(*) as count'), DB::raw('SUM(monto) as total'))
            ->groupBy('categoria')
            ->orderBy('categoria')
            ->get()
            ->map(fn (Gasto $gasto): array => [
                'categoria' => $gasto->categoria,
                'count' => (int) $gasto->count,
                'total' => (float) $gasto->total,
                'total_display' => 'S/. ' . number_format((float) $gasto->total, 2),
            ]);

        $metodosDefault = [
            'yape' => ['nombre' => 'Yape', 'count' => 0, 'total' => 0.0],
            'plin' => ['nombre' => 'Plin', 'count' => 0, 'total' => 0.0],
            'bcp' => ['nombre' => 'Banco de Crédito (BCP)', 'count' => 0, 'total' => 0.0],
            'tarjeta' => ['nombre' => 'Tarjeta de Crédito/Débito', 'count' => 0, 'total' => 0.0],
            'efectivo' => ['nombre' => 'Efectivo', 'count' => 0, 'total' => 0.0],
            'transferencia' => ['nombre' => 'Transferencia Bancaria', 'count' => 0, 'total' => 0.0],
            'otro' => ['nombre' => 'Otro', 'count' => 0, 'total' => 0.0],
        ];

        foreach ($pagosPorMetodo as $row) {
            $key = strtolower($row->metodo_pago);
            if (isset($metodosDefault[$key])) {
                $metodosDefault[$key]['count'] = $row->count;
                $metodosDefault[$key]['total'] = (float)$row->total;
            }
        }

        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'rango' => [
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_fin' => $fecha_fin,
                ],
                'resumen' => [
                    'total_pacientes' => $totalPacientes,
                    'total_citas' => $totalCitas,
                    'total_ingresos' => (float) $totalIngresos,
                    'total_egresos' => (float) $totalEgresos,
                    'balance' => (float) $balance,
                    'total_ingresos_display' => 'S/. ' . number_format((float) $totalIngresos, 2),
                    'total_egresos_display' => 'S/. ' . number_format((float) $totalEgresos, 2),
                    'balance_display' => 'S/. ' . number_format((float) $balance, 2),
                ],
                'citas_por_estado' => $citasPorEstado,
                'ingresos_mensuales' => $ingresosMensuales,
                'top_tratamientos' => $topTratamientos,
                'pagos_por_metodo' => array_values($metodosDefault),
                'gastos_por_categoria' => $gastosPorCategoria,
            ]);
        }

        return view('reportes', compact(
            'totalPacientes', 
            'totalCitas', 
            'totalIngresos', 
            'totalEgresos',
            'balance',
            'citasPorEstado', 
            'ingresosMensuales', 
            'topTratamientos', 
            'metodosDefault',
            'gastosPorCategoria',
            'fecha_inicio',
            'fecha_fin'
        ));
    }
}
