<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paciente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pacientes';

    protected $fillable = [
        'codigo_referido',
        'nombre',
        'apellido',
        'dni',
        'telefono',
        'email',
        'fecha_nacimiento',
        'genero',
        'tipo_sangre',
        'direccion',
        'antecedentes_medicos',
        'alergias',
        'medicamentos_habituales',
        'contacto_emergencia_nombre',
        'contacto_emergencia_telefono',
        'contacto_emergencia_parentesco'
    ];

    protected function casts(): array
    {
        return [
            'fecha_nacimiento' => 'date',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($paciente) {
            if (empty($paciente->codigo_referido)) {
                $codigo = null;
                $exists = true;
                while ($exists) {
                    $codigo = strtoupper(\Illuminate\Support\Str::random(16));
                    $exists = static::where('codigo_referido', $codigo)->exists();
                }
                $paciente->codigo_referido = $codigo;
            }
        });
    }

    /**
     * Get all appointments for the patient.
     */
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'paciente_id');
    }

    /**
     * Get all payments made by the patient.
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'paciente_id');
    }
}
