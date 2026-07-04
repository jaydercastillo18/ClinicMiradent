<?php

namespace App\Http\Controllers;

use App\Http\Requests\CitaRequest;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Servicio;
use App\Models\Doctora;
use Illuminate\Http\Request;

class CitasController extends Controller
{
    /**
     * Display a listing of appointments (List View and dropdown data).
     */
    public function index(Request $request)
    {
        $search = trim((string) ($request->query('search') ?? $request->query('buscar', '')));
        $status = $request->query('status');
        $date = $request->query('date');

        $query = Cita::query()
            ->select(['id', 'paciente_id', 'servicio_id', 'doctora_id', 'fecha_hora', 'motivo', 'diagnostico', 'notas_tratamiento', 'estado', 'created_at'])
            ->with([
                'paciente:id,nombre,apellido,dni,telefono',
                'servicio:id,nombre,precio,duracion_minutos',
                'doctora:id,user_id',
                'doctora.user:id,name',
            ])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('estado', 'like', "%{$search}%")
                        ->orWhere('motivo', 'like', "%{$search}%")
                        ->orWhereHas('servicio', fn ($query) => $query->where('nombre', 'like', "%{$search}%"))
                        ->orWhereHas('paciente', function ($query) use ($search): void {
                            $query->where('nombre', 'like', "%{$search}%")
                                ->orWhere('apellido', 'like', "%{$search}%")
                                ->orWhere('dni', 'like', "%{$search}%")
                                ->orWhere('telefono', 'like', "%{$search}%");
                        });
                });
            })
            ->when($status && $status !== 'Todas', fn ($query) => $query->where('estado', $status))
            ->when($date, fn ($query) => $query->whereDate('fecha_hora', $date))
            ->orderBy('fecha_hora', 'desc');

        $citas = $query->paginate(15)->withQueryString();

        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'current_page' => $citas->currentPage(),
                'data' => \App\Http\Resources\CitaResource::collection($citas->items()),
                'first_page_url' => $citas->url(1),
                'from' => $citas->firstItem(),
                'last_page' => $citas->lastPage(),
                'last_page_url' => $citas->url($citas->lastPage()),
                'links' => $citas->linkCollection(),
                'next_page_url' => $citas->nextPageUrl(),
                'path' => $citas->path(),
                'per_page' => $citas->perPage(),
                'prev_page_url' => $citas->previousPageUrl(),
                'to' => $citas->lastItem(),
                'total' => $citas->total(),
            ]);
        }

        // Data for dropdown selects in modals
        $pacientes = Paciente::orderBy('nombre', 'asc')->get(['id', 'nombre', 'apellido', 'dni', 'telefono']);
        $servicios = Servicio::where('activo', true)->orderBy('nombre', 'asc')->get(['id', 'nombre', 'precio', 'duracion_minutos']);
        $doctoras = Doctora::with('user:id,name')->get(['id', 'user_id', 'especialidad']);

        return view('citas', compact('citas', 'pacientes', 'servicios', 'doctoras', 'search', 'status', 'date'));
    }

    /**
     * Get JSON array of events for FullCalendar.
     */
    public function apiEvents(Request $request)
    {
        $citas = Cita::query()
            ->select(['id', 'paciente_id', 'servicio_id', 'doctora_id', 'fecha_hora', 'motivo', 'diagnostico', 'notas_tratamiento', 'estado'])
            ->with([
                'paciente:id,nombre,apellido,telefono',
                'servicio:id,nombre',
                'doctora:id,user_id',
                'doctora.user:id,name',
            ])
            ->when($request->query('start'), fn ($query, $start) => $query->where('fecha_hora', '>=', $start))
            ->when($request->query('end'), fn ($query, $end) => $query->where('fecha_hora', '<=', $end))
            ->get();

        $isDoctora = $request->user()?->role === 'doctora';

        $events = $citas->map(function($cita) use ($isDoctora) {
            // Pick event color based on appointment state
            $color = '#3b82f6'; // default blue (pendiente)
            if ($cita->estado === 'completada') {
                $color = '#207f54'; // jade green
            } elseif ($cita->estado === 'confirmada') {
                $color = '#f59e0b'; // amber
            } elseif ($cita->estado === 'en_espera') {
                $color = '#8b5cf6'; // purple
            } elseif ($cita->estado === 'cancelada') {
                $color = '#6b7280'; // gray
            }

            $props = [
                'paciente_id' => $cita->paciente_id,
                'paciente_nombre' => trim(($cita->paciente?->nombre ?? '') . ' ' . ($cita->paciente?->apellido ?? '')),
                'paciente_telefono' => $cita->paciente?->telefono,
                'doctora_id' => $cita->doctora_id,
                'doctora_nombre' => $cita->doctora?->user?->name,
                'servicio_id' => $cita->servicio_id,
                'servicio_nombre' => $cita->servicio?->nombre,
                'fecha_hora_formatted' => $cita->fecha_hora?->format('Y-m-d\TH:i'),
                'motivo' => $cita->motivo,
                'estado' => $cita->estado
            ];

            if ($isDoctora) {
                $props['diagnostico'] = $cita->diagnostico;
                $props['notes'] = $cita->notas_tratamiento;
            }

            return [
                'id' => $cita->id,
                'title' => trim(($cita->paciente?->nombre ?? 'Paciente') . ' ' . substr((string) $cita->paciente?->apellido, 0, 1)) . '. - ' . ($cita->servicio?->nombre ?? 'Tratamiento'),
                'start' => $cita->fecha_hora,
                'backgroundColor' => $color,
                'borderColor' => $color,
                'textColor' => '#ffffff',
                'extendedProps' => $props
            ];
        });

        return response()->json($events);
    }

    /**
     * Store a newly scheduled appointment.
     */
    public function store(CitaRequest $request)
    {
        $cita = Cita::create($request->validated());

        return $this->savedResponse(
            $request,
            'citas.index',
            'Cita agendada correctamente.',
            ['cita' => new \App\Http\Resources\CitaResource($cita->load(['paciente:id,nombre,apellido,dni,telefono', 'servicio:id,nombre,precio,duracion_minutos', 'doctora.user:id,name']))],
            201
        );
    }

    /**
     * Update an appointment record.
     */
    public function update(CitaRequest $request, string $id)
    {
        $cita = Cita::findOrFail($id);

        if ($request->hasAny(['diagnostico', 'notas_tratamiento'])) {
            \Illuminate\Support\Facades\Gate::authorize('updateDiagnosis', $cita);
        } else {
            \Illuminate\Support\Facades\Gate::authorize('updateSchedule', $cita);
        }

        $cita->update($request->validated());

        return $this->savedResponse(
            $request,
            'citas.index',
            'La cita #'.$cita->id.' ha sido actualizada correctamente.',
            ['cita' => new \App\Http\Resources\CitaResource($cita->fresh()->load(['paciente:id,nombre,apellido,dni,telefono', 'servicio:id,nombre,precio,duracion_minutos', 'doctora.user:id,name']))]
        );
    }

    /**
     * Cancel / soft delete an appointment.
     */
    public function destroy(Request $request, string $id)
    {
        $cita = Cita::findOrFail($id);

        \Illuminate\Support\Facades\Gate::authorize('delete', $cita);

        if ($cita->pagos()->exists()) {
            $message = 'No se puede eliminar la cita porque tiene pagos asociados.';

            if ($this->shouldReturnJson($request)) {
                return response()->json(['message' => $message], 422);
            }

            return redirect()->route('citas.index')->withErrors(['cita' => $message]);
        }

        $cita->delete();

        return $this->deletedResponse($request, 'citas.index', 'Cita cancelada y eliminada del calendario activo.');
    }

    // formatearCita is deprecated

    private function estadoLabel(string $estado): string
    {
        return [
            'pendiente' => 'Pendiente',
            'confirmada' => 'Confirmada',
            'completada' => 'Completada',
            'cancelada' => 'Cancelada',
            'en_espera' => 'En espera',
            'atendida' => 'Atendida',
            'reprogramada' => 'Reprogramada',
        ][$estado] ?? $estado;
    }
}
