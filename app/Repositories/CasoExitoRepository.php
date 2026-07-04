<?php

namespace App\Repositories;

use App\Models\CasoExito;

class CasoExitoRepository
{
    public function getActive()
    {
        return CasoExito::where('activo', true)->get();
    }
}
