@extends('layouts.plantilla')

@section('title', 'Configuración de la Clínica')

@section('styles')
<style>
    .config-wrapper {
        background-color: #f8fafc;
        border-radius: 24px;
        padding: 2rem;
    }
    
    .striking-card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(226, 232, 240, 0.8);
        overflow: hidden;
    }

    /* Modern Toggle Switch */
    .day-switch {
        position: relative;
        width: 44px;
        height: 24px;
        appearance: none;
        background-color: #cbd5e1;
        border-radius: 30px;
        outline: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .day-switch::after {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        width: 18px;
        height: 18px;
        background-color: white;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: transform 0.3s cubic-bezier(0.4, 0.0, 0.2, 1);
    }
    .day-switch:checked {
        background-color: var(--primary);
    }
    .day-switch:checked::after {
        transform: translateX(20px);
    }

    /* Square Day Cards */
    .day-square-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .day-square-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        transform: translateY(-2px);
    }
    .day-active-modern {
        border-color: var(--primary) !important;
        background: #f0fdf4; /* Light green tint */
        box-shadow: 0 4px 15px rgba(32, 127, 84, 0.08);
    }

    /* Time Inputs */
    .time-input-modern {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 6px;
        font-weight: 600;
        color: #1e293b;
        width: 100%;
        text-align: center;
        transition: all 0.2s;
        font-size: 0.85rem;
    }
    .time-input-modern:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px var(--primary-light);
    }
    .time-input-modern:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: #f1f5f9;
    }

    /* Security Card Special */
    .security-card {
        background: linear-gradient(145deg, #0f172a, #1e293b);
        color: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 15px 35px rgba(15, 23, 42, 0.2);
        position: relative;
        overflow: hidden;
    }
    .security-card::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(32,127,84,0.4) 0%, rgba(0,0,0,0) 70%);
        border-radius: 50%;
    }
    .dark-input {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 12px;
        padding: 10px 14px;
        transition: all 0.3s;
        font-size: 0.9rem;
    }
    .dark-input:focus {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(32, 127, 84, 0.2);
        color: white;
    }
    .dark-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    <div class="config-wrapper">
        <!-- Header -->
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge" style="background-color: var(--primary); color: white; font-weight: 700; font-size: 0.75rem; padding: 6px 12px; border-radius: 8px; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 4px 10px rgba(32,127,84,0.3);">
                        <i data-lucide="settings" style="width: 12px; height: 12px; margin-right: 4px; margin-top: -2px;"></i> Panel de Control
                    </span>
                </div>
                <h1 class="mb-1" style="font-weight: 800; color: #0f172a; font-family: 'Outfit', sans-serif; font-size: 2rem; letter-spacing: -0.5px;">
                    Configuración Avanzada
                </h1>
                <p class="text-muted mb-0" style="font-size: 0.95rem; color: #64748b;">
                    Personaliza los horarios en bloques y protege tu cuenta.
                </p>
            </div>
        </div>

        <!-- Feedback Alerts -->
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-3 mb-4" style="border-radius: 16px; background-color: #ecfdf5; color: #065f46; padding: 14px 20px;">
                <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                    <i data-lucide="check" style="width: 16px; height: 16px;"></i>
                </div>
                <span class="fw-bold" style="font-size: 1rem;">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 16px; background-color: #fef2f2; color: #991b1b; padding: 14px 20px;">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 28px; height: 28px;">
                        <i data-lucide="alert-triangle" style="width: 16px; height: 16px;"></i>
                    </div>
                    <span class="fw-bold" style="font-size: 1rem;">Se encontraron problemas:</span>
                </div>
                <ul class="mb-0 ps-5" style="font-size: 0.9rem; font-weight: 500;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            <!-- Left Column: Working Hours Scheduler (GRID) -->
            <div class="col-12 col-xl-8">
                <div class="striking-card p-4 h-100">
                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between mb-4 gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; background: linear-gradient(135deg, var(--primary-light), #d1fae5); color: var(--primary);">
                                <i data-lucide="calendar-clock" style="width: 22px; height: 22px;"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-slate-800" style="font-family: 'Outfit', sans-serif;">Horarios de Atención</h5>
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">(Formato 24h. Ej: 15:00 = 3 PM)</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('doctora.updateConfig') }}" method="POST" data-axios-submit data-axios-refresh="true">
                        @csrf
                        @method('PUT')

                        <!-- GRID DE CUADRADITOS PARA HORARIOS -->
                        <div class="row g-3">
                            @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $day)
                                @php
                                    $daySchedule = $schedule[$day] ?? ($doctora?->horario_decodificado[$day] ?? []);
                                    $dayActive  = $daySchedule['activo']  ?? false;
                                    $dayStart   = $daySchedule['inicio']  ?? '';
                                    $dayEnd     = $daySchedule['fin']     ?? '';
                                    $dayTurno2  = $daySchedule['turno2']  ?? false;
                                    $dayStart2  = $daySchedule['inicio2'] ?? '';
                                    $dayEnd2    = $daySchedule['fin2']    ?? '';
                                @endphp

                                <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                                    <div class="day-square-card {{ $dayActive ? 'day-active-modern' : '' }}" id="card-{{ $day }}">

                                        <!-- Header -->
                                        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2" style="border-color: rgba(0,0,0,0.05) !important;">
                                            <label class="fw-bold mb-0 {{ $dayActive ? 'text-dark' : 'text-muted' }}" for="switch-{{ $day }}" style="font-size: 1rem; cursor: pointer; transition: color 0.3s;" id="label-{{ $day }}">
                                                {{ $day }}
                                            </label>
                                            <input type="hidden" name="horario[{{ $day }}][activo]" value="0">
                                            <input type="checkbox" name="horario[{{ $day }}][activo]" value="1" class="day-switch" id="switch-{{ $day }}" {{ $dayActive ? 'checked' : '' }} onchange="toggleDaySquare('{{ $day }}')">
                                        </div>

                                        <!-- Cuerpo -->
                                        <div class="mt-auto">
                                            <!-- Cerrado -->
                                            <div id="closed-badge-{{ $day }}" class="text-center py-2 {{ $dayActive ? 'd-none' : 'd-block' }}" style="background: #f8fafc; border-radius: 8px;">
                                                <span class="text-muted" style="font-size: 0.8rem; font-weight: 600;">
                                                    <i data-lucide="moon" style="width: 14px; height: 14px; margin-right: 4px; margin-top:-2px;"></i> Descanso
                                                </span>
                                            </div>

                                            <!-- Abierto -->
                                            @if($dayActive)
                                                <div id="time-group-{{ $day }}" class="d-block" style="transition: opacity 0.3s; opacity: 1;">
                                            @else
                                                <div id="time-group-{{ $day }}" class="d-none" style="transition: opacity 0.3s; opacity: 0;">
                                            @endif

                                                <!-- Turno mañana -->
                                                <div style="font-size: 0.68rem; color: var(--primary); font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px;">Turno mañana</div>
                                                <div class="d-flex justify-content-between gap-2 mb-1">
                                                    <span style="font-size: 0.7rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Apertura</span>
                                                    <span style="font-size: 0.7rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Cierre</span>
                                                </div>
                                                <div class="d-flex justify-content-between gap-2 align-items-center mb-3">
                                                    <input type="time" name="horario[{{ $day }}][inicio]" value="{{ $dayStart }}" class="time-input-modern" {{ !$dayActive ? 'disabled' : '' }}>
                                                    <span style="color: #94a3b8; font-size: 0.8rem;">a</span>
                                                    <input type="time" name="horario[{{ $day }}][fin]" value="{{ $dayEnd }}" class="time-input-modern" {{ !$dayActive ? 'disabled' : '' }}>
                                                </div>

                                                <!-- Toggle turno tarde -->
                                                <div class="d-flex justify-content-between align-items-center mb-2" style="border-top: 1px dashed #e2e8f0; padding-top: 10px;">
                                                    <span style="font-size: 0.68rem; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;">Turno tarde</span>
                                                    <input type="hidden" name="horario[{{ $day }}][turno2]" value="0">
                                                    <input type="checkbox" name="horario[{{ $day }}][turno2]" value="1" class="day-switch" id="switch2-{{ $day }}" {{ ($dayActive && $dayTurno2) ? 'checked' : '' }} {{ !$dayActive ? 'disabled' : '' }} onchange="toggleTurno2('{{ $day }}')" style="width: 36px; height: 20px;">
                                                </div>

                                                <!-- Inputs turno tarde -->
                                                <div id="turno2-group-{{ $day }}" class="{{ ($dayActive && $dayTurno2) ? 'd-block' : 'd-none' }}">
                                                    <div class="d-flex justify-content-between gap-2 mb-1">
                                                        <span style="font-size: 0.7rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Apertura</span>
                                                        <span style="font-size: 0.7rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Cierre</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between gap-2 align-items-center">
                                                        <input type="time" name="horario[{{ $day }}][inicio2]" value="{{ $dayStart2 }}" class="time-input-modern" {{ (!$dayActive || !$dayTurno2) ? 'disabled' : '' }} id="input-inicio2-{{ $day }}">
                                                        <span style="color: #94a3b8; font-size: 0.8rem;">a</span>
                                                        <input type="time" name="horario[{{ $day }}][fin2]" value="{{ $dayEnd2 }}" class="time-input-modern" {{ (!$dayActive || !$dayTurno2) ? 'disabled' : '' }} id="input-fin2-{{ $day }}">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 pt-4 border-top d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-4 py-2 d-flex align-items-center gap-2" style="background: linear-gradient(135deg, var(--primary), #0f5132); border: none; border-radius: 12px; font-weight: 700; font-size: 0.95rem; box-shadow: 0 6px 15px rgba(32, 127, 84, 0.3); transition: transform 0.2s;">
                                <i data-lucide="save" style="width: 18px; height: 18px;"></i>
                                Guardar Calendario
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Change Password Card -->
            <div class="col-12 col-xl-4">
                <div class="security-card h-100 d-flex flex-column p-4">
                    <div class="d-flex align-items-center gap-3 mb-4 position-relative z-index-1">
                        <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 44px; height: 44px; background: rgba(255,255,255,0.1); color: #34d399;">
                            <i data-lucide="shield-alert" style="width: 22px; height: 22px;"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-white" style="font-family: 'Outfit', sans-serif;">Seguridad</h5>
                            <p class="mb-0" style="font-size: 0.8rem; color: #94a3b8;">Renovación de credenciales.</p>
                        </div>
                    </div>

                    <form action="{{ route('doctora.updateConfig') }}" method="POST" class="mt-2 flex-grow-1 d-flex flex-column position-relative z-index-1" data-axios-submit data-axios-refresh="true">
                        @csrf
                        @method('PUT')

                        <!-- Hidden scheduler values -->
                        @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $day)
                            @php($daySchedule = $schedule[$day] ?? ($doctora?->horario_decodificado[$day] ?? []))
                            <input type="hidden" name="horario[{{ $day }}][activo]"  value="{{ ($daySchedule['activo']  ?? false) ? '1' : '0' }}">
                            <input type="hidden" name="horario[{{ $day }}][inicio]"  value="{{ $daySchedule['inicio']  ?? '' }}">
                            <input type="hidden" name="horario[{{ $day }}][fin]"     value="{{ $daySchedule['fin']     ?? '' }}">
                            <input type="hidden" name="horario[{{ $day }}][turno2]"  value="{{ ($daySchedule['turno2'] ?? false) ? '1' : '0' }}">
                            <input type="hidden" name="horario[{{ $day }}][inicio2]" value="{{ $daySchedule['inicio2'] ?? '' }}">
                            <input type="hidden" name="horario[{{ $day }}][fin2]"    value="{{ $daySchedule['fin2']    ?? '' }}">
                        @endforeach

                        <div class="d-flex flex-column gap-3 mb-4">
                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="form-label fw-semibold mb-1" style="font-size: 0.85rem; color: #cbd5e1;">Contraseña Actual</label>
                                <div class="position-relative">
                                    <i data-lucide="lock" class="position-absolute" style="top: 12px; left: 14px; width: 16px; height: 16px; color: #64748b;"></i>
                                    <input type="password" name="current_password" id="current_password" class="form-control dark-input w-100" style="padding-left: 38px;" placeholder="Tu clave actual">
                                </div>
                            </div>

                            <hr style="border-color: rgba(255,255,255,0.1); margin: 4px 0;">

                            <!-- New Password -->
                            <div>
                                <label for="new_password" class="form-label fw-semibold mb-1" style="font-size: 0.85rem; color: #cbd5e1;">Nueva Contraseña</label>
                                <div class="position-relative">
                                    <i data-lucide="key" class="position-absolute" style="top: 12px; left: 14px; width: 16px; height: 16px; color: #64748b;"></i>
                                    <input type="password" name="new_password" id="new_password" class="form-control dark-input w-100" style="padding-left: 38px;" placeholder="Mínimo 8 caracteres" minlength="8">
                                </div>
                            </div>

                            <!-- Confirm New Password -->
                            <div>
                                <label for="new_password_confirmation" class="form-label fw-semibold mb-1" style="font-size: 0.85rem; color: #cbd5e1;">Confirmar Contraseña</label>
                                <div class="position-relative">
                                    <i data-lucide="key-round" class="position-absolute" style="top: 12px; left: 14px; width: 16px; height: 16px; color: #64748b;"></i>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control dark-input w-100" style="padding-left: 38px;" placeholder="Repite la contraseña">
                                </div>
                            </div>
                        </div>

                        <div class="mt-auto">
                            <button type="submit" class="btn w-100 py-2 d-flex align-items-center justify-content-center gap-2" style="background-color: #10b981; color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 0.95rem; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); transition: transform 0.2s;">
                                <i data-lucide="shield" style="width: 18px; height: 18px;"></i>
                                Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleDaySquare(day) {
        const checkbox   = document.getElementById('switch-' + day);
        const card       = document.getElementById('card-' + day);
        const label      = document.getElementById('label-' + day);
        const closedBadge = document.getElementById('closed-badge-' + day);
        const timeGroup  = document.getElementById('time-group-' + day);
        const switch2    = document.getElementById('switch2-' + day);

        if (checkbox.checked) {
            card.classList.add('day-active-modern');
            label.classList.replace('text-muted', 'text-dark');
            closedBadge.classList.replace('d-block', 'd-none');
            timeGroup.classList.replace('d-none', 'd-block');
            setTimeout(() => { timeGroup.style.opacity = '1'; }, 10);
            timeGroup.querySelectorAll('input[type="time"]').forEach(i => i.removeAttribute('disabled'));
            if (switch2) switch2.removeAttribute('disabled');
        } else {
            card.classList.remove('day-active-modern');
            label.classList.replace('text-dark', 'text-muted');
            timeGroup.style.opacity = '0';
            setTimeout(() => {
                timeGroup.classList.replace('d-block', 'd-none');
                closedBadge.classList.replace('d-none', 'd-block');
            }, 300);
            timeGroup.querySelectorAll('input[type="time"]').forEach(i => i.setAttribute('disabled', 'true'));
            if (switch2) switch2.setAttribute('disabled', 'true');
            // Ocultar turno2 también
            const turno2Group = document.getElementById('turno2-group-' + day);
            if (turno2Group) {
                turno2Group.classList.replace('d-block', 'd-none');
                if (switch2) switch2.checked = false;
            }
        }
    }

    function toggleTurno2(day) {
        const switch2    = document.getElementById('switch2-' + day);
        const turno2Group = document.getElementById('turno2-group-' + day);
        const inicio2    = document.getElementById('input-inicio2-' + day);
        const fin2       = document.getElementById('input-fin2-' + day);

        if (switch2.checked) {
            turno2Group.classList.replace('d-none', 'd-block');
            if (inicio2) inicio2.removeAttribute('disabled');
            if (fin2)    fin2.removeAttribute('disabled');
        } else {
            turno2Group.classList.replace('d-block', 'd-none');
            if (inicio2) inicio2.setAttribute('disabled', 'true');
            if (fin2)    fin2.setAttribute('disabled', 'true');
        }
    }
</script>
@endsection
