@extends('layouts.plantilla')

@section('title', 'Dashboard Principal')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-2 border-bottom">
        <div>
            <h1 class="h3 mb-1 text-slate-800" style="font-weight: 700; color: var(--text-main);">Bienvenida de nuevo, {{ Auth::user()->name }}</h1>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">Resumen de la clínica dental Miradent para hoy.</p>
        </div>
        <div>
            <a href="{{ url('/admin/citas') }}" class="btn btn-primary  d-flex align-items-center gap-2" style="background-color: var(--primary); border-color: var(--primary); font-weight: 500; padding: 10px 18px; border-radius: 10px; box-shadow: 0 4px 12px rgba(32,127,84,0.2);">
                <i data-lucide="plus-circle" style="width: 18px; height: 18px;"></i> Nueva Cita
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row g-4 mb-5">
        <!-- Card 1: Pacientes -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; transition: transform 0.2s; background: white; border: 1px solid var(--border-color) !important;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div class="stat-card-text">
                        <span class="text-muted d-block mb-1" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Total Pacientes</span>
                        <h3 class="stat-card-value mb-0" style="color: var(--text-main);">{{ number_format($pacienteCount) }}</h3>
                        <span class="text-primary d-flex align-items-center gap-1 mt-2" style="font-size: 0.85rem; font-weight: 600;">
                            <i data-lucide="trending-up" style="width: 14px; height: 14px;"></i> Base de datos activa
                        </span>
                    </div>
                    <div class="stat-card-icon p-3" style="background-color: var(--primary-light); border-radius: 14px; color: var(--primary);">
                        <i data-lucide="users" style="width: 28px; height: 28px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Citas Hoy -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; transition: transform 0.2s; background: white; border: 1px solid var(--border-color) !important;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div class="stat-card-text">
                        <span class="text-muted d-block mb-1" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Citas de Hoy</span>
                        <h3 class="stat-card-value mb-0" style="color: var(--text-main);">{{ $citasHoyCount }}</h3>
                        <span class="text-muted d-flex align-items-center gap-1 mt-2" style="font-size: 0.85rem;">
                            <i data-lucide="clock" style="width: 14px; height: 14px;"></i> {{ $citasCompletadasHoyCount }} completadas
                        </span>
                    </div>
                    <div class="stat-card-icon p-3" style="background-color: rgba(27, 92, 58, 0.1); border-radius: 14px; color: #1b5c3a;">
                        <i data-lucide="calendar" style="width: 28px; height: 28px;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Ingresos (Solo Doctora) -->
        @if(auth()->user()->role === 'doctora')
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; transition: transform 0.2s; background: white; border: 1px solid var(--border-color) !important;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div class="stat-card-text">
                        <span class="text-muted d-block mb-1" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Ingresos (Mes)</span>
                        <h3 class="stat-card-value stat-card-value-currency mb-0" style="color: var(--text-main);">S/. {{ number_format($ingresosMes, 2) }}</h3>
                        <span class="text-primary d-flex align-items-center flex-wrap gap-1 mt-2" style="font-size: 0.85rem; font-weight: 600;">
                            <i data-lucide="trending-up" style="width: 14px; height: 14px;"></i> Facturación mensual
                        </span>
                    </div>
                    <div class="stat-card-icon p-3" style="background-color: rgba(27, 92, 58, 0.1); border-radius: 14px; color: #1b5c3a;">
                        <i data-lucide="dollar-sign" style="width: 28px; height: 28px;"></i>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Card 4: Servicios Activos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; transition: transform 0.2s; background: white; border: 1px solid var(--border-color) !important;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div class="stat-card-text">
                        <span class="text-muted d-block mb-1" style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Tratamientos</span>
                        <h3 class="stat-card-value mb-0" style="color: var(--text-main);">{{ $serviciosCount }}</h3>
                        <span class="text-muted d-flex align-items-center flex-wrap gap-1 mt-2" style="font-size: 0.85rem;">
                            <i data-lucide="activity" style="width: 14px; height: 14px;"></i> Servicios catalogados
                        </span>
                    </div>
                    <div class="stat-card-icon p-3" style="background-color: rgba(27, 92, 58, 0.1); border-radius: 14px; color: #1b5c3a;">
                        <i data-lucide="shield-plus" style="width: 28px; height: 28px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row g-4">
        <!-- Left: Agenda de Hoy -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h5 class="card-title mb-0" style="font-weight: 600; color: var(--text-main);">Próximas Citas de Hoy</h5>
                    <a href="{{ url('/admin/citas') }}" class="btn btn-link p-0 text-primary text-decoration-none" style="color: var(--primary) !important; font-weight: 600; font-size: 0.9rem;">Ver agenda completa</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle text-nowrap mb-0" style="font-size: 0.925rem;">
                            <thead class="table-light">
                                <tr style="color: var(--text-muted); font-weight: 600; border-top: none;">
                                    <th class="ps-4 py-3">Paciente</th>
                                    <th class="py-3">Tratamiento / Servicio</th>
                                    <th class="py-3">Hora</th>
                                    <th class="py-3">Estado</th>
                                    <th class="pe-4 py-3 text-end">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($citasHoy as $cita)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-placeholder d-flex align-items-center justify-content-center text-white font-weight-bold" style="width: 36px; height: 36px; background-color: var(--primary); border-radius: 50%; font-size: 0.85rem; font-weight: 600;">
                                                {{ substr($cita->paciente?->nombre ?? '?', 0, 1) }}{{ substr($cita->paciente?->apellido ?? '', 0, 1) }}
                                            </div>
                                            <div>
                                                <span class="d-block font-weight-600" style="font-weight: 600; color: var(--text-main);">{{ $cita->paciente?->nombre ?? '(sin paciente)' }} {{ $cita->paciente?->apellido ?? '' }}</span>
                                                <span class="text-muted d-block" style="font-size: 0.775rem;">DNI: {{ $cita->paciente?->dni ?? '—' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $cita->servicio ? $cita->servicio->nombre : 'Consulta General' }}</td>
                                    <td>
                                        <span class="badge text-bg-light px-2.5 py-1.5" style="border: 1px solid var(--border-color); font-weight: 500;">
                                            {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('h:i A') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($cita->estado === 'completada')
                                            <span class="badge" style="background-color: rgba(27, 92, 58, 0.15); color: #1b5c3a; font-weight: 600; padding: 6px 10px; border-radius: 6px;">Completada</span>
                                        @elseif($cita->estado === 'en_espera')
                                            <span class="badge" style="background-color: rgba(27, 92, 58, 0.1); color: #1b5c3a; font-weight: 600; padding: 6px 10px; border-radius: 6px;">En Espera</span>
                                        @elseif($cita->estado === 'pendiente')
                                            <span class="badge bg-secondary-subtle text-secondary px-2.5 py-1.5" style="font-weight: 600;">Pendiente</span>
                                        @elseif($cita->estado === 'cancelada')
                                            <span class="badge" style="background-color: rgba(27, 92, 58, 0.1); color: #1b5c3a; font-weight: 600; padding: 6px 10px; border-radius: 6px;">Cancelada</span>
                                        @else
                                            <span class="badge bg-light text-dark px-2.5 py-1.5" style="font-weight: 600; background-color: #f2faf6 !important; color: #1b5c3a !important;">{{ ucfirst($cita->estado) }}</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ url('/admin/citas') }}" class="btn btn-outline-secondary btn-sm rounded-3" style="font-size: 0.8rem; border-color: var(--border-color);">
                                            Ver Agenda
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-5 text-center text-muted">
                                        <div class="mb-2">
                                            <i data-lucide="calendar-x" class="text-muted" style="width: 48px; height: 48px; stroke-width: 1.5;"></i>
                                        </div>
                                        <span class="d-block font-weight-500">No hay citas registradas para hoy.</span>
                                        <a href="{{ url('/admin/citas') }}" class="btn btn-link text-primary text-decoration-none mt-2" style="color: var(--primary) !important; font-weight: 600; font-size: 0.875rem;">Programar Cita</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Enlaces Rápidos y Tips -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; border: 1px solid var(--border-color) !important;">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="card-title mb-0" style="font-weight: 600; color: var(--text-main);">Acciones Rápidas</h5>
                </div>
                <div class="card-body p-4 d-flex flex-column gap-3">
                    <a href="{{ url('/admin/pacientes') }}" class="d-flex align-items-center justify-content-between p-3 rounded-4 text-decoration-none border hover-action" style="transition: all 0.2s; border-color: var(--border-color) !important; background-color: var(--bg-body);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 bg-white rounded-3 text-primary" style="box-shadow: var(--shadow-sm);">
                                <i data-lucide="user-plus" style="width: 20px; height: 20px; color: var(--primary);"></i>
                            </div>
                            <div>
                                <span class="d-block font-weight-600 text-dark" style="font-weight: 600; font-size: 0.9rem;">Registrar Paciente</span>
                                <span class="text-muted d-block" style="font-size: 0.775rem;">Añadir nueva ficha médica</span>
                            </div>
                        </div>
                        <i data-lucide="chevron-right" class="text-muted" style="width: 18px; height: 18px;"></i>
                    </a>

                    @if(auth()->user()->role === 'doctora')
                    <a href="{{ route('finanzas.index') }}" class="d-flex align-items-center justify-content-between p-3 rounded-4 text-decoration-none border hover-action" style="transition: all 0.2s; border-color: var(--border-color) !important; background-color: var(--bg-body);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 bg-white rounded-3 text-primary" style="box-shadow: var(--shadow-sm);">
                                <i data-lucide="dollar-sign" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div>
                                <span class="d-block font-weight-600 text-dark" style="font-weight: 600; font-size: 0.9rem;">Registrar Pago</span>
                                <span class="text-muted d-block" style="font-size: 0.775rem;">Registrar cobros realizados</span>
                            </div>
                        </div>
                        <i data-lucide="chevron-right" class="text-muted" style="width: 18px; height: 18px;"></i>
                    </a>
                    @endif

                    <a href="{{ route('promociones.index') }}" class="d-flex align-items-center justify-content-between p-3 rounded-4 text-decoration-none border hover-action" style="transition: all 0.2s; border-color: var(--border-color) !important; background-color: var(--bg-body);">
                        <div class="d-flex align-items-center gap-3">
                            <div class="p-2 bg-white rounded-3 text-primary" style="box-shadow: var(--shadow-sm);">
                                <i data-lucide="sparkles" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div>
                                <span class="d-block font-weight-600 text-dark" style="font-weight: 600; font-size: 0.9rem;">Crear Promoción</span>
                                <span class="text-muted d-block" style="font-size: 0.775rem;">Publicar nuevo descuento</span>
                            </div>
                        </div>
                        <i data-lucide="chevron-right" class="text-muted" style="width: 18px; height: 18px;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .hover-action:hover {
        background-color: white !important;
        border-color: var(--primary) !important;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Las tarjetas de estadísticas tienen ancho fijo (4 por fila); un valor
       largo como un monto en soles no debe poder empujarse sobre el ícono. */
    .stat-card-text {
        min-width: 0;
        flex: 1 1 auto;
    }
    .stat-card-icon {
        flex-shrink: 0;
    }
    .stat-card-value {
        font-weight: 700;
        font-size: 1.85rem;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .stat-card-value-currency {
        font-size: 1.55rem;
    }
</style>
@endsection


