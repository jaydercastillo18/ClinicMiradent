<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromocionRequest;
use App\Models\Promocion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\ImageUploadService;

class PromocionesController extends Controller
{
    /**
     * Display a listing of promotions with searching and filtering.
     */
    public function index(Request $request)
    {
        $search = trim((string) ($request->query('search') ?? $request->query('buscar', '')));
        $status = $request->query('status');

        $query = Promocion::query()
            ->select(['id', 'titulo', 'descripcion', 'descuento_porcentaje', 'fecha_inicio', 'fecha_fin', 'activo', 'imagen_path', 'created_at'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function($q) use ($search) {
                    $q->where('titulo', 'like', "%{$search}%")
                        ->orWhere('descripcion', 'like', "%{$search}%");
                });
            })
            ->when($status !== null && $status !== 'Todas', function ($query) use ($status): void {
                $query->where('activo', $status === 'activas' ? 1 : 0);
            })
            ->orderBy('fecha_fin', 'asc');

        if ($this->shouldReturnJson($request)) {
            $promociones = $query->paginate(12)->withQueryString();

            return $this->paginatedJson($promociones, fn (Promocion $promocion): array => $this->formatearPromocion($promocion));
        }

        $promociones = $query->get();

        return view('promociones', compact('promociones', 'search', 'status'));
    }

    /**
     * Store a newly created promotion in storage.
     */
    public function store(PromocionRequest $request, ImageUploadService $imageService)
    {
        $validated = $request->validated();

        // Convert active switch input to bool integer
        $validated['activo'] = (bool)$validated['activo'];

        // File upload handling
        if ($request->hasFile('imagen')) {
            $validated['imagen_path'] = $imageService->upload($request->file('imagen'), 'uploads/promociones', 800);
        }

        $promocion = Promocion::create($validated);
        Cache::forget('home_promociones');

        return $this->savedResponse(
            $request,
            'promociones.index',
            'Campaña promocional creada correctamente.',
            ['promocion' => $this->formatearPromocion($promocion)],
            201
        );
    }

    /**
     * Update the specified promotion in storage.
     */
    public function update(PromocionRequest $request, string $id, ImageUploadService $imageService)
    {
        $promocion = Promocion::findOrFail($id);

        $validated = $request->validated();
        $validated['activo'] = (bool)$validated['activo'];

        // File upload handling
        if ($request->hasFile('imagen')) {
            $imageService->delete($promocion->imagen_path);
            $validated['imagen_path'] = $imageService->upload($request->file('imagen'), 'uploads/promociones', 800);
        }

        $promocion->update($validated);
        Cache::forget('home_promociones');

        return $this->savedResponse(
            $request,
            'promociones.index',
            'Campaña promocional actualizada correctamente.',
            ['promocion' => $this->formatearPromocion($promocion->fresh())]
        );
    }

    /**
     * Remove the specified promotion (soft delete).
     */
    public function destroy(Request $request, string $id, ImageUploadService $imageService)
    {
        $promocion = Promocion::findOrFail($id);
        $imageService->delete($promocion->imagen_path);
        $promocion->delete();
        Cache::forget('home_promociones');

        return $this->deletedResponse($request, 'promociones.index', 'Campaña promocional eliminada.');
    }

    private function formatearPromocion(Promocion $promocion): array
    {
        return [
            'id' => $promocion->id,
            'titulo' => $promocion->titulo,
            'descripcion' => $promocion->descripcion,
            'descuento_porcentaje' => $promocion->descuento_porcentaje,
            'fecha_inicio' => $promocion->fecha_inicio?->format('Y-m-d'),
            'fecha_fin' => $promocion->fecha_fin?->format('Y-m-d'),
            'activo' => (bool) $promocion->activo,
            'estado_label' => $promocion->activo ? 'Activa' : 'Inactiva',
            'imagen_url' => image_url($promocion->imagen_path),
            'creado' => $promocion->created_at?->format('d/m/Y H:i'),
        ];
    }
}
