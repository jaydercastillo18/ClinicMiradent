<?php

namespace App\Http\Controllers;

use App\Models\Instalacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Services\ImageUploadService;

class InstalacionController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) ($request->query('search') ?? $request->query('buscar', '')));
        $status = $request->query('status');

        $query = Instalacion::query()
            ->select(['id', 'titulo', 'imagen_path', 'orden', 'activo', 'created_at'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where('titulo', 'like', "%{$search}%");
            })
            ->when($status !== null && $status !== 'Todas', function ($query) use ($status): void {
                $query->where('activo', $status === 'activas' ? 1 : 0);
            })
            ->orderBy('orden', 'asc')
            ->orderBy('created_at', 'desc');

        if ($this->shouldReturnJson($request)) {
            $instalaciones = $query->paginate(12)->withQueryString();
            return $this->paginatedJson($instalaciones, fn(Instalacion $instalacion): array => $this->formatearInstalacion($instalacion));
        }

        $instalaciones = $query->get();

        return view('instalaciones', compact('instalaciones', 'search', 'status'));
    }

    public function store(Request $request, ImageUploadService $imageService)
    {
        $validated = $request->validate([
            'titulo' => 'nullable|string|max:255',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:15360',
            'orden' => 'nullable|integer',
            'activo' => 'required|boolean',
        ]);

        $validated['activo'] = (bool)$validated['activo'];
        $validated['orden'] = $validated['orden'] ?? 0;

        if ($request->hasFile('imagen')) {
            $validated['imagen_path'] = $imageService->upload($request->file('imagen'), 'uploads/instalaciones');
        }

        $instalacion = Instalacion::create($validated);

        return $this->savedResponse(
            $request,
            'instalaciones.index',
            'Imagen de instalación subida correctamente.',
            ['instalacion' => $this->formatearInstalacion($instalacion)],
            201
        );
    }

    public function update(Request $request, int $id, ImageUploadService $imageService)
    {
        $instalacion = Instalacion::findOrFail($id);

        $validated = $request->validate([
            'titulo' => 'nullable|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:15360',
            'orden' => 'nullable|integer',
            'activo' => 'required|boolean',
        ]);

        $validated['activo'] = (bool)$validated['activo'];
        $validated['orden'] = $validated['orden'] ?? 0;

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior
            $imageService->delete($instalacion->imagen_path);
            $validated['imagen_path'] = $imageService->upload($request->file('imagen'), 'uploads/instalaciones');
        }

        $instalacion->update($validated);

        return $this->savedResponse(
            $request,
            'instalaciones.index',
            'Imagen de instalación actualizada correctamente.',
            ['instalacion' => $this->formatearInstalacion($instalacion)]
        );
    }

    public function destroy(Request $request, int $id, ImageUploadService $imageService)
    {
        $instalacion = Instalacion::findOrFail($id);

        $imageService->delete($instalacion->imagen_path);

        $instalacion->delete();

        if ($this->shouldReturnJson($request)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Imagen eliminada correctamente.'
            ]);
        }

        return redirect()->route('instalaciones.index')->with('success', 'Imagen eliminada correctamente.');
    }

    private function formatearInstalacion(Instalacion $instalacion): array
    {
        return [
            'id' => $instalacion->id,
            'titulo' => $instalacion->titulo,
            'orden' => $instalacion->orden,
            'imagen_url' => $instalacion->imagen_path ? asset($instalacion->imagen_path) : null,
            'activo' => (bool) $instalacion->activo,
            'estado_label' => $instalacion->activo ? 'Visible' : 'Oculto',
            'creado' => $instalacion->created_at?->format('d/m/Y H:i'),
        ];
    }
}
