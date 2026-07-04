<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ClearsPublicCache;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonio extends Model
{
    use HasFactory, ClearsPublicCache, SoftDeletes;

    protected $table = 'testimonios';

    protected $fillable = [
        'nombre_paciente',
        'testimonio',
        'fecha',
        'estrellas',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'estrellas' => 'integer',
            'activo' => 'boolean',
        ];
    }
}
