<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Gasto;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Doctora;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanzasController extends Controller
{
    /**
     * Display the unified cash flow dashboard (Finanzas & Caja).
     */
    public function index(Request $request)
    {
        $mes       = $request->query('mes', Carbon::now()->format('Y-m'));
        $search    = $request->query('search');
        $categoria = $request->query('categoria');
        $tipo      = $request->query('tipo'); // 'ingreso' or 'egreso'

        $parts = explode('-', $mes);
        $year  = $parts[0] ?? Carbon::now()->year;
        $month = $parts[1] ?? Carbon::now()->month;

        // 1. Fetch Pagos (Ingresos)
        $pagosQuery = Pago::query()
            ->select(['id', 'paciente_id', 'cita_id', 'monto', 'metodo_pago', 'fecha_pago', 'estado', 'notas'])
            ->with([
                'paciente:id,nombre,apellido,dni,telefono',
                'cita:id,servicio_id,fecha_hora',
                'cita.servicio:id,nombre,precio',
            ])
            ->whereYear('fecha_pago', $year)
            ->whereMonth('fecha_pago', $month);

        if ($search) {
            $pagosQuery->whereHas('paciente', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%")
                  ->orWhere('dni', 'like', "%{$search}%");
            });
        }

        $pagosRaw = $pagosQuery->orderBy('fecha_pago', 'desc')->get();

        // Map Pagos to Unified Movement Structure
        $ingresos = $pagosRaw->map(function ($pago) {
            $conceptoStr = 'Pago de Paciente';
            if ($pago->paciente) {
                $conceptoStr .= ': ' . $pago->paciente->nombre . ' ' . $pago->paciente->apellido;
            }
            if ($pago->notas) {
                $conceptoStr .= ' (' . $pago->notas . ')';
            }

            return (object)[
                'id'                 => $pago->id,
                'tipo'               => 'ingreso',
                'fecha'              => $pago->fecha_pago,
                'concepto'           => $conceptoStr,
                'categoria'          => $pago->cita && $pago->cita->servicio ? $pago->cita->servicio->nombre : 'Tratamiento',
                'metodo_pago'        => $pago->metodo_pago,
                'comprobante_estado' => $pago->estado, // pagado, parcial, pendiente
                'monto'              => $pago->monto,
                'detalles'           => $pago
            ];
        });

        // 2. Fetch Gastos (Egresos)
        $gastosQuery = Gasto::query()
            ->select(['id', 'concepto', 'descripcion', 'monto', 'categoria', 'metodo_pago', 'fecha_gasto', 'comprobante'])
            ->whereYear('fecha_gasto', $year)
            ->whereMonth('fecha_gasto', $month);

        if ($search) {
            $gastosQuery->where(function ($q) use ($search) {
                $q->where('concepto', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        if ($categoria) {
            $gastosQuery->where('categoria', $categoria);
        }

        $gastosRaw = $gastosQuery->orderBy('fecha_gasto', 'desc')->get();

        // Map Gastos to Unified Movement Structure
        $egresos = $gastosRaw->map(function ($gasto) {
            $conceptoStr = $gasto->concepto;
            if ($gasto->descripcion) {
                $conceptoStr .= ' (' . $gasto->descripcion . ')';
            }

            return (object)[
                'id'                 => $gasto->id,
                'tipo'               => 'egreso',
                'fecha'              => $gasto->fecha_gasto,
                'concepto'           => $conceptoStr,
                'categoria'          => $gasto->categoria,
                'metodo_pago'        => $gasto->metodo_pago,
                'comprobante_estado' => $gasto->comprobante ?? '—',
                'monto'              => $gasto->monto,
                'detalles'           => $gasto
            ];
        });

        // 3. Calculate Totals (Unfiltered by tipo for header cards)
        $totalIngresos = $ingresos->sum('monto');
        $totalEgresos  = $egresos->sum('monto');
        $balance       = $totalIngresos - $totalEgresos;

        // 4. Merge and Filter by Type if requested
        $movimientos = collect();
        if (!$tipo || $tipo === 'ingreso') {
            $movimientos = $movimientos->concat($ingresos);
        }
        if (!$tipo || $tipo === 'egreso') {
            $movimientos = $movimientos->concat($egresos);
        }

        // Sort by date desc
        $movimientos = $movimientos->sortByDesc('fecha');

        // Extra metadata for modals/selectors
        $pacientes  = Paciente::orderBy('nombre', 'asc')->get(['id', 'nombre', 'apellido', 'dni', 'telefono']);
        $citas      = Cita::with(['paciente:id,nombre,apellido', 'servicio:id,nombre,precio'])
            ->orderBy('fecha_hora', 'desc')
            ->limit(150)
            ->get(['id', 'paciente_id', 'servicio_id', 'fecha_hora']);
        $categorias = ['Material', 'Equipamiento', 'Servicios', 'Personal', 'Otros'];

        // --- GESTIÓN DE CLIENTES: CÁLCULOS DINÁMICOS DE PAGO Y MOROSIDAD ---
        $today = Carbon::now()->startOfDay();
        $search_cliente = $request->query('search_cliente');
        $filtro_cliente = $request->query('filtro_cliente');

        $pacientesConFinanzas = Paciente::query()
            ->select(['id', 'nombre', 'apellido', 'dni', 'telefono', 'created_at'])
            ->with([
                'citas:id,paciente_id,servicio_id,estado,fecha_hora',
                'citas.servicio:id,nombre,precio',
                'pagos:id,paciente_id,monto,fecha_pago,estado',
            ])
            ->get()
            ->map(function ($paciente) use ($today) {
                // Costo total de citas activas (no canceladas)
                $citasActivas = $paciente->citas->where('estado', '!=', 'cancelada');
                $total_cost = $citasActivas->sum(function ($cita) {
                    return $cita->servicio ? $cita->servicio->precio : 0;
                });

                // Total pagado
                $total_paid = $paciente->pagos->sum('monto');

                // Saldo restante por pagar
                $pending_amount = max(0, $total_cost - $total_paid);

                // Fecha del último pago o fecha de registro (si no tiene pagos)
                $ultimoPago = $paciente->pagos->sortByDesc('fecha_pago')->first();
                if ($ultimoPago) {
                    $last_action_date = Carbon::parse($ultimoPago->fecha_pago);
                    $has_paid_before = true;
                } else {
                    $last_action_date = $paciente->created_at;
                    $has_paid_before = false;
                }

                // Días calendario transcurridos desde el último pago o registro.
                $last_action_day = $last_action_date->copy()->startOfDay();
                $days_elapsed = max(0, (int) $last_action_day->diffInDays($today, false));

                // Próxima fecha límite de pago (15 días desde la última acción de pago o registro)
                $next_due_date = $last_action_day->copy()->addDays(15);
                $days_until_due = max(0, 15 - $days_elapsed);
                $days_overdue = max(0, $days_elapsed - 15);

                // Determinación del estado de pago
                if ($total_cost > 0 && $total_paid >= $total_cost) {
                    $estado = 'pagado'; // Al día / Pagado
                } elseif ($pending_amount > 0 && $days_elapsed > 15) {
                    $estado = 'moroso'; // Moroso
                } elseif ($pending_amount > 0 && $total_paid > 0) {
                    $estado = 'cuotas'; // Pago parcial / Por cuotas
                } else {
                    // pending_amount > 0 && total_paid == 0 && days_elapsed <= 15
                    // o total_cost == 0 && total_paid == 0
                    $estado = 'pendiente'; // Pendiente / No pagaron
                }

                $paciente->total_cost = $total_cost;
                $paciente->total_paid = $total_paid;
                $paciente->pending_amount = $pending_amount;
                $paciente->next_due_date = $next_due_date;
                $paciente->days_elapsed = $days_elapsed;
                $paciente->days_until_due = $days_until_due;
                $paciente->days_overdue = $days_overdue;
                $paciente->estado_pago = $estado;
                $paciente->last_action_date = $last_action_date;

                return $paciente;
            });

        // Contadores por cada estado de pago (para las tarjetas/badges del frontend)
        $clienteCounts = [
            'todos'     => $pacientesConFinanzas->count(),
            'pagado'    => $pacientesConFinanzas->where('estado_pago', 'pagado')->count(),
            'pendiente' => $pacientesConFinanzas->where('estado_pago', 'pendiente')->count(),
            'cuotas'    => $pacientesConFinanzas->where('estado_pago', 'cuotas')->count(),
            'moroso'    => $pacientesConFinanzas->where('estado_pago', 'moroso')->count(),
        ];

        // Aplicar filtros de búsqueda de clientes
        if ($search_cliente) {
            $term = strtolower($search_cliente);
            $pacientesConFinanzas = $pacientesConFinanzas->filter(function ($p) use ($term) {
                return str_contains(strtolower((string) $p->nombre), $term) ||
                       str_contains(strtolower((string) $p->apellido), $term) ||
                       str_contains(strtolower((string) $p->dni), $term);
            });
        }

        // Aplicar filtro de estado de pago de clientes
        if ($filtro_cliente && in_array($filtro_cliente, ['pagado', 'pendiente', 'cuotas', 'moroso'])) {
            $pacientesConFinanzas = $pacientesConFinanzas->where('estado_pago', $filtro_cliente);
        }

        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'resumen' => [
                    'total_ingresos' => (float) $totalIngresos,
                    'total_egresos' => (float) $totalEgresos,
                    'balance' => (float) $balance,
                    'total_ingresos_display' => 'S/. ' . number_format((float) $totalIngresos, 2),
                    'total_egresos_display' => 'S/. ' . number_format((float) $totalEgresos, 2),
                    'balance_display' => 'S/. ' . number_format((float) $balance, 2),
                ],
                'filtros' => compact('mes', 'search', 'categoria', 'tipo', 'search_cliente', 'filtro_cliente'),
                'movimientos' => $movimientos->values()->map(fn ($movimiento): array => $this->formatearMovimiento($movimiento))->all(),
                'clientes' => $pacientesConFinanzas->values()->map(fn ($paciente): array => $this->formatearClienteFinanzas($paciente))->all(),
                'cliente_counts' => $clienteCounts,
            ]);
        }

        return view('finanzas', compact(
            'movimientos', 'totalIngresos', 'totalEgresos', 'balance',
            'mes', 'search', 'categoria', 'tipo',
            'pacientes', 'citas', 'categorias',
            'pacientesConFinanzas', 'search_cliente', 'filtro_cliente', 'clienteCounts'
        ));
    }

    /**
     * Download unified cash flow report as PDF.
     */
    public function descargarPdf(Request $request)
    {
        $mes       = $request->query('mes', Carbon::now()->format('Y-m'));
        $search    = $request->query('search');
        $categoria = $request->query('categoria');
        $tipo      = $request->query('tipo');

        $parts = explode('-', $mes);
        $year  = $parts[0] ?? Carbon::now()->year;
        $month = $parts[1] ?? Carbon::now()->month;

        // Fetch Incomes (Pagos)
        $pagosQuery = Pago::query()
            ->select(['id', 'paciente_id', 'cita_id', 'monto', 'metodo_pago', 'fecha_pago', 'estado', 'notas'])
            ->with(['paciente:id,nombre,apellido,dni', 'cita:id,servicio_id,fecha_hora', 'cita.servicio:id,nombre'])
            ->whereYear('fecha_pago', $year)
            ->whereMonth('fecha_pago', $month);

        if ($search) {
            $pagosQuery->whereHas('paciente', function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%");
            });
        }
        $pagosRaw = $pagosQuery->orderBy('fecha_pago', 'desc')->get();
        $ingresos = $pagosRaw->map(function ($pago) {
            return (object)[
                'tipo'        => 'ingreso',
                'fecha'       => $pago->fecha_pago,
                'concepto'    => 'Ingreso: Pago de ' . ($pago->paciente ? $pago->paciente->nombre . ' ' . $pago->paciente->apellido : 'Paciente'),
                'categoria'   => $pago->cita && $pago->cita->servicio ? $pago->cita->servicio->nombre : 'Tratamiento',
                'metodo_pago' => $pago->metodo_pago,
                'comprobante' => ucfirst($pago->estado),
                'monto'       => $pago->monto
            ];
        });

        // Fetch Expenses (Gastos)
        $gastosQuery = Gasto::query()
            ->select(['id', 'concepto', 'descripcion', 'monto', 'categoria', 'metodo_pago', 'fecha_gasto', 'comprobante'])
            ->whereYear('fecha_gasto', $year)
            ->whereMonth('fecha_gasto', $month);

        if ($search) {
            $gastosQuery->where('concepto', 'like', "%{$search}%");
        }
        if ($categoria) {
            $gastosQuery->where('categoria', $categoria);
        }
        $gastosRaw = $gastosQuery->orderBy('fecha_gasto', 'desc')->get();
        $egresos = $gastosRaw->map(function ($gasto) {
            return (object)[
                'tipo'        => 'egreso',
                'fecha'       => $gasto->fecha_gasto,
                'concepto'    => 'Egreso: ' . $gasto->concepto,
                'categoria'   => $gasto->categoria,
                'metodo_pago' => $gasto->metodo_pago,
                'comprobante' => $gasto->comprobante ?? '—',
                'monto'       => $gasto->monto
            ];
        });

        $totalIngresos = $ingresos->sum('monto');
        $totalEgresos  = $egresos->sum('monto');
        $balance       = $totalIngresos - $totalEgresos;

        $movimientos = collect();
        if (!$tipo || $tipo === 'ingreso') {
            $movimientos = $movimientos->concat($ingresos);
        }
        if (!$tipo || $tipo === 'egreso') {
            $movimientos = $movimientos->concat($egresos);
        }
        $movimientos = $movimientos->sortByDesc('fecha');

        $doctora = Doctora::first();

        $pdf = Pdf::loadView('pdf.reporte_finanzas', compact(
            'movimientos', 'totalIngresos', 'totalEgresos', 'balance',
            'mes', 'search', 'categoria', 'tipo', 'doctora'
        ))->setPaper('a4', 'portrait');

        $filename = 'caja-finanzas-' . $mes . '.pdf';

        return $pdf->download($filename);
    }

    private function formatearMovimiento(object $movimiento): array
    {
        return [
            'id' => $movimiento->id,
            'tipo' => $movimiento->tipo,
            'fecha' => $movimiento->fecha?->format('Y-m-d'),
            'fecha_display' => $movimiento->fecha?->format('d/m/Y'),
            'concepto' => $movimiento->concepto,
            'categoria' => $movimiento->categoria,
            'metodo_pago' => $movimiento->metodo_pago,
            'estado' => $movimiento->comprobante_estado,
            'monto' => (float) $movimiento->monto,
            'monto_display' => 'S/. ' . number_format((float) $movimiento->monto, 2),
        ];
    }

    private function formatearClienteFinanzas(Paciente $paciente): array
    {
        return [
            'id' => $paciente->id,
            'nombre' => $paciente->nombre,
            'apellido' => $paciente->apellido,
            'nombre_completo' => trim($paciente->nombre . ' ' . $paciente->apellido),
            'dni' => $paciente->dni,
            'telefono' => $paciente->telefono,
            'total_cost' => (float) $paciente->total_cost,
            'total_paid' => (float) $paciente->total_paid,
            'pending_amount' => (float) $paciente->pending_amount,
            'estado_pago' => $paciente->estado_pago,
            'next_due_date' => $paciente->next_due_date?->format('Y-m-d'),
            'days_elapsed' => $paciente->days_elapsed,
            'days_until_due' => $paciente->days_until_due,
            'days_overdue' => $paciente->days_overdue,
        ];
    }
}
