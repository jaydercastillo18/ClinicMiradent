<?php

namespace App\ViewModels;

use App\Models\CasoExito;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class CasoExitoViewModel
{
    public readonly int $id;
    public readonly string $before_image;
    public readonly string $after_image;
    public readonly string $title;
    public readonly string $description;
    public readonly string $description_short;
    public readonly bool $has_images;

    public function __construct(CasoExito $caso)
    {
        $this->id = (int) $caso->id;
        $this->before_image = image_url($caso->antes_img, '');
        $this->after_image = image_url($caso->despues_img, '');
        $this->title = $caso->titulo_tratamiento ?? '';
        $this->description = $caso->descripcion_resultado ?? '';
        $this->description_short = Str::limit($this->description, 70);
        $this->has_images = (bool) ($this->before_image && $this->after_image);
    }

    public static function collection(iterable $casos, bool $withImagesOnly = false): Collection
    {
        $items = collect($casos)->map(fn (CasoExito $caso): self => new self($caso));

        return ($withImagesOnly ? $items->filter->has_images : $items)->values();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'before_image' => $this->before_image,
            'after_image' => $this->after_image,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
