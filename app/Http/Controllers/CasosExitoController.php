<?php

namespace App\Http\Controllers;

use App\Http\Requests\CasoExitoRequest;
use App\Models\CasoExito;
use Illuminate\Http\Request;
use App\Services\ImageUploadService;

class CasosExitoController extends Controller
{
    /**
     * Display a listing of success cases.
     */
    public function index(Request $request)
    {
        $search = trim((string) ($request->query('search') ?? $request->query('buscar', '')));
        $status = $request->query('status');

        $query = CasoExito::query()
            ->select(['id', 'titulo_tratamiento', 'descripcion_resultado', 'categoria', 'antes_img', 'despues_img', 'activo', 'created_at'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($q) use ($search) {
                    $q->where('titulo_tratamiento', 'like', "%{$search}%")
                        ->orWhere('descripcion_resultado', 'like', "%{$search}%")
                        ->orWhere('categoria', 'like', "%{$search}%");
                });
            })
            ->when($status !== null && $status !== 'Todas', function ($query) use ($status): void {
                $query->where('activo', $status === 'activas' ? 1 : 0);
            })
            ->orderBy('created_at', 'desc');

        if ($this->shouldReturnJson($request)) {
            $casos = $query->paginate(12)->withQueryString();

            return $this->paginatedJson($casos, fn(CasoExito $caso): array => $this->formatearCaso($caso));
        }

        $casos = $query->get();

        return view('casos_exito', compact('casos', 'search', 'status'));
    }

    /**
     * Store a newly created success case.
     */
    public function store(CasoExitoRequest $request, ImageUploadService $imageService)
    {
        $validated = $request->validated();
        $validated['activo'] = (bool)$validated['activo'];

        if ($request->hasFile('antes')) {
            $validated['antes_img'] = $imageService->upload($request->file('antes'), 'uploads/casos', 800);
        }

        if ($request->hasFile('despues')) {
            $validated['despues_img'] = $imageService->upload($request->file('despues'), 'uploads/casos', 800);
        }

        $caso = CasoExito::create($validated);

        return $this->savedResponse(
            $request,
            'casos-exito.index',
            'Caso de Éxito registrado correctamente.',
            ['caso' => $this->formatearCaso($caso)],
            201
        );
    }

    /**
     * Update the specified success case.
     */
    public function update(CasoExitoRequest $request, int $id, ImageUploadService $imageService)
    {
        $caso = CasoExito::findOrFail($id);

        $validated = $request->validated();
        $validated['activo'] = (bool)$validated['activo'];

        if ($request->hasFile('antes')) {
            $imageService->delete($caso->antes_img);
            $validated['antes_img'] = $imageService->upload($request->file('antes'), 'uploads/casos', 800);
        }

        if ($request->hasFile('despues')) {
            $imageService->delete($caso->despues_img);
            $validated['despues_img'] = $imageService->upload($request->file('despues'), 'uploads/casos', 800);
        }

        $caso->update($validated);

        return $this->savedResponse(
            $request,
            'casos-exito.index',
            'Caso de Éxito actualizado correctamente.',
            ['caso' => $this->formatearCaso($caso->fresh())]
        );
    }

    /**
     * Remove the specified success case.
     */
    public function destroy(Request $request, int $id, ImageUploadService $imageService)
    {
        $caso = CasoExito::findOrFail($id);

        $imageService->delete($caso->antes_img);
        $imageService->delete($caso->despues_img);

        $caso->delete();

        return $this->deletedResponse($request, 'casos-exito.index', 'Caso de Éxito eliminado correctamente.');
    }

    private function formatearCaso(CasoExito $caso): array
    {
        return [
            'id' => $caso->id,
            'titulo_tratamiento' => $caso->titulo_tratamiento,
            'descripcion_resultado' => $caso->descripcion_resultado,
            'categoria' => $caso->categoria,
            'antes_url' => image_url($caso->antes_img),
            'despues_url' => image_url($caso->despues_img),
            'activo' => (bool) $caso->activo,
            'estado_label' => $caso->activo ? 'Visible' : 'Oculto',
            'creado' => $caso->created_at?->format('d/m/Y H:i'),
        ];
    }
}
