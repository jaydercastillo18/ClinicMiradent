<?php

namespace App\Http\Controllers;

use App\Http\Requests\PacienteRequest;
use App\Models\Paciente;
use App\Models\Doctora;
use App\Models\Cita;
use App\Models\Pago;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PacientesController extends Controller
{
    /**
     * Display a listing of the patients with dynamic search.
     */
    public function index(Request $request)
    {
        $search = trim((string) ($request->query('search') ?? $request->query('buscar', '')));

        $query = Paciente::query()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('dni', 'like', "%{$search}%")
                    ->orWhere('telefono', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc');

        $pacientes = $query->paginate(15)->withQueryString();

        return view('pacientes', compact('pacientes', 'search'));
    }

    /**
     * Search for patients via JSON (Axios calls)
     */
    public function buscar(Request $request)
    {
        $search = trim((string) ($request->query('search') ?? $request->query('buscar', '')));

        $query = Paciente::query()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apellido', 'like', "%{$search}%")
                    ->orWhere('dni', 'like', "%{$search}%")
                    ->orWhere('telefono', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc');

        $pacientes = $query->paginate(15)->withQueryString();

        return response()->json([
            'current_page' => $pacientes->currentPage(),
            'data' => \App\Http\Resources\PacienteResource::collection($pacientes->items()),
            'first_page_url' => $pacientes->url(1),
            'from' => $pacientes->firstItem(),
            'last_page' => $pacientes->lastPage(),
            'last_page_url' => $pacientes->url($pacientes->lastPage()),
            'links' => $pacientes->linkCollection(),
            'next_page_url' => $pacientes->nextPageUrl(),
            'path' => $pacientes->path(),
            'per_page' => $pacientes->perPage(),
            'prev_page_url' => $pacientes->previousPageUrl(),
            'to' => $pacientes->lastItem(),
            'total' => $pacientes->total(),
        ]);
    }

    /**
     * Show the form for creating a new patient.
     */
    public function create(Request $request)
    {
        $existingPatients = Paciente::select('id', 'nombre', 'apellido', 'dni')->get();

        if ($request->has('modal') || $request->ajax()) {
            /** @var \Illuminate\View\View $view */
            $view = view('regpaciente', compact('existingPatients'));
            $sections = $view->renderSections();
            return response(($sections['content'] ?? '') . ($sections['scripts'] ?? ''));
        }

        return view('regpaciente', compact('existingPatients'));
    }

    /**
     * Store a newly created patient in storage.
     */
    public function store(PacienteRequest $request)
    {
        $paciente = Paciente::create($request->validated());

        return $this->savedResponse(
            $request,
            'pacientes.index',
            'Paciente registrado correctamente.',
            ['paciente' => new \App\Http\Resources\PacienteResource($paciente)],
            201
        );
    }

    /**
     * Display the specified patient's profile and medical history.
     */
    public function show(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        
        // Fetch appointments sorted by date/time (latest first) with related services and doctor
        $citas = $paciente->citas()
            ->with(['servicio', 'doctora.user'])
            ->orderBy('fecha_hora', 'desc')
            ->get();
            
        // Fetch payments sorted by payment date (latest first)
        $pagos = $paciente->pagos()
            ->with(['cita:id,servicio_id,fecha_hora', 'cita.servicio:id,nombre'])
            ->orderBy('fecha_pago', 'desc')
            ->get();

        if (request()->wantsJson() || request()->expectsJson()) {
            return response()->json([
                'paciente' => new \App\Http\Resources\PacienteResource($paciente),
                'historial' => $this->formatearHistorial($citas, $pagos),
                'citas' => \App\Http\Resources\CitaResource::collection($citas),
                'pagos' => $pagos->map(fn (Pago $pago): array => $this->formatearPagoHistorial($pago))->values(),
            ]);
        }

        return view('historial', compact('paciente', 'citas', 'pagos'));
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit(Request $request, string $id)
    {
        $paciente = Paciente::findOrFail($id);
        $existingPatients = Paciente::select('id', 'nombre', 'apellido', 'dni')
            ->where('id', '!=', $id)
            ->get();

        if ($request->has('modal') || $request->ajax()) {
            /** @var \Illuminate\View\View $view */
            $view = view('editpaciente', compact('paciente', 'existingPatients'));
            $sections = $view->renderSections();
            return response(($sections['content'] ?? '') . ($sections['scripts'] ?? ''));
        }

        return view('editpaciente', compact('paciente', 'existingPatients'));
    }

    /**
     * Update the specified patient in storage.
     */
    public function update(PacienteRequest $request, string $id)
    {
        $paciente = Paciente::findOrFail($id);

        if ($request->hasAny(['antecedentes_medicos', 'alergias', 'medicamentos_habituales', 'contacto_emergencia_nombre'])) {
            \Illuminate\Support\Facades\Gate::authorize('updateClinicalData', $paciente);
        } else {
            \Illuminate\Support\Facades\Gate::authorize('updateBasicData', $paciente);
        }

        $paciente->update($request->validated());

        return $this->savedResponse(
            $request,
            'pacientes.index',
            'Datos del paciente actualizados correctamente.',
            ['paciente' => new \App\Http\Resources\PacienteResource($paciente->fresh())]
        );
    }

    /**
     * Remove the specified patient from storage (soft delete).
     */
    public function destroy(Request $request, string $id)
    {
        $paciente = Paciente::findOrFail($id);
        
        \Illuminate\Support\Facades\Gate::authorize('delete', $paciente);

        if ($paciente->citas()->exists() || $paciente->pagos()->exists()) {
            $message = 'No se puede eliminar el paciente porque tiene citas o pagos asociados.';

            if ($this->shouldReturnJson($request)) {
                return response()->json(['message' => $message], 422);
            }

            return redirect()->route('pacientes.index')->withErrors(['paciente' => $message]);
        }

        $paciente->delete();

        return $this->deletedResponse($request, 'pacientes.index', 'Paciente eliminado correctamente de la lista activa.');
    }

    /**
     * Generate and download clinical record PDF for the specified patient.
     */
    public function descargarFicha(string $id)
    {
        $paciente = Paciente::findOrFail($id);

        $citas = $paciente->citas()
            ->with(['servicio', 'doctora.user'])
            ->orderBy('fecha_hora', 'desc')
            ->get();

        $pagos = $paciente->pagos()
            ->orderBy('fecha_pago', 'desc')
            ->get();

        $doctora = Doctora::first();

        $pdf = Pdf::loadView('pdf.ficha_clinica', compact('paciente', 'citas', 'pagos', 'doctora'))
            ->setPaper('a4', 'portrait');

        $filename = 'ficha-clinica-' . str($paciente->nombre . '-' . $paciente->apellido)->slug() . '.pdf';

        return $pdf->download($filename);
    }

    // formatearPaciente is deprecated in favor of PacienteResource

    private function formatearHistorial(\Illuminate\Support\Collection $citas, \Illuminate\Support\Collection $pagos): array
    {
        return $citas
            ->map(fn (Cita $cita): array => [
                'tipo' => 'cita',
                'fecha' => $cita->fecha_hora?->format('d/m/Y H:i'),
                'fecha_raw' => $cita->fecha_hora,
                'detalle' => ($cita->servicio?->nombre ?? 'Tratamiento') . ' - ' . $this->estadoCitaLabel($cita->estado),
                'monto' => null,
            ])
            ->concat($pagos->map(fn (Pago $pago): array => [
                'tipo' => 'pago',
                'fecha' => $pago->fecha_pago?->format('d/m/Y'),
                'fecha_raw' => $pago->fecha_pago,
                'detalle' => 'Pago - ' . $this->estadoPagoLabel($pago->estado),
                'monto' => 'S/. ' . number_format((float) $pago->monto, 2),
            ]))
            ->sortByDesc('fecha_raw')
            ->values()
            ->all();
    }

    // formatearCitaHistorial is deprecated in favor of CitaResource

    private function formatearPagoHistorial(Pago $pago): array
    {
        return [
            'id' => $pago->id,
            'fecha_pago' => $pago->fecha_pago?->format('Y-m-d'),
            'fecha_display' => $pago->fecha_pago?->format('d/m/Y'),
            'monto' => $pago->monto,
            'monto_display' => 'S/. ' . number_format((float) $pago->monto, 2),
            'metodo_pago' => $pago->metodo_pago,
            'estado' => $pago->estado,
            'estado_label' => $this->estadoPagoLabel($pago->estado),
            'notas' => $pago->notas,
        ];
    }

    private function estadoCitaLabel(?string $estado): string
    {
        return [
            'pendiente' => 'Pendiente',
            'confirmada' => 'Confirmada',
            'completada' => 'Completada',
            'cancelada' => 'Cancelada',
            'en_espera' => 'En espera',
        ][$estado] ?? (string) $estado;
    }

    private function estadoPagoLabel(?string $estado): string
    {
        return [
            'pendiente' => 'Pendiente',
            'parcial' => 'Parcial',
            'pagado' => 'Pagado',
            'reembolsado' => 'Reembolsado',
        ][$estado] ?? (string) $estado;
    }
}
