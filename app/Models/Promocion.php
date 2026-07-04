<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ClearsPublicCache;

class Promocion extends Model
{
    use HasFactory, SoftDeletes, ClearsPublicCache;

    protected $table = 'promociones';

    protected $fillable = [
        'titulo',
        'descripcion',
        'descuento_porcentaje',
        'fecha_inicio',
        'fecha_fin',
        'imagen_path',
        'activo'
    ];

    protected function casts(): array
    {
        return [
            'descuento_porcentaje' => 'integer',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'activo' => 'boolean',
        ];
    }
}
