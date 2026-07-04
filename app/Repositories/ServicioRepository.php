<?php

namespace App\Repositories;

use App\Models\Servicio;

class ServicioRepository
{
    public function getActiveLimit(int $limit)
    {
        return Servicio::where('activo', true)
            ->select(['id', 'nombre', 'descripcion', 'precio', 'duracion_minutos', 'categoria', 'imagen_path'])
            ->take($limit)
            ->get();
    }

    public function getFiltered(string $search, ?string $category, bool $paginate = false, int $perPage = 12)
    {
        $query = Servicio::query()
            ->select(['id', 'nombre', 'descripcion', 'precio', 'duracion_minutos', 'categoria', 'imagen_path'])
            ->where('activo', true)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                        ->orWhere('descripcion', 'like', "%{$search}%")
                        ->orWhere('categoria', 'like', "%{$search}%");
                });
            })
            ->when($category && $category !== 'Todas', fn ($query) => $query->where('categoria', $category))
            ->orderBy('nombre');

        return $paginate ? $query->paginate($perPage)->withQueryString() : $query->get();
    }

    public function getCategorias()
    {
        return Servicio::where('activo', true)
            ->distinct()
            ->pluck('categoria')
            ->toArray();
    }

    public function findById(int $id)
    {
        return Servicio::find($id);
    }
}
