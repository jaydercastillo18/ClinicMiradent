<?php

namespace App\ViewModels;

use App\Models\Promocion;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class PromocionViewModel
{
    public readonly int $id;
    public readonly string $image;
    public readonly string $image_style;
    public readonly string $card_class;
    public readonly string $content_style;
    public readonly string $title;
    public readonly string $description;
    public readonly string $description_short;
    public readonly string $discount_label;
    public readonly string $discount_style;
    public readonly string $status_label;
    public readonly string $status_class;
    public readonly string $ends_at;
    public readonly string $ends_at_iso;
    public readonly string $starts_at;
    public readonly string $whatsapp_url;
    public readonly string $whatsapp_style;
    public readonly ?int $discount_percentage;
    public readonly ?int $descuento_porcentaje;

    public function __construct(Promocion $promocion, ?DoctoraViewModel $doctora = null)
    {
        $status = $this->status($promocion);

        $this->id = (int) $promocion->id;
        $this->image = $promocion->imagen_path ? asset($promocion->imagen_path) : '';
        $this->image_style = $this->image ? '' : 'display:none;';
        $this->card_class = $this->image ? 'has-img' : 'no-img';
        $this->content_style = $this->image ? 'padding: 1.5rem;' : '';
        $this->title = $promocion->titulo ?? '';
        $this->description = $promocion->descripcion ?? '';
        $this->description_short = Str::limit($this->description, 80);
        $this->discount_percentage = $promocion->descuento_porcentaje;
        $this->descuento_porcentaje = $this->discount_percentage;
        $this->discount_label = $this->discount_percentage ? '-' . $this->discount_percentage . '%' : '';
        $this->discount_style = $this->discount_label ? '' : 'display:none;';
        $this->status_label = $status['label'];
        $this->status_class = $status['class'];
        $this->starts_at = $promocion->fecha_inicio?->format('Y-m-d') ?? '';
        $this->ends_at = $promocion->fecha_fin?->format('d/m/Y') ?? '';
        $this->ends_at_iso = $promocion->fecha_fin?->format('Y-m-d') ?? '';
        $this->whatsapp_url = $doctora?->whatsappUrl("Hola. " . ($doctora->name ? $doctora->name . ", " : "") . "deseo reservar una cita aplicando la promoción: {$this->title}") ?? '#';
        $this->whatsapp_style = $doctora?->whatsapp_style ?? 'display:none;';
    }

    public static function collection(iterable $promociones, ?DoctoraViewModel $doctora = null): Collection
    {
        return collect($promociones)->map(fn (Promocion $promocion): self => new self($promocion, $doctora))->values();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'titulo' => $this->title,
            'descripcion' => $this->description,
            'descuento_porcentaje' => $this->discount_percentage,
            'fecha_inicio' => $this->starts_at,
            'fecha_fin' => $this->ends_at_iso,
            'imagen_url' => $this->image ?: null,
        ];
    }

    private function status(Promocion $promocion): array
    {
        $start = $promocion->fecha_inicio ? Carbon::parse($promocion->fecha_inicio) : null;
        $end = $promocion->fecha_fin ? Carbon::parse($promocion->fecha_fin) : null;
        $now = Carbon::now();

        if ($start && $end && $now->between($start, $end)) {
            return ['label' => 'Vigente', 'class' => 'status-vigente'];
        }

        if ($start && $now->lt($start)) {
            return ['label' => 'Por Iniciar', 'class' => 'status-iniciar'];
        }

        return ['label' => 'Expirada', 'class' => 'status-expirada'];
    }
}
