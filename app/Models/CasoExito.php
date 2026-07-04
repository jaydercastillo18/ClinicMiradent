<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ClearsPublicCache;
use Illuminate\Database\Eloquent\SoftDeletes;

class CasoExito extends Model
{
    use HasFactory, ClearsPublicCache, SoftDeletes;

    protected $table = 'casos_exito';

    protected $fillable = [
        'titulo_tratamiento',
        'descripcion_resultado',
        'categoria',
        'antes_img',
        'despues_img',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }
}
