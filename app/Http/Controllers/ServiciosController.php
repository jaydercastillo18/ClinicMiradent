<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServicioRequest;
use App\Models\Servicio;
use Illuminate\Http\Request;
use App\Services\ImageUploadService;

class ServiciosController extends Controller
{
    /**
     * Display a listing of services with search and category filters.
     */
    public function index(Request $request)
    {
        $search = trim((string) ($request->query('search') ?? $request->query('buscar', '')));
        $category = $request->query('category');
        $estado = $request->query('estado');

        $query = Servicio::query()
            ->select(['id', 'nombre', 'descripcion', 'precio', 'duracion_minutos', 'categoria', 'activo', 'imagen_path', 'created_at', 'updated_at'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('nombre', 'like', "%{$search}%")
                        ->orWhere('descripcion', 'like', "%{$search}%")
                        ->orWhere('categoria', 'like', "%{$search}%");
                });
            })
            ->when($category && $category !== 'Todas', fn ($query) => $query->where('categoria', $category))
            ->when($estado === 'activo', fn ($query) => $query->where('activo', true))
            ->when($estado === 'inactivo', fn ($query) => $query->where('activo', false))
            ->orderByDesc('activo')
            ->orderBy('nombre', 'asc');

        $categories = Servicio::pluck('categoria')->unique()->filter()->values()->all();
        if (empty($categories)) {
            $categories = ['Prevención', 'Ortodoncia', 'Endodoncia', 'Estética', 'Cirugía', 'Implantes'];
        }

        $servicios = $query->paginate(12)->withQueryString();

        if ($this->shouldReturnJson($request)) {
            return $this->paginatedJson($servicios, fn (Servicio $servicio): array => $this->formatearServicio($servicio));
        }

        return view('servicios', compact('servicios', 'categories', 'search', 'category'));
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(ServicioRequest $request, ImageUploadService $imageService)
    {
        $validated = $request->validated();
        $validated['activo'] = $request->has('activo') ? 1 : 0;

        if ($request->hasFile('imagen')) {
            $validated['imagen_path'] = $imageService->upload($request->file('imagen'), 'uploads/servicios', 800);
        }

        $servicio = Servicio::create($validated);

        return $this->savedResponse(
            $request,
            'servicios.index',
            'Tratamiento registrado correctamente en el catálogo.',
            ['servicio' => $this->formatearServicio($servicio)],
            201
        );
    }

    /**
     * Update the specified service in storage.
     */
    public function update(ServicioRequest $request, int $id, ImageUploadService $imageService)
    {
        $servicio = Servicio::findOrFail($id);

        $validated = $request->validated();
        $validated['activo'] = $request->has('activo') ? 1 : 0;

        if ($request->hasFile('imagen')) {
            $imageService->delete($servicio->imagen_path);
            $validated['imagen_path'] = $imageService->upload($request->file('imagen'), 'uploads/servicios', 800);
        } elseif ($request->boolean('eliminar_imagen')) {
            $imageService->delete($servicio->imagen_path);
            $validated['imagen_path'] = null;
        }

        $servicio->update($validated);

        return $this->savedResponse(
            $request,
            'servicios.index',
            'Tratamiento actualizado correctamente.',
            ['servicio' => $this->formatearServicio($servicio->fresh())]
        );
    }

    /**
     * Remove the specified service from storage (soft delete).
     */
    public function destroy(Request $request, int $id, ImageUploadService $imageService)
    {
        $servicio = Servicio::withCount('citas')->findOrFail($id);

        if ($servicio->citas_count > 0 || $servicio->citas()->whereHas('pagos')->exists()) {
            $message = 'No se puede eliminar el tratamiento porque tiene citas o pagos asociados.';

            if ($this->shouldReturnJson($request)) {
                return response()->json(['message' => $message], 422);
            }

            return redirect()->route('servicios.index')->withErrors(['servicio' => $message]);
        }

        $imageService->delete($servicio->imagen_path);
        $servicio->delete();

        return $this->deletedResponse($request, 'servicios.index', 'Tratamiento eliminado correctamente del catálogo activo.');
    }



    private function formatearServicio(Servicio $servicio): array
    {
        return [
            'id' => $servicio->id,
            'nombre' => $servicio->nombre,
            'descripcion' => $servicio->descripcion,
            'precio' => $servicio->precio,
            'precio_display' => 'S/. ' . number_format((float) $servicio->precio, 2),
            'duracion_minutos' => $servicio->duracion_minutos,
            'categoria' => $servicio->categoria,
            'activo' => (bool) $servicio->activo,
            'estado_label' => $servicio->activo ? 'Activo' : 'Inactivo',
            'imagen_url' => image_url($servicio->imagen_path),
            'creado' => $servicio->created_at?->format('d/m/Y H:i'),
            'actualizado' => $servicio->updated_at?->format('d/m/Y H:i'),
        ];
    }
}
