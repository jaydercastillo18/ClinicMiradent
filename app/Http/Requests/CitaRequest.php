<?php

namespace App\Http\Requests;

use App\Models\Cita;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CitaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'paciente_id' => [
                'required',
                'integer',
                Rule::exists('pacientes', 'id')->whereNull('deleted_at'),
            ],
            'servicio_id' => [
                'required',
                'integer',
                Rule::exists('servicios', 'id')->whereNull('deleted_at'),
            ],
            'doctora_id' => [
                'required',
                'integer',
                Rule::exists('doctoras', 'id')->whereNull('deleted_at'),
            ],
            'fecha_hora' => ['required', 'date'],
            'motivo' => ['nullable', 'string', 'max:500'],
            'estado' => ['required', Rule::in(['pendiente', 'confirmada', 'completada', 'cancelada', 'en_espera', 'atendida', 'reprogramada'])],
        ];

        if ($this->route('id')) {
            $rules['diagnostico'] = ['nullable', 'string', 'max:1000'];
            $rules['notas_tratamiento'] = ['nullable', 'string', 'max:1000'];
        }

        return $rules;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $fechaHora = $this->input('fecha_hora');
            $servicioId = $this->input('servicio_id');
            $doctoraId = $this->input('doctora_id');

            if ($fechaHora && $servicioId && $doctoraId) {
                $start = Carbon::parse($fechaHora);
                $servicio = Servicio::find($servicioId);

                if (!$servicio) return;

                $duracionNueva = $servicio->duracion_minutos;
                $end = $start->copy()->addMinutes($duracionNueva);

                // Buscar citas del mismo día para la doctora
                $citasDelDia = Cita::with('servicio')
                    ->where('doctora_id', $doctoraId)
                    ->whereDate('fecha_hora', $start->toDateString())
                    ->where('id', '!=', $this->route('id'))
                    ->whereNotIn('estado', ['cancelada'])
                    ->get();

                foreach ($citasDelDia as $cita) {
                    $existStart = Carbon::parse($cita->fecha_hora);
                    $duracionExistente = $cita->servicio ? $cita->servicio->duracion_minutos : 30; // fallback a 30 mins
                    $existEnd = $existStart->copy()->addMinutes($duracionExistente);

                    // Si hay cruce de horarios
                    if ($start < $existEnd && $end > $existStart) {
                        $validator->errors()->add(
                            'fecha_hora',
                            "Ya existe una cita en este horario. La consulta agendada es a las {$existStart->format('H:i')} y dura {$duracionExistente} minutos (termina a las {$existEnd->format('H:i')})."
                        );
                        break;
                    }
                }
            }
        });
    }

    public function messages(): array
    {
        return [];
    }
}
