<?php

namespace App\Repositories;

use App\Models\Doctora;

class DoctoraRepository
{
    public function getFirstWithUser()
    {
        return Doctora::with('user')->first();
    }
}
