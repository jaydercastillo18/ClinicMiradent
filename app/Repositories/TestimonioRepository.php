<?php

namespace App\Repositories;

use App\Models\Testimonio;

class TestimonioRepository
{
    public function getActive()
    {
        return Testimonio::where('activo', true)->get();
    }
}
