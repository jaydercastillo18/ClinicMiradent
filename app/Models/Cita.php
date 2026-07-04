<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cita extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'citas';

    protected $fillable = [
        'paciente_id',
        'doctora_id',
        'servicio_id',
        'fecha_hora',
        'motivo',
        'diagnostico',
        'notas_tratamiento',
        'estado'
    ];

    protected function casts(): array
    {
        return [
            'fecha_hora' => 'datetime',
        ];
    }

    /**
     * Get the patient associated with the appointment.
     */
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    /**
     * Get the doctor associated with the appointment.
     */
    public function doctora(): BelongsTo
    {
        return $this->belongsTo(Doctora::class, 'doctora_id');
    }

    /**
     * Get the service associated with the appointment.
     */
    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    /**
     * Get the payments linked to this appointment.
     */
    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'cita_id');
    }
}
