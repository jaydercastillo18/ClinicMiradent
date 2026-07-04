@extends('layouts.plantilla')

@section('title', 'Reportes y Estadísticas')

@section('styles')
<style>
    /* Premium Color Palette & Typography details */
    .metric-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none !important;
        border-radius: 20px;
        position: relative;
    }
    .metric-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.08) !important;
    }
    .custom-shadow {
        box-shadow: 0 4px 20px rgba(0,0,0,0.04) !important;
    }
    .metric-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg) !important;
    }
    .metric-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    .quick-filter-btn {
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: 20px;
        padding: 6px 16px;
        transition: all 0.2s ease;
        border: 1px solid var(--border-color);
        background-color: #fff;
        color: var(--text-muted);
    }
    .quick-filter-btn:hover, .quick-filter-btn.active {
        background-color: var(--primary-light);
        border-color: var(--primary);
        color: var(--primary);
    }
    .chart-container {
        position: relative;
        min-height: 320px;
    }
    .payment-badge {
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    /* Print Header Styles (Only visible in Print) */
    .print-only-header {
        display: none;
    }

    @media print {
        body {
            background-color: #ffffff !important;
            color: #000000 !important;
        }
        /* Hide UI components */
        .sidebar, .topbar, .filter-card, .btn-print, .no-print, .breadcrumb, #toggle-sidebar {
            display: none !important;
        }
        .main-wrapper {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .content-main {
            padding: 0 !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
            margin-bottom: 20px !important;
        }
        .print-only-header {
            display: block !important;
            border-bottom: 2px solid #207f54;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .metric-card {
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
            transform: none !important;
        }
        .chart-container {
            min-height: 250px !important;
            page-break-inside: avoid;
        }
        table {
            page-break-inside: avoid;
        }
        /* Force color adjust */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0">
    
    <!-- Printable Header (Hidden in Screen) -->
    <div class="print-only-header">
        <div class="row align-items-center">
            <div class="col-6">
                <h2 style="color: var(--primary); font-weight: 700; margin: 0;">Clínica Dental Miradent</h2>
                <p class="text-muted mb-0" style="font-size: 0.85rem;">Cuidado profesional para tu sonrisa</p>
            </div>
            <div class="col-6 text-end">
                <h5 class="mb-1" style="font-weight: 600;">Reporte Estadístico de Gestión</h5>
                <p class="text-muted mb-0" style="font-size: 0.85rem;">Periodo: {{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}</p>
                <p class="text-muted mb-0" style="font-size: 0.75rem;">Generado el: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Page Header (Screen only) -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-3 border-bottom no-print">
        <div>
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="badge" style="background-color: var(--primary-light); color: var(--primary); font-weight: 700; font-size: 0.75rem; padding: 6px 12px; border-radius: 8px; text-transform: uppercase; letter-spacing: 0.5px;">
                    Módulo de Analítica
                </span>
            </div>
            <h1 class="h3 mb-2 text-slate-800" style="font-weight: 800; color: #0f172a; font-family: 'Outfit', sans-serif;">
                Reportes y Estadísticas
            </h1>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">
                Visualiza el rendimiento de la clínica, la facturación y el flujo de pacientes.
            </p>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary d-flex align-items-center gap-2" style="background-color: var(--primary); border-color: var(--primary); font-weight: 600; padding: 12px 24px; border-radius: 12px; transition: all 0.2s; box-shadow: 0 4px 10px rgba(32, 127, 84, 0.2);">
                <i data-lucide="printer" style="width: 18px; height: 18px;"></i>
                Imprimir Reporte
            </button>
        </div>
    </div>

    <!-- Date Range Filter Selector (Screen only) -->
    <div class="card border-0 p-4 mb-4 filter-card no-print custom-shadow" style="border-radius: 20px;">
        <h6 class="fw-bold mb-3 text-slate-800" style="font-family: 'Outfit', sans-serif;">
            <i data-lucide="filter" class="text-primary me-2" style="width: 18px; height: 18px; vertical-align: text-bottom;"></i>
            Filtrar Periodo del Reporte
        </h6>
        <form action="{{ route('reportes.index') }}" method="GET" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-4">
                    <label for="fecha_inicio" class="form-label fw-semibold text-slate-600 mb-1" style="font-size: 0.85rem;">Fecha Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ $fecha_inicio }}" style="border-radius: 8px; border-color: var(--border-color); height: 42px;">
                </div>
                <div class="col-12 col-md-4">
                    <label for="fecha_fin" class="form-label fw-semibold text-slate-600 mb-1" style="font-size: 0.85rem;">Fecha Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ $fecha_fin }}" style="border-radius: 8px; border-color: var(--border-color); height: 42px;">
                </div>
                <div class="col-12 col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1" style="background-color: var(--primary); border-color: var(--primary); border-radius: 8px; height: 42px; font-weight: 600;">
                        Aplicar Filtro
                    </button>
                    <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" style="border-radius: 8px; width: 42px; height: 42px;" title="Limpiar Filtros">
                        <i data-lucide="rotate-ccw" style="width: 18px; height: 18px;"></i>
                    </a>
                </div>
            </div>
        </form>

        <div class="d-flex flex-wrap gap-2 mt-3 pt-3 border-top">
            <span class="text-muted align-self-center me-2" style="font-size: 0.85rem; font-weight: 500;">Filtros rápidos:</span>
            <button type="button" class="quick-filter-btn" onclick="applyQuickFilter('month')">Este Mes</button>
            <button type="button" class="quick-filter-btn" onclick="applyQuickFilter('quarter')">Últimos 3 Meses</button>
            <button type="button" class="quick-filter-btn" onclick="applyQuickFilter('year')">Este Año</button>
            <button type="button" class="quick-filter-btn" onclick="applyQuickFilter('all')">Todo el Historial</button>
        </div>
    </div>

    <!-- KPIs Metric Cards Row -->
    <div class="row g-4 mb-4">
        <!-- Total Patients -->
        <div class="col-12 col-md-4">
            <div class="card metric-card custom-shadow p-4 bg-white border-0">
                <div class="d-flex align-items-center gap-4 mb-3">
                    <div class="metric-icon flex-shrink-0" style="background-color: #ecfdf5; color: #10b981; width: 60px; height: 60px; border-radius: 16px;">
                        <i data-lucide="users" style="width: 30px; height: 30px;"></i>
                    </div>
                    <div>
                        <span class="text-muted d-block mb-1" style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Nuevos Pacientes</span>
                        <h3 class="mb-0" style="font-weight: 800; color: #0f172a; font-size: 1.8rem; font-family: 'Outfit', sans-serif;">{{ $totalPacientes }}</h3>
                    </div>
                </div>
                <div class="text-muted border-top pt-3" style="font-size: 0.8rem; font-weight: 500;">
                    <i data-lucide="calendar" style="width: 14px; height: 14px; margin-top: -2px; margin-right: 4px;"></i>
                    Registrados en el periodo.
                </div>
            </div>
        </div>

        <!-- Total Appointments -->
        <div class="col-12 col-md-4">
            <div class="card metric-card custom-shadow p-4 bg-white border-0">
                <div class="d-flex align-items-center gap-4 mb-3">
                    <div class="metric-icon flex-shrink-0" style="background-color: #e0f2fe; color: #0284c7; width: 60px; height: 60px; border-radius: 16px;">
                        <i data-lucide="calendar-days" style="width: 30px; height: 30px;"></i>
                    </div>
                    <div>
                        <span class="text-muted d-block mb-1" style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Citas Agendadas</span>
                        <h3 class="mb-0" style="font-weight: 800; color: #0f172a; font-size: 1.8rem; font-family: 'Outfit', sans-serif;">{{ $totalCitas }}</h3>
                    </div>
                </div>
                <div class="text-muted border-top pt-3" style="font-size: 0.8rem; font-weight: 500;">
                    <i data-lucide="info" style="width: 14px; height: 14px; margin-top: -2px; margin-right: 4px;"></i>
                    Incluye todos los estados.
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-12 col-md-4">
            <div class="card metric-card custom-shadow p-4 bg-white border-0">
                <div class="d-flex align-items-center gap-4 mb-3">
                    <div class="metric-icon flex-shrink-0" style="background-color: #fef3c7; color: #d97706; width: 60px; height: 60px; border-radius: 16px;">
                        <i data-lucide="trending-up" style="width: 30px; height: 30px;"></i>
                    </div>
                    <div>
                        <span class="text-muted d-block mb-1" style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Ingresos Brutos</span>
                        <h3 class="mb-0" style="font-weight: 800; color: #0f172a; font-size: 1.8rem; font-family: 'Outfit', sans-serif;">S/. {{ number_format($totalIngresos, 2) }}</h3>
                    </div>
                </div>
                <div class="text-muted border-top pt-3" style="font-size: 0.8rem; font-weight: 500;">
                    <i data-lucide="check-circle-2" style="width: 14px; height: 14px; margin-top: -2px; margin-right: 4px; color: #10b981;"></i>
                    Montos pagados y parciales.
                </div>
            </div>
        </div>
    </div>

    <!-- Row of Charts (Income + Status) -->
    <div class="row g-4 mb-4">
        <!-- Monthly Income Trend Chart -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 custom-shadow p-4 h-100" style="border-radius: 20px;">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h5 class="fw-bold mb-1 text-slate-800" style="font-family: 'Outfit', sans-serif;">Tendencia de Ingresos Mensuales</h5>
                        <p class="text-muted mb-0" style="font-size: 0.825rem;">Flujo de caja neto generado en el periodo.</p>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="incomeTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Appointment Status Distribution Chart -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 custom-shadow p-4 h-100" style="border-radius: 20px;">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h5 class="fw-bold mb-1 text-slate-800" style="font-family: 'Outfit', sans-serif;">Estado de Citas</h5>
                        <p class="text-muted mb-0" style="font-size: 0.825rem;">Distribución porcentual por estado.</p>
                    </div>
                </div>
                <div class="chart-container d-flex align-items-center justify-content-center">
                    @if($totalCitas > 0)
                        <canvas id="appointmentStatusChart" style="max-height: 280px; max-width: 280px;"></canvas>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i data-lucide="pie-chart" class="mb-2" style="width: 48px; height: 48px; opacity: 0.4;"></i>
                            <p class="mb-0">Sin datos de citas para este periodo.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Row of lists (Top Treatments + Payment Methods) -->
    <div class="row g-4">
        <!-- Top 5 treatments -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 custom-shadow p-4 h-100" style="border-radius: 20px;">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h5 class="fw-bold mb-1 text-slate-800" style="font-family: 'Outfit', sans-serif;">Top 5 Tratamientos más Solicitados</h5>
                        <p class="text-muted mb-0" style="font-size: 0.825rem;">Tratamientos dentales con mayor afluencia de pacientes.</p>
                    </div>
                </div>
                <div class="chart-container">
                    @if(count($topTratamientos) > 0)
                        <canvas id="treatmentsChart"></canvas>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i data-lucide="bar-chart-2" class="mb-2" style="width: 48px; height: 48px; opacity: 0.4;"></i>
                            <p class="mb-0">Sin tratamientos registrados en este periodo.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payment methods breakdown table -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 custom-shadow p-4 h-100" style="border-radius: 20px;">
                <div class="mb-4">
                    <h5 class="fw-bold mb-1 text-slate-800" style="font-family: 'Outfit', sans-serif;">Resumen por Métodos de Pago</h5>
                    <p class="text-muted mb-0" style="font-size: 0.825rem;">Ingresos acumulados según la modalidad de pago.</p>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-hover text-nowrap mb-0">
                        <thead class="bg-white" style="background-color: #f2faf6;">
                            <tr>
                                <th class="text-slate-700 py-3 px-3 border-0" style="font-size: 0.85rem; font-weight: 600; border-radius: 8px 0 0 8px;">Método</th>
                                <th class="text-slate-700 py-3 px-3 border-0 text-center" style="font-size: 0.85rem; font-weight: 600;">Transacciones</th>
                                <th class="text-slate-700 py-3 px-3 border-0 text-end" style="font-size: 0.85rem; font-weight: 600; border-radius: 0 8px 8px 0;">Total Recaudado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $hasPayments = false; @endphp
                            @foreach($metodosDefault as $key => $data)
                                @if($data['count'] > 0 || $data['total'] > 0)
                                    @php $hasPayments = true; @endphp
                                    <tr>
                                        <td class="py-3 px-3">
                                            <div class="d-flex align-items-center gap-2">
                                                @switch($key)
                                                    @case('yape')
                                                        <span class="payment-badge" style="background-color: #fce7f3; color: #db2777;">Yape</span>
                                                        @break
                                                    @case('plin')
                                                        <span class="payment-badge" style="background-color: #ecfdf5; color: #059669;">Plin</span>
                                                        @break
                                                    @case('bcp')
                                                        <span class="payment-badge" style="background-color: #e0f2fe; color: #0284c7;">BCP</span>
                                                        @break
                                                    @case('tarjeta')
                                                        <span class="payment-badge" style="background-color: #e0e7ff; color: #4f46e5;">Tarjeta</span>
                                                        @break
                                                    @case('efectivo')
                                                        <span class="payment-badge" style="background-color: #f2faf6; color: #d97706;">Efectivo</span>
                                                        @break
                                                    @case('transferencia')
                                                        <span class="payment-badge" style="background-color: #f3e8ff; color: #7c3aed;">Transf.</span>
                                                        @break
                                                    @default
                                                        <span class="payment-badge" style="background-color: #f1f5f9; color: #475569;">Otro</span>
                                                @endswitch
                                                <span class="fw-semibold text-slate-700" style="font-size: 0.9rem;">{{ $data['nombre'] }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center py-3 px-3 text-slate-600" style="font-size: 0.9rem;">
                                            {{ $data['count'] }}
                                        </td>
                                        <td class="text-end py-3 px-3 fw-bold text-slate-800" style="font-size: 0.95rem;">
                                            S/. {{ number_format($data['total'], 2) }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                            @if(!$hasPayments)
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i data-lucide="receipt" class="mb-2" style="width: 44px; height: 44px; opacity: 0.4;"></i>
                                        <p class="mb-0">No se registraron transacciones cobradas en este periodo.</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script id="ingresos-mensuales-data" type="application/json">
    {!! json_encode($ingresosMensuales ?? []) !!}
</script>
<script id="citas-estado-data" type="application/json">
    {!! json_encode($citasPorEstado ?? []) !!}
</script>
<script id="top-tratamientos-data" type="application/json">
    {!! json_encode($topTratamientos ?? []) !!}
</script>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>

<script>
    // Quick filter date ranges calculator helper
    function applyQuickFilter(range) {
        const today = new Date();
        let start = '';
        let end = '';

        const formatDate = (date) => {
            const yyyy = date.getFullYear();
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const dd = String(date.getDate()).padStart(2, '0');
            return `${yyyy}-${mm}-${dd}`;
        };

        if (range === 'month') {
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
            start = formatDate(firstDay);
            end = formatDate(lastDay);
        } else if (range === 'quarter') {
            const firstDay = new Date(today.getFullYear(), today.getMonth() - 3, 1);
            start = formatDate(firstDay);
            end = formatDate(today);
        } else if (range === 'year') {
            const firstDay = new Date(today.getFullYear(), 0, 1);
            const lastDay = new Date(today.getFullYear(), 11, 31);
            start = formatDate(firstDay);
            end = formatDate(lastDay);
        } else if (range === 'all') {
            start = '2024-01-01'; // Earliest logical start date
            end = formatDate(today);
        }

        document.getElementById('fecha_inicio').value = start;
        document.getElementById('fecha_fin').value = end;
        document.getElementById('filterForm').requestSubmit();
    }

    document.addEventListener('DOMContentLoaded', function() {
    // ----------------------------------------------------
    // CHART 1: LINE CHART FOR MONTHLY INCOME
    // ----------------------------------------------------
    const ctxIncome = document.getElementById('incomeTrendChart').getContext('2d');
    const ingresosObj = JSON.parse(document.getElementById('ingresos-mensuales-data').textContent || '{}');
    const incomeLabels = Object.keys(ingresosObj);
    const incomeData = Object.values(ingresosObj);

    // Create gradient fill for line chart
    const gradientFill = ctxIncome.createLinearGradient(0, 0, 0, 300);
    gradientFill.addColorStop(0, 'rgba(32, 127, 84, 0.35)');
    gradientFill.addColorStop(1, 'rgba(32, 127, 84, 0.00)');

    new Chart(ctxIncome, {
        type: 'line',
        data: {
            labels: incomeLabels.map(mes => {
                // Formatting "2026-05" into short month names
                const date = new Date(mes + '-02'); // Offset to avoid UTC local conversions
                return date.toLocaleDateString('es-ES', { month: 'short', year: '2-digit' }).toUpperCase();
            }),
            datasets: [{
                label: 'Ingresos (S/.)',
                data: incomeData,
                borderColor: '#207f54',
                borderWidth: 3,
                backgroundColor: gradientFill,
                fill: true,
                tension: 0.35,
                pointBackgroundColor: '#207f54',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: { left: 10, right: 20, top: 15, bottom: 10 }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Ingresos: S/. ' + context.parsed.y.toLocaleString('es-PE', { minimumFractionDigits: 2 });
                        }
                    }
                }
            },
            scales: {
                y: {
                    grid: { borderDash: [5, 5], drawBorder: false },
                    border: { display: false },
                    ticks: {
                        callback: function(value) { return 'S/. ' + value; },
                        font: { family: 'Plus Jakarta Sans', size: 11 },
                        padding: 10
                    }
                },
                x: {
                    grid: { display: false, drawBorder: false },
                    border: { display: false },
                    ticks: { font: { family: 'Plus Jakarta Sans', size: 11 }, padding: 10 }
                }
            }
        }
    });

    // ----------------------------------------------------
    // CHART 2: DOUGHNUT CHART FOR APPOINTMENT STATUSES
    // ----------------------------------------------------
    const appointmentCanvas = document.getElementById('appointmentStatusChart');
    if (appointmentCanvas) {
        const ctxStatus = appointmentCanvas.getContext('2d');
        const citasEstadoObj = JSON.parse(document.getElementById('citas-estado-data').textContent || '{}');
        const statusData = [
            citasEstadoObj['pendiente'] || 0,
            citasEstadoObj['confirmada'] || 0,
            citasEstadoObj['en_espera'] || 0,
            citasEstadoObj['completada'] || 0,
            citasEstadoObj['cancelada'] || 0
        ];

        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Pendiente', 'Confirmada', 'En Espera', 'Completada', 'Cancelada'],
                datasets: [{
                    data: statusData,
                    backgroundColor: ['#1b5c3a', '#1b5c3a', '#8b5cf6', '#207f54', '#6b7280'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            padding: 20,
                            usePointStyle: true,
                            font: { family: 'Plus Jakarta Sans', size: 12 }
                        }
                    },
                    tooltip: {
                        padding: 10,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.parsed / total) * 100);
                                return ` ${context.label}: ${context.parsed} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // ----------------------------------------------------
    // CHART 3: HORIZONTAL BAR CHART FOR TOP TREATMENTS
    // ----------------------------------------------------
    const treatmentsCanvas = document.getElementById('treatmentsChart');
    if (treatmentsCanvas) {
        const ctxTreatments = treatmentsCanvas.getContext('2d');
        const tratamientosArray = JSON.parse(document.getElementById('top-tratamientos-data').textContent || '[]');
        const treatmentsLabels = tratamientosArray.map(t => t.nombre);
        const treatmentsData = tratamientosArray.map(t => t.total);

        new Chart(ctxTreatments, {
            type: 'bar',
            data: {
                labels: treatmentsLabels,
                datasets: [{
                    label: 'Citas programadas',
                    data: treatmentsData,
                    backgroundColor: 'rgba(32, 127, 84, 0.85)',
                    hoverBackgroundColor: '#207f54',
                    borderRadius: 6,
                    barThickness: 18
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { padding: 10 }
                },
                scales: {
                    x: {
                        grid: { borderDash: [5, 5] },
                        ticks: {
                            stepSize: 1,
                            font: { family: 'Plus Jakarta Sans' }
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { family: 'Plus Jakarta Sans' } }
                    }
                }
            }
        });
    }
    });
</script>
@endsection
