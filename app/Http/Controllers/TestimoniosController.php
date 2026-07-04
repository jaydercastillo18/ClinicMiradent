<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonioRequest;
use App\Models\Testimonio;
use Illuminate\Http\Request;

class TestimoniosController extends Controller
{
    /**
     * Display a listing of testimonials.
     */
    public function index(Request $request)
    {
        $search = trim((string) ($request->query('search') ?? $request->query('buscar', '')));
        $status = $request->query('status');

        $query = Testimonio::query()
            ->select(['id', 'nombre_paciente', 'testimonio', 'fecha', 'estrellas', 'activo', 'created_at'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function($q) use ($search) {
                    $q->where('nombre_paciente', 'like', "%{$search}%")
                        ->orWhere('testimonio', 'like', "%{$search}%");
                });
            })
            ->when($status !== null && $status !== 'Todas', function ($query) use ($status): void {
                $query->where('activo', $status === 'activas' ? 1 : 0);
            })
            ->orderBy('created_at', 'desc');

        if ($this->shouldReturnJson($request)) {
            $testimonios = $query->paginate(12)->withQueryString();

            return $this->paginatedJson($testimonios, fn (Testimonio $testimonio): array => $this->formatearTestimonio($testimonio));
        }

        $testimonios = $query->get();

        return view('testimonios', compact('testimonios', 'search', 'status'));
    }

    /**
     * Store a newly created testimonial.
     */
    public function store(TestimonioRequest $request)
    {
        $validated = $request->validated();
        $validated['activo'] = (bool)$validated['activo'];

        $testimonio = Testimonio::create($validated);

        return $this->savedResponse(
            $request,
            'testimonios.index',
            'Testimonio registrado correctamente.',
            ['testimonio' => $this->formatearTestimonio($testimonio)],
            201
        );
    }

    /**
     * Update the specified testimonial.
     */
    public function update(TestimonioRequest $request, $id)
    {
        $testimonio = Testimonio::findOrFail($id);

        $validated = $request->validated();
        $validated['activo'] = (bool)$validated['activo'];

        $testimonio->update($validated);

        return $this->savedResponse(
            $request,
            'testimonios.index',
            'Testimonio actualizado correctamente.',
            ['testimonio' => $this->formatearTestimonio($testimonio->fresh())]
        );
    }

    /**
     * Remove the specified testimonial.
     */
    public function destroy(Request $request, $id)
    {
        $testimonio = Testimonio::findOrFail($id);
        $testimonio->delete();

        return $this->deletedResponse($request, 'testimonios.index', 'Testimonio eliminado correctamente.');
    }

    private function formatearTestimonio(Testimonio $testimonio): array
    {
        return [
            'id' => $testimonio->id,
            'nombre_paciente' => $testimonio->nombre_paciente,
            'testimonio' => $testimonio->testimonio,
            'fecha' => $testimonio->fecha?->format('Y-m-d'),
            'fecha_display' => $testimonio->fecha?->format('d/m/Y'),
            'estrellas' => $testimonio->estrellas,
            'activo' => (bool) $testimonio->activo,
            'estado_label' => $testimonio->activo ? 'Visible' : 'Oculto',
            'creado' => $testimonio->created_at?->format('d/m/Y H:i'),
        ];
    }
}
