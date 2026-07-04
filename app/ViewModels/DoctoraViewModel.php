<?php

namespace App\ViewModels;

use App\Models\Doctora;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class DoctoraViewModel
{
    public readonly string $name;
    public readonly string $cop;
    public readonly string $avatar;
    public readonly string $avatar_url;
    public readonly HtmlString $horario;
    public readonly array $horario_items;
    public readonly string $specialty;
    public readonly string $bio;
    public readonly string $phone;
    public readonly string $clean_phone;
    public readonly string $phone_url;
    public readonly string $whatsapp_url;
    public readonly string $whatsapp_message;
    public readonly string $consultation_url;
    public readonly string $whatsapp_style;
    public readonly string $profile_style;
    public readonly string $specialty_style;
    public readonly string $name_style;
    public readonly string $bio_style;
    public readonly string $credential_style;
    public readonly string $phone_style;
    public readonly string $horario_style;
    public readonly string $hero_intro;
    public readonly string $trust_text;
    public readonly array $estado_clinica;
    public readonly string $status_label;
    public readonly string $status_text;
    public readonly string $status_color;
    public readonly string $status_dot_class;
    public readonly string $status_style;

    public function __construct(?Doctora $doctora)
    {
        $this->name = $doctora?->user?->name ?? '';
        $this->cop = $doctora?->cop_formatted ?? '';
        $this->avatar = $doctora?->avatar_url ?? '';
        $this->avatar_url = $this->avatar;
        $this->specialty = $doctora?->especialidad ?? '';
        $this->bio = $doctora?->bio ?? '';
        $this->phone = $doctora?->telefono ?? '';
        $this->clean_phone = preg_replace('/[^0-9]/', '', $this->phone);
        $this->phone_url = $this->clean_phone ? 'tel:' . $this->clean_phone : '#';
        $this->whatsapp_message = $this->name
            ? rawurlencode("Hola. {$this->name}, deseo solicitar información para agendar una cita dental.")
            : rawurlencode('Hola. Deseo solicitar información para agendar una cita dental.');
        $this->whatsapp_url = $this->clean_phone ? "https://wa.me/{$this->clean_phone}?text={$this->whatsapp_message}" : '#';
        $this->consultation_url = $this->whatsappUrl('Hola deseo solicitar una cita de evaluacion general');

        $horarioItems = $this->activeHorarioItems($doctora?->horario_decodificado ?? []);
        $status = $this->buildClinicStatus($doctora?->horario_decodificado ?? []);

        $this->horario_items = $horarioItems;
        $this->horario = new HtmlString(collect($horarioItems)->pluck('label')->implode('<br>'));
        $this->estado_clinica = $status;
        $this->status_label = $status['label'];
        $this->status_text = $status['text'];
        $this->status_color = $status['open'] ? '#4ade80' : '#f87171';
        $this->status_dot_class = $status['open'] ? 'open' : 'closed';

        $this->whatsapp_style = $this->clean_phone ? '' : 'display:none;';
        $this->profile_style = $doctora ? '' : 'display:none;';
        $this->specialty_style = $this->specialty ? '' : 'display:none;';
        $this->name_style = $this->name ? '' : 'display:none;';
        $this->bio_style = $this->bio ? '' : 'display:none;';
        $this->credential_style = $this->cop ? '' : 'display:none;';
        $this->phone_style = $this->phone ? '' : 'display:none;';
        $this->horario_style = $horarioItems ? '' : 'display:none;';
        $this->status_style = $status['has_schedule'] ? '' : 'display:none;';

        $this->hero_intro = $this->name ? " La {$this->name} está lista para atenderte." : '';
        $this->trust_text = $this->name
            ? "Programa una evaluación clínica general. {$this->name} te examinará y diseñará el plan de tratamiento adecuado para ti."
            : 'Programa una evaluación clínica general.';
    }

    public static function make(?Doctora $doctora): self
    {
        return new self($doctora);
    }

    public static function collection(iterable $doctoras): Collection
    {
        return collect($doctoras)->map(fn (Doctora $doctora): self => new self($doctora))->values();
    }

    public function whatsappUrl(string $message): string
    {
        return $this->clean_phone ? "https://wa.me/{$this->clean_phone}?text=" . rawurlencode($message) : '#';
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'cop' => $this->cop,
            'avatar' => $this->avatar,
            'horario' => $this->horario_items,
            'estado_clinica' => $this->estado_clinica,
        ];
    }

    private function activeHorarioItems(array $horario): array
    {
        return collect($horario)
            ->filter(fn ($info): bool => is_array($info) && (bool) ($info['activo'] ?? false))
            ->map(function (array $info, string $day): array {
                $hasTurno2 = (bool) ($info['turno2'] ?? false) && !empty($info['inicio2']) && !empty($info['fin2']);
                $label = e($day) . ': ' . e($info['inicio'] ?? '') . ' - ' . e($info['fin'] ?? '');
                if ($hasTurno2) {
                    $label .= ' · ' . e($info['inicio2']) . ' - ' . e($info['fin2']);
                }
                return [
                    'day'       => $day,
                    'start'     => $info['inicio'] ?? '',
                    'end'       => $info['fin'] ?? '',
                    'has_turno2'=> $hasTurno2,
                    'start2'    => $hasTurno2 ? ($info['inicio2'] ?? '') : '',
                    'end2'      => $hasTurno2 ? ($info['fin2'] ?? '')    : '',
                    'label'     => $label,
                ];
            })
            ->values()
            ->all();
    }

    private function buildClinicStatus(array $horario): array
    {
        if (empty($horario)) {
            return ['open' => false, 'abierta' => false, 'label' => '', 'text' => '', 'texto' => '', 'has_schedule' => false];
        }

        $now = Carbon::now();
        $diasMap = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'];
        $diaActual = $diasMap[$now->dayOfWeekIso] ?? null;
        $info = $diaActual && is_array($horario[$diaActual] ?? null) ? $horario[$diaActual] : [];

        if (!($info['activo'] ?? false) || empty($info['inicio']) || empty($info['fin'])) {
            return ['open' => false, 'abierta' => false, 'label' => 'Cerrado', 'text' => 'Cerrado hoy', 'texto' => 'Cerrado hoy', 'has_schedule' => true];
        }

        $inicio1 = Carbon::createFromTimeString($info['inicio']);
        $fin1    = Carbon::createFromTimeString($info['fin']);
        $hasTurno2 = (bool) ($info['turno2'] ?? false) && !empty($info['inicio2']) && !empty($info['fin2']);
        $inicio2 = $hasTurno2 ? Carbon::createFromTimeString($info['inicio2']) : null;
        $fin2    = $hasTurno2 ? Carbon::createFromTimeString($info['fin2'])    : null;

        // Turno mañana abierto
        if ($now->between($inicio1, $fin1)) {
            return ['open' => true, 'abierta' => true, 'label' => 'Abierto ahora', 'text' => 'Hasta las ' . $fin1->format('H:i'), 'texto' => 'Abierto ahora · Hasta las ' . $fin1->format('H:i'), 'has_schedule' => true];
        }

        // Turno tarde abierto
        if ($hasTurno2 && $now->between($inicio2, $fin2)) {
            return ['open' => true, 'abierta' => true, 'label' => 'Abierto ahora', 'text' => 'Hasta las ' . $fin2->format('H:i'), 'texto' => 'Abierto ahora · Hasta las ' . $fin2->format('H:i'), 'has_schedule' => true];
        }

        // Antes del turno mañana
        if ($now->lt($inicio1)) {
            return ['open' => false, 'abierta' => false, 'label' => 'Cerrado', 'text' => 'Abre hoy a las ' . $inicio1->format('H:i'), 'texto' => 'Abre hoy a las ' . $inicio1->format('H:i'), 'has_schedule' => true];
        }

        // Entre turnos (descanso del mediodía)
        if ($hasTurno2 && $now->gt($fin1) && $now->lt($inicio2)) {
            return ['open' => false, 'abierta' => false, 'label' => 'Cerrado', 'text' => 'Reabre a las ' . $inicio2->format('H:i'), 'texto' => 'Cerrado · Reabre a las ' . $inicio2->format('H:i'), 'has_schedule' => true];
        }

        return ['open' => false, 'abierta' => false, 'label' => 'Cerrado', 'text' => 'Reabre mañana', 'texto' => 'Cerrado · Reabre mañana', 'has_schedule' => true];
    }
}
