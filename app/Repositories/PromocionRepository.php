<?php

namespace App\Repositories;

use App\Models\Promocion;

class PromocionRepository
{
    public function getActive(bool $paginate = false, int $perPage = 12)
    {
        $query = Promocion::query()
            ->select(['id', 'titulo', 'descripcion', 'descuento_porcentaje', 'fecha_inicio', 'fecha_fin', 'imagen_path'])
            ->where('activo', true)
            ->orderBy('fecha_fin', 'asc');

        return $paginate ? $query->paginate($perPage)->withQueryString() : $query->get();
    }
}
