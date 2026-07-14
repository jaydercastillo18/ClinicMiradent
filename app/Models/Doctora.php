<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ClearsPublicCache;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctora extends Model
{
    use HasFactory, ClearsPublicCache, SoftDeletes;

    protected $table = 'doctoras';

    protected $fillable = [
        'user_id',
        'especialidad',
        'COP',
        'telefono',
        'bio',
        'avatar',
        'horario_atencion'
    ];

    /**
     * Attributes automatically appended to the model's array/JSON form.
     */
    protected $appends = [
        'cop_formatted',
        'avatar_url',
        'horario_decodificado',
    ];

    // ─────────────────────────────────────────────────────────
    // ACCESSORS
    // ─────────────────────────────────────────────────────────

    /**
     * Returns the COP number formatted as "COP XXXXX".
     * This is the single source of truth for displaying the
     * Colegio Odontológico del Perú registration number.
     *
     * Usage in Blade: {{ $doctora->cop_formatted }}
     *
     * @return string
     */
    public function getCopFormattedAttribute(): string
    {
        return $this->COP ? 'COP ' . $this->COP : '';
    }

    public function getAvatarUrlAttribute(): string
    {
        if (!empty($this->avatar)) {
            if (str_starts_with($this->avatar, 'data:') || str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
                return $this->avatar;
            }
            return asset($this->avatar);
        }

        $avatarPath = 'uploads/doctora/avatar.jpg';
        $absolutePath = public_path($avatarPath);

        if (file_exists($absolutePath)) {
            return asset($avatarPath) . '?v=' . filemtime($absolutePath);
        }

        return asset('images/avatar_placeholder.svg');
    }

    public function getHorarioDecodificadoAttribute(): array
    {
        if (!$this->horario_atencion) {
            return [];
        }

        $decoded = json_decode($this->horario_atencion, true);

        return is_array($decoded) ? $decoded : [];
    }

    // ─────────────────────────────────────────────────────────
    // RELATIONSHIPS
    // ─────────────────────────────────────────────────────────

    /**
     * Get the user account for the Doctor.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the appointments for the Doctor.
     */
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'doctora_id');
    }
}
