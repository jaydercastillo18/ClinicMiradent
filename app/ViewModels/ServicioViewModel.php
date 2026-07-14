<?php

namespace App\ViewModels;

use App\Models\Servicio;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ServicioViewModel
{
    public readonly int $id;
    public readonly string $image;
    public readonly string $image_style;
    public readonly string $home_image_style;
    public readonly string $name;
    public readonly string $description;
    public readonly string $description_short;
    public readonly string $description_home;
    public readonly string $category;
    public readonly string $category_badge_class;
    public readonly string $category_icon;
    public readonly string $price;
    public readonly float $price_value;
    public readonly string $price_display;
    public readonly string $duration;
    public readonly string $detail_url;
    public readonly string $whatsapp_url;
    public readonly string $whatsapp_style;

    public function __construct(Servicio $servicio, ?DoctoraViewModel $doctora = null)
    {
        $category = $servicio->categoria ?? '';
        $categoryMeta = $this->categoryMeta($category);

        $this->id = (int) $servicio->id;
        $this->image = image_url($servicio->imagen_path, '', 'servicio', $servicio->id);
        $this->image_style = $this->image ? 'height: 200px; width: 100%; overflow: hidden; position: relative; border-bottom: 1px solid var(--border-color);' : 'display:none;';
        $this->home_image_style = $this->image ? 'height: 160px; overflow: hidden; border-radius: 12px; margin-bottom: 1rem;' : 'display:none;';
        $this->name = $servicio->nombre ?? '';
        $this->description = $servicio->descripcion ?? '';
        $this->description_short = Str::limit($this->description, 160);
        $this->description_home = Str::limit($this->description, 90);
        $this->category = $category;
        $this->category_badge_class = $categoryMeta['class'];
        $this->category_icon = $categoryMeta['icon'];
        $this->price_value = (float) $servicio->precio;
        $this->price = number_format((float) $servicio->precio, 2);
        $this->price_display = 'S/. ' . $this->price;
        $this->duration = (string) $servicio->duracion_minutos;
        $this->detail_url = route('public.servicios.detalle', $servicio->id);
        $this->whatsapp_url = $doctora?->whatsappUrl("Hola. " . ($doctora->name ? $doctora->name . ", " : "") . "deseo solicitar información para agendar una cita sobre el tratamiento: {$this->name}") ?? '#';
        $this->whatsapp_style = $doctora?->whatsapp_style ?? 'display:none;';
    }

    public static function collection(iterable $servicios, ?DoctoraViewModel $doctora = null): Collection
    {
        return collect($servicios)->map(fn (Servicio $servicio): self => new self($servicio, $doctora))->values();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->name,
            'descripcion' => $this->description,
            'precio' => $this->price_value,
            'precio_display' => $this->price_display,
            'duracion_minutos' => $this->duration,
            'categoria' => $this->category,
            'imagen_url' => $this->image ?: null,
            'detalle_url' => $this->detail_url,
        ];
    }

    private function categoryMeta(string $category): array
    {
        $normalized = Str::of($category)->lower()->ascii()->toString();

        return match (true) {
            str_contains($normalized, 'prevenc') => ['class' => 'cat-prevencion', 'icon' => 'shield-check'],
            str_contains($normalized, 'ortodonc') => ['class' => 'cat-ortodoncia', 'icon' => 'smile'],
            str_contains($normalized, 'endodonc') => ['class' => 'cat-endodoncia', 'icon' => 'activity'],
            str_contains($normalized, 'estetic') => ['class' => 'cat-estetica', 'icon' => 'sparkles'],
            str_contains($normalized, 'protes') => ['class' => 'cat-protesis', 'icon' => 'layers'],
            str_contains($normalized, 'implant') => ['class' => 'cat-implantes', 'icon' => 'anchor'],
            str_contains($normalized, 'cirug') => ['class' => 'cat-cirugia', 'icon' => 'scissors'],
            str_contains($normalized, 'integral') => ['class' => 'cat-integrales', 'icon' => 'heart-pulse'],
            default => ['class' => 'cat-default', 'icon' => 'sparkles'],
        };
    }
}
