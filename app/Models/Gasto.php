<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gasto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gastos';

    protected $fillable = [
        'concepto',
        'descripcion',
        'monto',
        'categoria',
        'metodo_pago',
        'fecha_gasto',
        'comprobante',
    ];

    protected $casts = [
        'fecha_gasto' => 'date',
        'monto'       => 'decimal:2',
    ];
}
