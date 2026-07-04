@extends('layouts.plantilla')

@section('title', 'Caja y Finanzas - Control General')

@section('styles')
<style>
    .finance-shell {
        max-width: 1280px;
        margin: 0 auto;
        color: #0f172a;
    }

    .finance-hero {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        padding: 20px;
        border: 1px solid #cceee6;
        border-radius: 8px;
        background: linear-gradient(135deg, rgba(0, 168, 132, 0.11), rgba(13, 151, 165, 0.06)), #ffffff;
        box-shadow: 0 12px 30px rgba(6, 61, 107, 0.08);
        margin-bottom: 14px;
    }

    .finance-kicker {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        width: fit-content;
        padding: 5px 9px;
        border-radius: 999px;
        border: 1px solid rgba(0, 168, 132, 0.22);
        background: #ffffff;
        color: var(--primary-hover);
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 9px;
    }

    .finance-title {
        margin: 0;
        color: #003f35;
        font: 800 1.75rem/1.08 'Outfit', sans-serif;
        letter-spacing: 0;
    }

    .finance-subtitle {
        color: #557084;
        font-size: 0.92rem;
        margin: 6px 0 0;
        max-width: 680px;
    }

    .finance-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 8px;
    }

    .finance-action {
        min-height: 38px;
        border-radius: 8px !important;
        font-size: 0.82rem;
        white-space: nowrap;
    }

    .finance-map {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 18px;
    }

    .finance-map-card {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        min-height: 96px;
        padding: 15px;
        border: 1px solid #d8eef2;
        border-radius: 8px;
        background: #ffffff;
        color: inherit;
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(6, 61, 107, 0.05);
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .finance-map-card:hover {
        transform: translateY(-1px);
        border-color: #9edbd1;
        box-shadow: 0 12px 26px rgba(6, 61, 107, 0.08);
        color: inherit;
    }

    .finance-map-icon,
    .section-icon {
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        color: #ffffff;
        background: var(--primary);
    }

    .finance-map-card.clients .finance-map-icon,
    .finance-section.clients .section-icon {
        background: #2563eb;
    }

    .finance-map-title {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #0f172a;
        font: 800 1rem/1.2 'Outfit', sans-serif;
        margin-bottom: 4px;
    }

    .finance-step {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 999px;
        background: #e8fbf6;
        color: var(--primary-hover);
        font-size: 0.78rem;
        font-weight: 900;
    }

    .finance-map-card.clients .finance-step {
        background: #eff6ff;
        color: #1d4ed8;
    }

    .finance-map-text {
        color: #64748b;
        font-size: 0.83rem;
        line-height: 1.45;
        margin: 0;
    }

    .finance-section {
        border: 1px solid #d8eef2 !important;
        border-top: 5px solid var(--primary) !important;
        border-radius: 8px !important;
        background: #ffffff !important;
        box-shadow: 0 12px 28px rgba(6, 61, 107, 0.07) !important;
        overflow: hidden;
    }

    .finance-section.clients {
        border-top-color: #2563eb !important;
    }

    .finance-section-header {
        padding: 18px 20px 14px;
        border-bottom: 1px solid #dbeaf0;
        background: linear-gradient(180deg, #ffffff, #f8fbfc);
    }

    .section-heading-wrap {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }

    .section-heading-main {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        min-width: 0;
    }

    .section-eyebrow {
        display: block;
        color: #64748b;
        font-size: 0.68rem;
        font-weight: 900;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 3px;
    }

    .finance-section-title {
        color: #0f172a;
        font: 800 1.2rem/1.18 'Outfit', sans-serif;
        margin: 0;
    }

    .finance-section-copy {
        color: #64748b;
        font-size: 0.86rem;
        margin: 4px 0 0;
    }

    .section-guide {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        margin-top: 14px;
    }

    .guide-note {
        display: flex;
        gap: 9px;
        align-items: flex-start;
        padding: 11px 12px;
        border-radius: 8px;
        border: 1px solid #dbeaf0;
        background: #ffffff;
        color: #475569;
        font-size: 0.8rem;
        line-height: 1.42;
    }

    .guide-note strong {
        color: #0f172a;
    }

    .finance-filter-panel {
        border: 1px solid #d8eef2 !important;
        border-radius: 8px !important;
        background: linear-gradient(180deg, #fbfeff, #f7fbfc) !important;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.75);
    }

    .finance-filter-panel .card-body {
        padding: 18px !important;
    }

    .filter-title {
        display: flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 12px;
        color: #0f172a;
        font: 800 0.9rem/1.2 'Outfit', sans-serif;
    }

    .finance-filter-panel .form-label {
        color: #24465a !important;
        font-weight: 800 !important;
    }

    .finance-filter-panel .form-control,
    .finance-filter-panel .form-select {
        min-height: 44px;
        border-radius: 8px !important;
        border-color: #c9e5ec !important;
        background-color: #ffffff !important;
        font-size: 0.82rem !important;
    }

    .finance-filter-panel .form-control:focus,
    .finance-filter-panel .form-select:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(0, 168, 132, 0.12) !important;
    }

    .finance-filter-panel .btn {
        min-height: 44px;
    }

    .filter-search-control {
        position: relative;
    }

    .filter-search-control i,
    .filter-search-control svg {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: #0d97a5;
        pointer-events: none;
    }

    .filter-search-control .form-control {
        padding-left: 40px !important;
    }

    .finance-table-card {
        border: 1px solid #d8eef2 !important;
        border-radius: 8px !important;
        overflow: hidden;
        background: #ffffff;
    }

    .finance-table-card thead {
        background: #f8fbfc !important;
    }

    .finance-table-card table {
        min-width: 900px;
    }

    .finance-table-card th {
        padding-top: 13px !important;
        padding-bottom: 13px !important;
        color: #536b85 !important;
        font-weight: 900 !important;
        border-bottom: 1px solid #d8eef2 !important;
        background: #f9fcfd;
    }

    .finance-table-card td {
        padding-top: 13px !important;
        padding-bottom: 13px !important;
        border-bottom: 1px solid #d8eef2 !important;
    }

    .finance-table-card tbody tr {
        transition: background-color 0.2s ease;
    }

    .finance-table-card tbody tr:hover {
        background-color: #fbfdfe;
    }

    .client-kpis > .col > div {
        min-height: 58px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow: 0 6px 16px rgba(6, 61, 107, 0.04);
    }

    .client-status-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        min-height: 32px;
    }

    .client-due {
        display: inline-flex;
        flex-direction: column;
        gap: 3px;
        min-width: 120px;
    }

    .client-due-date {
        color: #0f172a;
        font: 800 0.95rem/1.15 'Outfit', sans-serif;
    }

    .client-due-note {
        color: #64748b;
        font-size: 0.73rem;
        line-height: 1.2;
    }

    .client-due.overdue .client-due-date,
    .client-due.overdue .client-due-note {
        color: #b91c1c;
    }

    .client-due.paid {
        color: var(--primary-hover);
        font-weight: 800;
        flex-direction: row;
        align-items: center;
    }

    .action-mini-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px !important;
    }

    @media (max-width: 992px) {
        .finance-hero {
            flex-direction: column;
        }

        .finance-actions {
            justify-content: flex-start;
            width: 100%;
        }

        .finance-map,
        .section-guide {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .finance-hero,
        .finance-section-header {
            padding: 16px;
        }

        .finance-title {
            font-size: 1.42rem;
        }

        .finance-actions .btn,
        .finance-action {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid p-0 finance-shell">
    <!-- Header -->
    <div class="finance-hero">
        <div>
            <div class="finance-kicker">
                <i data-lucide="layout-dashboard" style="width: 13px; height: 13px;"></i>
                Panel administrativo
            </div>
            <h1 class="finance-title">Caja y Gestión de Clientes</h1>
            <p class="finance-subtitle">
                Esta pantalla está dividida en dos partes: primero el dinero de la clínica, luego el estado de pago de cada paciente.
            </p>
        </div>
        <div class="finance-actions">
            <a href="{{ route('finanzas.pdf', request()->all()) }}" class="btn btn-outline-danger d-flex align-items-center gap-2 px-3 py-2 finance-action" style="font-weight: 700;">
                <i data-lucide="file-text" style="width: 17px; height: 17px;"></i>
                Reporte PDF
            </a>
            <button class="btn btn-primary d-flex align-items-center gap-2 px-3 py-2 finance-action" data-ui-toggle="modal" data-ui-target="#createPagoModal" style="background-color: var(--primary); border-color: var(--primary); font-weight: 700; color: white;">
                <i data-lucide="plus-circle" style="width: 17px; height: 17px;"></i>
                Nuevo cobro
            </button>
            <button class="btn btn-outline-danger d-flex align-items-center gap-2 px-3 py-2 finance-action" data-ui-toggle="modal" data-ui-target="#createGastoModal" style="font-weight: 700;">
                <i data-lucide="minus-circle" style="width: 17px; height: 17px;"></i>
                Nuevo gasto
            </button>
        </div>
    </div>

    <div class="finance-map" aria-label="Secciones de caja y clientes">
        <a href="#caja-finanzas" class="finance-map-card">
            <span class="finance-map-icon">
                <i data-lucide="wallet" style="width: 20px; height: 20px;"></i>
            </span>
            <span>
                <span class="finance-map-title"><span class="finance-step">1</span> Caja y Finanzas</span>
                <p class="finance-map-text">Controla ingresos, gastos y balance del mes. Aquí se registran cobros y egresos.</p>
            </span>
        </a>
        <a href="#gestion-clientes" class="finance-map-card clients">
            <span class="finance-map-icon">
                <i data-lucide="users" style="width: 20px; height: 20px;"></i>
            </span>
            <span>
                <span class="finance-map-title"><span class="finance-step">2</span> Gestión de Clientes</span>
                <p class="finance-map-text">Revisa qué pacientes están al día, con saldo, en cuotas o morosos.</p>
            </span>
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-3 mb-4" role="alert" style="background-color: var(--primary-light); color: var(--primary-hover); border-radius: 12px; padding: 14px 20px;">
            <i data-lucide="check-circle" style="width: 24px; height: 24px; flex-shrink: 0;"></i>
            <div style="font-weight: 500;">{{ session('success') }}</div>
        </div>
    @endif

    <!-- =========================================================================
         SECCIÓN 1: CAJA Y FINANZAS
         ========================================================================= -->
    <div id="caja-finanzas" class="card border-0 shadow-sm mb-5 finance-section">
        <div class="finance-section-header">
            <div class="section-heading-wrap">
                <div class="section-heading-main">
                    <div class="section-icon">
                        <i data-lucide="wallet" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <span class="section-eyebrow">Sección 1</span>
                        <h2 class="finance-section-title">Caja y Finanzas</h2>
                        <p class="finance-section-copy">Movimientos de dinero de la clínica: cobros recibidos, gastos realizados y balance del periodo.</p>
                    </div>
                </div>
                <a href="#gestion-clientes" class="btn btn-light border d-flex align-items-center gap-2 finance-action" style="font-weight: 700;">
                    Ver Gestión de Clientes
                    <i data-lucide="arrow-down" style="width: 15px; height: 15px;"></i>
                </a>
            </div>
            <div class="section-guide">
                <div class="guide-note">
                    <i data-lucide="circle-dollar-sign" style="width: 17px; height: 17px; color: var(--primary);"></i>
                    <span><strong>Úsalo para caja:</strong> saber cuánto entró, cuánto salió y cuál es el balance.</span>
                </div>
                <div class="guide-note">
                    <i data-lucide="filter" style="width: 17px; height: 17px; color: var(--primary);"></i>
                    <span><strong>Filtra movimientos:</strong> por mes, paciente, concepto, ingreso o egreso.</span>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <!-- Cards Summary Balance -->
            <div class="row g-3 mb-4">
                <!-- Incomes Card -->
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; border: 1px solid var(--border-color) !important; background: linear-gradient(135deg, #ffffff, #f0fdf4);">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted fw-medium" style="font-size: 0.85rem;">Ingresos Totales (Cobros)</span>
                                <div class="p-2 bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #1b5c3a !important;">
                                    <i data-lucide="trending-up" style="width: 16px; height: 16px;"></i>
                                </div>
                            </div>
                            <h4 class="mb-1 fw-bold" style="color: #065f46; font-family: 'Outfit', sans-serif;">
                                S/. {{ number_format($totalIngresos, 2) }}
                            </h4>
                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">Dinero cobrado en el periodo seleccionado</p>
                        </div>
                    </div>
                </div>

                <!-- Expenses Card -->
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 14px; border: 1px solid var(--border-color) !important; background: linear-gradient(135deg, #ffffff, #f2faf6);">
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted fw-medium" style="font-size: 0.85rem;">Egresos Totales (Gastos)</span>
                                <div class="p-2 bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background-color: #1b5c3a !important;">
                                    <i data-lucide="trending-down" style="width: 16px; height: 16px;"></i>
                                </div>
                            </div>
                            <h4 class="mb-1 fw-bold" style="color: #0e301e; font-family: 'Outfit', sans-serif;">
                                S/. {{ number_format($totalEgresos, 2) }}
                            </h4>
                            <p class="text-muted small mb-0" style="font-size: 0.75rem;">Gastos y costos operativos en el periodo</p>
                        </div>
                    </div>
                </div>

                <!-- Net Balance Card -->
                <div class="col-12 col-md-4">
                    <div class="card border-0 shadow-sm h-100" @style([
                        'border-radius: 14px',
                        'border: 1px solid var(--border-color) !important',
                        'background: linear-gradient(135deg, #ffffff, #ecfdf5)' => $balance >= 0,
                        'background: linear-gradient(135deg, #ffffff, #fff5f5)' => $balance < 0,
                    ])>
                        <div class="card-body p-3">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="text-muted fw-medium" style="font-size: 0.85rem;">Balance Neto (Caja)</span>
                                <div class="p-2 rounded-circle d-flex align-items-center justify-content-center" @style([
                                    'width: 32px',
                                    'height: 32px',
                                    'color: white',
                                    'background-color: #1b5c3a' => $balance >= 0,
                                    'background-color: #dc2626' => $balance < 0,
                                ])>
                                    <i data-lucide="dollar-sign" style="width: 16px; height: 16px;"></i>
                                </div>
                            </div>
                            <h4 class="mb-1 fw-bold" @style([
                                "font-family: 'Outfit', sans-serif",
                                'color: #047857' => $balance >= 0,
                                'color: #b91c1c' => $balance < 0,
                            ])>
                                S/. {{ number_format($balance, 2) }}
                            </h4>
                            <div>
                                @if($balance >= 0)
                                    <span class="badge fw-semibold" style="font-size: 0.7rem; padding: 3px 6px; border-radius: 20px; background-color: #d1fae5; color: #065f46;">
                                        <i data-lucide="trending-up" class="inline" style="width: 10px; height: 10px; margin-right: 2px;"></i> Superávit
                                    </span>
                                @else
                                    <span class="badge fw-semibold" style="font-size: 0.7rem; padding: 3px 6px; border-radius: 20px; background-color: #f2faf6; color: #0e301e;">
                                        <i data-lucide="trending-down" class="inline" style="width: 10px; height: 10px; margin-right: 2px;"></i> Déficit
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="card border-0 bg-light shadow-none mb-4 finance-filter-panel">
                <div class="card-body p-3">
                    <div class="filter-title">
                        <i data-lucide="sliders-horizontal" style="width: 16px; height: 16px; color: var(--primary);"></i>
                        Filtros de Caja y Finanzas
                    </div>
                    <form action="{{ route('finanzas.index') }}" method="GET" class="row g-3 align-items-end">
                        <!-- Preserved Cliente Filters -->
                        <input type="hidden" name="search_cliente" value="{{ $search_cliente }}">
                        <input type="hidden" name="filtro_cliente" value="{{ $filtro_cliente }}">

                        <!-- Search text -->
                        <div class="col-12 col-md-3">
                            <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.8rem;">Buscar movimiento</label>
                            <div class="filter-search-control">
                                <i data-lucide="search"></i>
                                <input type="text" name="search" class="form-control" placeholder="Paciente, tratamiento o gasto..." value="{{ $search }}">
                            </div>
                        </div>

                        <!-- Month Picker -->
                        <div class="col-12 col-sm-4 col-md-2">
                            <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.8rem;">Mes de caja</label>
                            <input type="month" name="mes" class="form-control" value="{{ $mes }}">
                        </div>

                        <!-- Tipo Filter -->
                        <div class="col-12 col-sm-4 col-md-2">
                            <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.8rem;">Mostrar</label>
                            <select name="tipo" class="form-select">
                                <option value="" {{ $tipo === '' || !$tipo ? 'selected' : '' }}>Todos</option>
                                <option value="ingreso" {{ $tipo === 'ingreso' ? 'selected' : '' }}>Ingresos (Cobros)</option>
                                <option value="egreso" {{ $tipo === 'egreso' ? 'selected' : '' }}>Egresos (Gastos)</option>
                            </select>
                        </div>

                        <!-- Categoria Gasto Filter -->
                        <div class="col-12 col-sm-4 col-md-2">
                            <label class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.8rem;">Categoría de gasto</label>
                            <select name="categoria" class="form-select">
                                <option value="" {{ $categoria === '' || !$categoria ? 'selected' : '' }}>Todas</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat }}" {{ $categoria === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-12 col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1" style="background-color: var(--primary); border-color: var(--primary); border-radius: 8px; font-weight: 700; font-size: 0.85rem;">
                                <i data-lucide="filter" class="inline" style="width: 14px; height: 14px; margin-right: 4px;"></i> Aplicar filtros
                            </button>
                            @if($search || $tipo || $categoria || $mes !== \Carbon\Carbon::now()->format('Y-m'))
                                <a href="{{ route('finanzas.index', ['search_cliente' => $search_cliente, 'filtro_cliente' => $filtro_cliente]) }}" class="btn btn-light border d-flex align-items-center justify-content-center" style="height: 38px; width: 38px; border-radius: 8px; color: var(--text-muted);">
                                    <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Movements List -->
            @if($movimientos->isEmpty())
                <div class="text-center p-5 border rounded-3 bg-white">
                    <div class="p-3 mx-auto mb-3" style="background-color: var(--primary-light); border-radius: 50%; width: 64px; height: 64px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                        <i data-lucide="receipt" style="width: 32px; height: 32px;"></i>
                    </div>
                    <h5 class="fw-semibold" style="font-family: 'Outfit', sans-serif;">Sin movimientos de caja</h5>
                    <p class="text-muted small">No se encontraron cobros ni gastos registrados para los filtros seleccionados.</p>
                </div>
            @else
                <div class="table-responsive border rounded-3 bg-white finance-table-card">
                    <table class="table table-hover align-middle text-nowrap mb-0">
                        <thead class="bg-light text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                            <tr>
                                <th class="py-2.5 ps-3"><i data-lucide="calendar" class="me-1" style="width: 14px; height: 14px;"></i> Fecha</th>
                                <th class="py-2.5"><i data-lucide="activity" class="me-1" style="width: 14px; height: 14px;"></i> Tipo</th>
                                <th class="py-2.5"><i data-lucide="file-text" class="me-1" style="width: 14px; height: 14px;"></i> Movimiento</th>
                                <th class="py-2.5"><i data-lucide="folder" class="me-1" style="width: 14px; height: 14px;"></i> Tratamiento / Categoría</th>
                                <th class="py-2.5"><i data-lucide="credit-card" class="me-1" style="width: 14px; height: 14px;"></i> Método</th>
                                <th class="py-2.5"><i data-lucide="check-circle" class="me-1" style="width: 14px; height: 14px;"></i> Estado / Comprobante</th>
                                <th class="py-2.5 text-end"><i data-lucide="dollar-sign" class="me-1" style="width: 14px; height: 14px;"></i> Monto</th>
                                <th class="py-2.5 text-center pe-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movimientos as $mov)
                                <tr style="font-size: 0.85rem;">
                                    <!-- Date -->
                                    <td class="py-2.5 ps-3 fw-semibold text-slate-700">
                                        {{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y') }}
                                    </td>

                                    <!-- Type -->
                                    <td class="py-2.5">
                                        @if($mov->tipo === 'ingreso')
                                            <span class="badge fw-bold" style="background-color: #dcfce7; color: #15803d; font-size: 0.65rem; padding: 4px 8px; border-radius: 20px;">
                                                <i data-lucide="arrow-up-right" style="width: 12px; height: 12px; margin-right: 2px;"></i> INGRESO
                                            </span>
                                        @else
                                            <span class="badge fw-bold" style="background-color: #fee2e2; color: #b91c1c; font-size: 0.65rem; padding: 4px 8px; border-radius: 20px;">
                                                <i data-lucide="arrow-down-left" style="width: 12px; height: 12px; margin-right: 2px;"></i> EGRESO
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Concept / Patient -->
                                    <td class="py-2.5">
                                        <div class="fw-semibold text-slate-800">{{ $mov->concepto }}</div>
                                    </td>

                                    <!-- Category -->
                                    <td class="py-2.5">
                                        @if($mov->tipo === 'ingreso')
                                            <span class="badge fw-semibold text-slate-600" style="background-color: #f1f5f9; border: 1px solid var(--border-color); font-size: 0.7rem; padding: 3px 8px; border-radius: 6px;">
                                                {{ $mov->categoria }}
                                            </span>
                                        @else
                                            @php
                                                $catColors = [
                                                    'Material'     => ['bg' => '#fdf2f8', 'color' => '#be185d'],
                                                    'Equipamiento' => ['bg' => '#eff6ff', 'color' => '#1d4ed8'],
                                                    'Servicios'    => ['bg' => '#fdf4ff', 'color' => '#7e22ce'],
                                                    'Personal'     => ['bg' => '#fff7ed', 'color' => '#c2410c'],
                                                    'Otros'        => ['bg' => '#f0fdfa', 'color' => '#0f766e'],
                                                ];
                                                $colors = $catColors[$mov->categoria] ?? ['bg' => '#f1f5f9', 'color' => '#64748b'];
                                            @endphp
                                            <span class="badge fw-semibold" @style([
                                                'background-color: ' . $colors['bg'],
                                                'color: ' . $colors['color'],
                                                'font-size: 0.7rem',
                                                'padding: 3px 8px',
                                                'border-radius: 6px',
                                            ])>
                                                {{ $mov->categoria }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Payment Method -->
                                    <td class="py-2.5 text-capitalize text-muted" style="font-size: 0.8rem;">
                                        {{ $mov->metodo_pago }}
                                    </td>

                                    <!-- State or Voucher -->
                                    <td class="py-2.5">
                                        @if($mov->tipo === 'ingreso')
                                            @php
                                                $comprobanteStyle = match($mov->comprobante_estado) {
                                                    'pagado'   => 'background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;',
                                                    'parcial'  => 'background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a;',
                                                    default    => 'background-color: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe;',
                                                };
                                                $comprobanteText = match($mov->comprobante_estado) {
                                                    'pagado'   => 'Pagado',
                                                    'parcial'  => 'A Cuenta',
                                                    default    => 'Pendiente',
                                                };
                                            @endphp
                                            <span class="badge text-uppercase fw-semibold" @style([
                                                'font-size: 0.65rem',
                                                'padding: 3px 8px',
                                                'border-radius: 6px',
                                                $comprobanteStyle
                                            ])>
                                                {{ $comprobanteText }}
                                            </span>
                                        @else
                                            <span class="text-muted" style="font-size: 0.8rem;">{{ $mov->comprobante_estado }}</span>
                                        @endif
                                    </td>

                                    <!-- Amount -->
                                    <td class="py-2.5 text-end fw-bold" @style([
                                        'font-size: 0.9rem',
                                        'color: #047857' => $mov->tipo === 'ingreso',
                                        'color: #dc2626' => $mov->tipo !== 'ingreso',
                                    ])>
                                        {{ $mov->tipo === 'ingreso' ? '+' : '-' }}S/. {{ number_format($mov->monto, 2) }}
                                    </td>

                                    <!-- Action buttons -->
                                    <td class="py-2.5 text-center pe-3">
                                        <div class="d-flex justify-content-center gap-1">
                                            @if($mov->tipo === 'ingreso')
                                                <!-- Edit Pago Button -->
                                                <button type="button" class="btn btn-sm btn-light border p-1.5 edit-pago-btn"
                                                    data-ui-toggle="modal"
                                                    data-ui-target="#editPagoModal"
                                                    data-id="{{ $mov->id }}"
                                                    data-update-url="{{ route('pagos.update', ['id' => $mov->id]) }}"
                                                    data-paciente-id="{{ $mov->detalles->paciente_id }}"
                                                    data-cita-id="{{ $mov->detalles->cita_id ?? '' }}"
                                                    data-monto="{{ $mov->detalles->monto }}"
                                                    data-metodo-pago="{{ $mov->detalles->metodo_pago }}"
                                                    data-fecha-pago="{{ str_replace(' ', 'T', $mov->detalles->fecha_pago) }}"
                                                    data-estado="{{ $mov->detalles->estado }}"
                                                    data-notas="{{ $mov->detalles->notas }}"
                                                    style="border-radius: 6px;"
                                                    title="Editar Pago">
                                                    <i data-lucide="pencil" style="width: 12px; height: 12px; color: var(--text-muted);"></i>
                                                </button>
                                                <!-- Delete Pago Form -->
                                                <form action="{{ route('pagos.destroy', $mov->id) }}" method="POST" data-axios-delete data-axios-no-reload="true" data-confirm="¿Está seguro de que desea anular este pago?" style="display:inline-block;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light border p-1.5" style="border-radius: 6px; color: #dc2626;" title="Eliminar Pago">
                                                        <i data-lucide="trash-2" style="width: 12px; height: 12px;"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <!-- Edit Gasto Button -->
                                                <button type="button" class="btn btn-sm btn-light border p-1.5 edit-gasto-btn"
                                                    data-id="{{ $mov->id }}"
                                                    data-update-url="{{ route('gastos.update', ['id' => $mov->id]) }}"
                                                    data-concepto="{{ $mov->detalles->concepto }}"
                                                    data-descripcion="{{ $mov->detalles->descripcion }}"
                                                    data-monto="{{ $mov->detalles->monto }}"
                                                    data-categoria="{{ $mov->detalles->categoria }}"
                                                    data-metodo="{{ $mov->detalles->metodo_pago }}"
                                                    data-fecha="{{ \Carbon\Carbon::parse($mov->detalles->fecha_gasto)->format('Y-m-d') }}"
                                                    data-comprobante="{{ $mov->detalles->comprobante }}"
                                                    data-ui-toggle="modal" data-ui-target="#editGastoModal"
                                                    style="border-radius: 6px;" title="Editar Gasto">
                                                    <i data-lucide="pencil" style="width: 12px; height: 12px; color: var(--text-muted);"></i>
                                                </button>
                                                <!-- Delete Gasto Form -->
                                                <form action="{{ route('gastos.destroy', $mov->id) }}" method="POST" data-axios-delete data-axios-no-reload="true" data-confirm="¿Eliminar este gasto?" style="display:inline-block;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light border p-1.5" style="border-radius: 6px; color: #dc2626;" title="Eliminar Gasto">
                                                        <i data-lucide="trash-2" style="width: 12px; height: 12px;"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-white" style="background-color: #f2faf6;">
                            <tr style="font-size: 0.85rem;">
                                <td colspan="6" class="py-2.5 ps-3 fw-bold text-muted text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Resumen del Período</td>
                                <td class="py-2.5 text-end fw-bold" @style([
                                    'color: #047857' => $balance >= 0,
                                    'color: #dc2626' => $balance < 0,
                                ])>
                                    Balance: S/. {{ number_format($balance, 2) }}
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        </div>
    </div>


    <!-- =========================================================================
         SECCIÓN 2: GESTIÓN DE CLIENTES Y MOROSIDAD
         ========================================================================= -->
    <div id="gestion-clientes" class="card border-0 shadow-sm mb-5 finance-section clients">
        <div class="finance-section-header">
            <div class="section-heading-wrap">
                <div class="section-heading-main">
                    <div class="section-icon">
                        <i data-lucide="users" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div>
                        <span class="section-eyebrow">Sección 2</span>
                        <h2 class="finance-section-title">Gestión de Clientes</h2>
                        <p class="finance-section-copy">Seguimiento por paciente: cuánto debe, cuánto abonó, cuándo vence y qué acción de cobranza corresponde.</p>
                    </div>
                </div>
                <a href="#caja-finanzas" class="btn btn-light border d-flex align-items-center gap-2 finance-action" style="font-weight: 700;">
                    Volver a Caja
                    <i data-lucide="arrow-up" style="width: 15px; height: 15px;"></i>
                </a>
            </div>
            <div class="section-guide">
                <div class="guide-note">
                    <i data-lucide="user-check" style="width: 17px; height: 17px; color: #2563eb;"></i>
                    <span><strong>Úsalo para clientes:</strong> ver quién está al día, quién debe y quién está vencido.</span>
                </div>
                <div class="guide-note">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" style="width: 17px; height: 17px; color: #2563eb;">
    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
</svg>
                    <span><strong>Acciones rápidas:</strong> revisar historial, cobrar saldo o enviar recordatorio por WhatsApp.</span>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <!-- Metric status blocks -->
            <div class="row row-cols-2 row-cols-md-5 g-2.5 mb-4 client-kpis">
                <!-- Total -->
                <div class="col">
                                <div class="p-3 border rounded-3 text-center bg-white" style="background-color: #f2faf6; border-radius: 12px !important;">
                        <span class="text-muted d-block small mb-1">Clientes registrados</span>
                        <h5 class="mb-0 fw-bold text-slate-800">{{ $clienteCounts['todos'] }}</h5>
                    </div>
                </div>
                <!-- Al día -->
                <div class="col">
                    <div class="p-3 border rounded-3 text-center" style="border-radius: 12px !important; background-color: #f0fdf4; border-color: #bbf7d0 !important;">
                        <span class="text-primary d-block small mb-1">Al día</span>
                        <h5 class="mb-0 fw-bold" style="color: #15803d;">{{ $clienteCounts['pagado'] }}</h5>
                    </div>
                </div>
                <!-- Por cuotas -->
                <div class="col">
                    <div class="p-3 border rounded-3 text-center" style="border-radius: 12px !important; background-color: #fefbeb; border-color: #fef08a !important;">
                        <span class="text-primary d-block small mb-1" style="color: #b45309 !important;">En cuotas</span>
                        <h5 class="mb-0 fw-bold" style="color: #a16207;">{{ $clienteCounts['cuotas'] }}</h5>
                    </div>
                </div>
                <!-- Pendientes -->
                <div class="col">
                    <div class="p-3 border rounded-3 text-center" style="border-radius: 12px !important; background-color: #fff7ed; border-color: #ffedd5 !important;">
                        <span class="d-block small mb-1" style="color: #c2410c;">Sin pago inicial</span>
                        <h5 class="mb-0 fw-bold" style="color: #9a3412;">{{ $clienteCounts['pendiente'] }}</h5>
                    </div>
                </div>
                <!-- Morosos -->
                <div class="col">
                    <div class="p-3 border rounded-3 text-center" style="border-radius: 12px !important; background-color: #f2faf6; border-color: #fecaca !important;">
                        <span class="text-primary d-block small mb-1">Vencidos (+15 días)</span>
                        <h5 class="mb-0 fw-bold" style="color: #b91c1c;">{{ $clienteCounts['moroso'] }}</h5>
                    </div>
                </div>
            </div>

            <!-- Client Filter Section -->
            <div class="card border-0 bg-light shadow-none mb-4 finance-filter-panel">
                <div class="card-body p-3">
                    <div class="filter-title">
                        <i data-lucide="search-check" style="width: 16px; height: 16px; color: #2563eb;"></i>
                        Buscar y filtrar clientes
                    </div>
                    <form action="{{ route('finanzas.index') }}" method="GET" class="row g-3 align-items-center">
                        <!-- Preserved Caja Filters -->
                        <input type="hidden" name="search" value="{{ $search }}">
                        <input type="hidden" name="mes" value="{{ $mes }}">
                        <input type="hidden" name="tipo" value="{{ $tipo }}">
                        <input type="hidden" name="categoria" value="{{ $categoria }}">

                        <!-- Search clients -->
                        <div class="col-12 col-md-4">
                            <div class="filter-search-control">
                                <i data-lucide="search"></i>
                                <input type="text" name="search_cliente" class="form-control" placeholder="Nombre, apellido o DNI..." value="{{ $search_cliente }}">
                            </div>
                        </div>

                        <!-- Active status filter selection button group -->
                        <div class="col-12 col-md-8 d-flex flex-wrap gap-1.5 justify-content-md-end">
                            @php
                                $curFilter = $filtro_cliente ?? 'todos';
                            @endphp

                            <a href="{{ route('finanzas.index', array_merge(request()->query(), ['filtro_cliente' => ''])) }}" 
                               class="btn btn-sm py-1.5 px-3 rounded-pill fw-semibold {{ $curFilter === 'todos' || $curFilter === '' ? 'btn-secondary text-white' : 'btn-outline-secondary bg-white' }}" style="font-size: 0.78rem;">
                                Todos ({{ $clienteCounts['todos'] }})
                            </a>

                            <a href="{{ route('finanzas.index', array_merge(request()->query(), ['filtro_cliente' => 'pagado'])) }}" 
                               class="btn btn-sm py-1.5 px-3 rounded-pill fw-semibold {{ $curFilter === 'pagado' ? 'btn-primary text-white' : 'btn-outline-success bg-white' }}" @style([
                                   'font-size: 0.78rem',
                                   'color: #15803d; border-color: #bbf7d0;' => $curFilter !== 'pagado',
                               ])>
                                Al día
                            </a>

                            <a href="{{ route('finanzas.index', array_merge(request()->query(), ['filtro_cliente' => 'cuotas'])) }}" 
                               class="btn btn-sm py-1.5 px-3 rounded-pill fw-semibold {{ $curFilter === 'cuotas' ? 'btn-primary text-dark' : 'btn-outline-warning bg-white' }}" @style([
                                   'font-size: 0.78rem',
                                   'background-color: #1b5c3a; border-color: #1b5c3a;' => $curFilter === 'cuotas',
                                   'color: #a16207; border-color: #fef08a;' => $curFilter !== 'cuotas',
                               ])>
                                En cuotas
                            </a>

                            <a href="{{ route('finanzas.index', array_merge(request()->query(), ['filtro_cliente' => 'pendiente'])) }}" 
                               class="btn btn-sm py-1.5 px-3 rounded-pill fw-semibold {{ $curFilter === 'pendiente' ? 'btn-secondary text-white' : 'btn-outline-secondary bg-white' }}" @style([
                                   'font-size: 0.78rem',
                                   'background-color: #475569; border-color: #475569;' => $curFilter === 'pendiente',
                                   'color: #475569; border-color: #cbd5e1;' => $curFilter !== 'pendiente',
                               ])>
                                Sin pago
                            </a>

                            <a href="{{ route('finanzas.index', array_merge(request()->query(), ['filtro_cliente' => 'moroso'])) }}" 
                               class="btn btn-sm py-1.5 px-3 rounded-pill fw-semibold {{ $curFilter === 'moroso' ? 'btn-primary text-white' : 'btn-outline-danger bg-white' }}" @style([
                                   'font-size: 0.78rem',
                                   'color: #b91c1c; border-color: #fecaca;' => $curFilter !== 'moroso',
                               ])>
                                Vencidos
                            </a>

                            <button type="submit" class="btn btn-primary btn-sm py-1.5 px-3 fw-bold" style="border-radius: 20px;">
                                Buscar cliente
                            </button>

                            @if($search_cliente || $filtro_cliente)
                                <a href="{{ route('finanzas.index', ['search' => $search, 'mes' => $mes, 'tipo' => $tipo, 'categoria' => $categoria]) }}" 
                                   class="btn btn-sm btn-light border d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; border-radius: 50%;">
                                    <i data-lucide="x" style="width: 14px; height: 14px;"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modern Tabs for Divison -->
            <ul class="nav nav-pills-modern mb-3" id="deudores-tab" role="tablist" style="background: #f1f5f9; padding: 4px; border-radius: 10px; display: inline-flex; border: 1px solid #e2e8f0;">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="con-deuda-tab" data-ui-toggle="pill" data-ui-target="#con-deuda" type="button" role="tab" style="color: #64748b; font-weight: 600; border-radius: 8px; padding: 6px 16px; font-size: 0.85rem; border: none; background: transparent; transition: all 0.2s;">
                        <i data-lucide="alert-circle" style="width: 14px; height: 14px; margin-right: 4px;"></i> Con Deuda ({{ $pacientesConFinanzas->where('pending_amount', '>', 0)->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sin-deuda-tab" data-ui-toggle="pill" data-ui-target="#sin-deuda" type="button" role="tab" style="color: #64748b; font-weight: 600; border-radius: 8px; padding: 6px 16px; font-size: 0.85rem; border: none; background: transparent; transition: all 0.2s;">
                        <i data-lucide="check-circle-2" style="width: 14px; height: 14px; margin-right: 4px;"></i> Al Día ({{ $pacientesConFinanzas->where('pending_amount', '<=', 0)->count() }})
                    </button>
                </li>
            </ul>

            <style>
                #deudores-tab .nav-link.active {
                    background: white !important;
                    color: var(--primary) !important;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                }
            </style>

            <div class="tab-content" id="deudores-tabContent">
                
                <!-- TAB: CON DEUDA -->
                <div class="tab-pane fade show active" id="con-deuda" role="tabpanel">
                    @php $deudores = $pacientesConFinanzas->where('pending_amount', '>', 0); @endphp
                    @if($deudores->isEmpty())
                        <div class="text-center p-5 border rounded-3 bg-white">
                            <div class="p-3 mx-auto mb-3 bg-light rounded-circle text-muted d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                                <i data-lucide="shield-check" style="width: 32px; height: 32px; color: #10b981;"></i>
                            </div>
                            <h5 class="fw-semibold" style="font-family: 'Outfit', sans-serif;">Excelente noticia</h5>
                            <p class="text-muted small">No hay ningún paciente con deudas pendientes actualmente.</p>
                        </div>
                    @else
                        <div class="table-responsive border rounded-3 bg-white finance-table-card">
                            <table class="table table-hover align-middle text-nowrap mb-0">
                                <thead class="bg-light text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                    <tr>
                                        <th class="py-2.5 ps-3"><i data-lucide="user" class="me-1" style="width: 14px; height: 14px;"></i> Cliente</th>
                                        <th class="py-2.5"><i data-lucide="alert-triangle" class="me-1" style="width: 14px; height: 14px;"></i> Estado</th>
                                        <th class="py-2.5"><i data-lucide="pie-chart" class="me-1" style="width: 14px; height: 14px;"></i> Deuda Pendiente</th>
                                        <th class="py-2.5"><i data-lucide="calendar" class="me-1" style="width: 14px; height: 14px;"></i> Vencimiento</th>
                                        <th class="py-2.5 text-center pe-3">Acciones de cobro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($deudores as $p)
                                        @php
                                            $pagoStyle = match($p->estado_pago) {
                                                'cuotas'    => ['bg' => '#fef3c7', 'color' => '#b45309', 'border' => '#f59e0b', 'label' => 'En cuotas'],
                                                'pendiente' => ['bg' => '#dbeafe', 'color' => '#1d4ed8', 'border' => '#3b82f6', 'label' => 'Sin pago'],
                                                'moroso'    => ['bg' => '#fee2e2', 'color' => '#b91c1c', 'border' => '#ef4444', 'label' => 'Vencido'],
                                                default     => ['bg' => '#f3f4f6', 'color' => '#4b5563', 'border' => '#9ca3af', 'label' => 'Desconocido'],
                                            };
                                            $daysUntilDue = (int) ceil($p->days_until_due ?? max(0, 15 - $p->days_elapsed));
                                            $daysOverdue = (int) ceil($p->days_overdue ?? max(0, $p->days_elapsed - 15));
                                        @endphp
                                        <tr style="font-size: 0.85rem;">
                                            <td class="py-2.5 ps-3">
                                                <div class="d-flex align-items-center gap-2.5">
                                                    <div class="d-flex align-items-center justify-content-center fw-bold text-uppercase" style="width: 36px; height: 36px; background-color: #fee2e2; color: #b91c1c; border-radius: 8px; font-size: 0.8rem; font-family: 'Outfit', sans-serif;">
                                                        {{ substr($p->nombre, 0, 1) . substr($p->apellido, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold text-slate-800" style="font-size: 0.88rem;">{{ $p->nombre }} {{ $p->apellido }}</div>
                                                        <div class="text-muted small" style="font-size: 0.72rem;">DNI: {{ $p->dni }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-2.5">
                                                <span class="badge fw-semibold text-uppercase" @style([
                                                    'background-color: ' . $pagoStyle['bg'],
                                                    'color: ' . $pagoStyle['color'],
                                                    'border: 1px solid ' . $pagoStyle['border'] . '40',
                                                    'font-size: 0.65rem',
                                                    'padding: 4px 10px',
                                                    'border-radius: 20px',
                                                ])>
                                                    {{ $pagoStyle['label'] }}
                                                </span>
                                            </td>
                                            <td class="py-2.5 fw-bold" style="color: #dc2626;">
                                                S/. {{ number_format($p->pending_amount, 2) }}
                                            </td>
                                            <td class="py-2.5">
                                                <div class="client-due {{ $p->estado_pago === 'moroso' ? 'overdue' : '' }}">
                                                    <span class="client-due-date">{{ \Carbon\Carbon::parse($p->next_due_date)->format('d/m/Y') }}</span>
                                                    <span class="client-due-note">
                                                        @if($p->estado_pago === 'moroso')
                                                            Vencido hace {{ $daysOverdue }} {{ $daysOverdue === 1 ? 'día' : 'días' }}
                                                        @elseif($daysUntilDue === 0)
                                                            Vence hoy
                                                        @else
                                                            Faltan {{ $daysUntilDue }} {{ $daysUntilDue === 1 ? 'día' : 'días' }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="py-2.5 text-center pe-3">
                                                <div class="d-flex justify-content-center gap-1.5">
                                                    @if($p->estado_pago === 'moroso')
                                                        @php
                                                            $mensaje = "Hola, le escribimos para recordarle que tiene un saldo pendiente de S/. " . number_format($p->pending_amount, 2) . " en la clínica. Por favor comunicarse para regularizar. Gracias.";
                                                            $telClean = preg_replace('/[^0-9]/', '', $p->telefono);
                                                            if (strlen($telClean) === 9 && $telClean[0] === '9') { $telClean = '51' . $telClean; }
                                                            $waUrl = "https://wa.me/" . $telClean . "?text=" . rawurlencode($mensaje);
                                                        @endphp
                                                        <a href="{{ $waUrl }}" target="_blank" class="btn btn-sm btn-primary p-1.5 d-flex align-items-center justify-content-center action-mini-btn" style="background-color: #25d366; border-color: #25d366; color: white;" title="Enviar cobranza por WhatsApp">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 24 24">
                                                              <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-outline-primary p-1.5 d-flex align-items-center justify-content-center show-cliente-history-btn action-mini-btn" data-ui-toggle="modal" data-ui-target="#clienteHistoryModal" data-nombre="{{ $p->nombre }} {{ $p->apellido }}" data-pagos="{{ json_encode($p->pagos) }}" title="Ver Historial">
                                                        <i data-lucide="history" style="width: 12px; height: 12px;"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-success p-1.5 d-flex align-items-center justify-content-center register-pago-quick-btn action-mini-btn" data-ui-toggle="modal" data-ui-target="#createPagoModal" data-paciente-id="{{ $p->id }}" data-monto="{{ $p->pending_amount }}" title="Cobrar Deuda">
                                                        <i data-lucide="dollar-sign" style="width: 12px; height: 12px;"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <!-- TAB: AL DÍA -->
                <div class="tab-pane fade" id="sin-deuda" role="tabpanel">
                    @php $pagados = $pacientesConFinanzas->where('pending_amount', '<=', 0); @endphp
                    @if($pagados->isEmpty())
                        <div class="text-center p-5 border rounded-3 bg-white">
                            <div class="p-3 mx-auto mb-3 bg-light rounded-circle text-muted d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                                <i data-lucide="users" style="width: 32px; height: 32px;"></i>
                            </div>
                            <h5 class="fw-semibold" style="font-family: 'Outfit', sans-serif;">Sin registros</h5>
                            <p class="text-muted small">No hay clientes con estado "Al día" actualmente.</p>
                        </div>
                    @else
                        <div class="table-responsive border rounded-3 bg-white finance-table-card">
                            <table class="table table-hover align-middle text-nowrap mb-0">
                                <thead class="bg-light text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                    <tr>
                                        <th class="py-2.5 ps-3"><i data-lucide="user" class="me-1" style="width: 14px; height: 14px;"></i> Cliente</th>
                                        <th class="py-2.5"><i data-lucide="check-circle" class="me-1" style="width: 14px; height: 14px;"></i> Estado</th>
                                        <th class="py-2.5"><i data-lucide="check-square" class="me-1" style="width: 14px; height: 14px;"></i> Saldo</th>
                                        <th class="py-2.5 text-center pe-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pagados as $p)
                                        <tr style="font-size: 0.85rem;">
                                            <td class="py-2.5 ps-3">
                                                <div class="d-flex align-items-center gap-2.5">
                                                    <div class="d-flex align-items-center justify-content-center fw-bold text-uppercase" style="width: 36px; height: 36px; background-color: #dcfce7; color: #15803d; border-radius: 8px; font-size: 0.8rem; font-family: 'Outfit', sans-serif;">
                                                        {{ substr($p->nombre, 0, 1) . substr($p->apellido, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-semibold text-slate-800" style="font-size: 0.88rem;">{{ $p->nombre }} {{ $p->apellido }}</div>
                                                        <div class="text-muted small" style="font-size: 0.72rem;">DNI: {{ $p->dni }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-2.5">
                                                <span class="badge fw-semibold text-uppercase" style="background-color: #dcfce7; color: #15803d; border: 1px solid #22c55e40; font-size: 0.65rem; padding: 4px 10px; border-radius: 20px;">
                                                    Al Día
                                                </span>
                                            </td>
                                            <td class="py-2.5 fw-bold" style="color: #047857;">
                                                <i data-lucide="check" style="width: 14px; height: 14px; margin-right: 2px;"></i> S/. 0.00
                                            </td>
                                            <td class="py-2.5 text-center pe-3">
                                                <div class="d-flex justify-content-center gap-1.5">
                                                    <button type="button" class="btn btn-sm btn-outline-primary p-1.5 d-flex align-items-center justify-content-center show-cliente-history-btn action-mini-btn" data-ui-toggle="modal" data-ui-target="#clienteHistoryModal" data-nombre="{{ $p->nombre }} {{ $p->apellido }}" data-pagos="{{ json_encode($p->pagos) }}" title="Ver Historial de Pagos">
                                                        <i data-lucide="history" style="width: 12px; height: 12px;"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ==============================================
     MODAL: REGISTRAR INGRESO (PAGO)
     ============================================== -->
<div class="modal fade" id="createPagoModal" tabindex="-1" aria-labelledby="createPagoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bg-content)">
                <h5 class="modal-title fw-bold" id="createPagoModalLabel" style="font-family: 'Outfit', sans-serif; color: var(--text-main);">
                    Registrar Nuevo Cobro (Ingreso)
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('pagos.store') }}" method="POST" data-axios-submit data-axios-reset="true" data-axios-no-reload="true" data-axios-close-modal="true">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Paciente -->
                        <div class="col-12">
                            <label for="create_paciente_id" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Paciente <span class="text-primary">*</span></label>
                            <select name="paciente_id" id="create_paciente_id" class="form-select select-paciente" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                <option value="" disabled selected>Seleccione un paciente...</option>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}">{{ $paciente->nombre }} {{ $paciente->apellido }} (DNI: {{ $paciente->dni }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cita Asociada -->
                        <div class="col-12">
                            <label for="create_cita_id" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Cita Asociada</label>
                            <select name="cita_id" id="create_cita_id" class="form-select select-cita" style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                <option value="" data-paciente-id="all">-- Sin cita vinculada / Pago General --</option>
                                @foreach($citas as $cita)
                                    <option value="{{ $cita->id }}" data-paciente-id="{{ $cita->paciente_id }}" style="display: none;">
                                        {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y H:i') }} - {{ $cita->servicio?->nombre ?? 'Tratamiento' }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted" style="font-size: 0.75rem;">Selecciona primero un paciente para ver sus citas programadas.</small>
                        </div>

                        <!-- Monto -->
                        <div class="col-12 col-sm-6">
                            <label for="create_pago_monto" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Monto (S/.) <span class="text-primary">*</span></label>
                            <input type="number" step="0.01" min="0" name="monto" id="create_pago_monto" class="form-control" required placeholder="0.00" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Metodo de Pago -->
                        <div class="col-12 col-sm-6">
                            <label for="create_pago_metodo" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Método de Pago <span class="text-primary">*</span></label>
                            <select name="metodo_pago" id="create_pago_metodo" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                <option value="yape">Yape</option>
                                <option value="plin">Plin</option>
                                <option value="efectivo" selected>Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="bcp">BCP</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        <!-- Fecha de Pago -->
                        <div class="col-12 col-sm-6">
                            <label for="create_pago_fecha" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Fecha y Hora <span class="text-primary">*</span></label>
                            <input type="datetime-local" name="fecha_pago" id="create_pago_fecha" class="form-control" required value="{{ date('Y-m-d\TH:i') }}" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Estado -->
                        <div class="col-12 col-sm-6">
                            <label for="create_pago_estado" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Estado <span class="text-primary">*</span></label>
                            <select name="estado" id="create_pago_estado" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                <option value="pagado" selected>Pagado (Total)</option>
                                <option value="parcial">Parcial (A cuenta)</option>
                                <option value="pendiente">Pendiente</option>
                            </select>
                        </div>

                        <!-- Notas -->
                        <div class="col-12">
                            <label for="create_pago_notas" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Notas Adicionales</label>
                            <textarea name="notas" id="create_pago_notas" rows="2" class="form-control" placeholder="Escribe detalles del pago, adelantos o números de operación..." style="border-radius: 8px; border-color: var(--border-color);"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top bg-light px-4 py-3" style="border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" data-ui-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: var(--primary); border-color: var(--primary); border-radius: 8px; font-weight: 500;">Registrar Cobro</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==============================================
     MODAL: EDITAR INGRESO (PAGO)
     ============================================== -->
<div class="modal fade" id="editPagoModal" tabindex="-1" aria-labelledby="editPagoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bg-content)">
                <h5 class="modal-title fw-bold" id="editPagoModalLabel" style="font-family: 'Outfit', sans-serif; color: var(--text-main);">
                    Modificar Registro de Cobro
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="editPagoForm" action="" method="POST" data-axios-submit data-axios-no-reload="true" data-axios-close-modal="true">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Paciente -->
                        <div class="col-12">
                            <label for="edit_paciente_id" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Paciente <span class="text-primary">*</span></label>
                            <select name="paciente_id" id="edit_paciente_id" class="form-select select-paciente" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem; background-color: #e2e8f0; pointer-events: none;">
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}">{{ $paciente->nombre }} {{ $paciente->apellido }} (DNI: {{ $paciente->dni }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Cita Asociada -->
                        <div class="col-12">
                            <label for="edit_cita_id" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Cita Asociada</label>
                            <select name="cita_id" id="edit_cita_id" class="form-select select-cita" style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                <option value="" data-paciente-id="all">-- Sin cita vinculada / Pago General --</option>
                                @foreach($citas as $cita)
                                    <option value="{{ $cita->id }}" data-paciente-id="{{ $cita->paciente_id }}">
                                        {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d/m/Y H:i') }} - {{ $cita->servicio?->nombre ?? 'Tratamiento' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Monto -->
                        <div class="col-12 col-sm-6">
                            <label for="edit_monto" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Monto (S/.) <span class="text-primary">*</span></label>
                            <input type="number" step="0.01" min="0" name="monto" id="edit_monto" class="form-control" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Metodo de Pago -->
                        <div class="col-12 col-sm-6">
                            <label for="edit_metodo" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Método de Pago <span class="text-primary">*</span></label>
                            <select name="metodo_pago" id="edit_metodo" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                <option value="yape">Yape</option>
                                <option value="plin">Plin</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="bcp">BCP</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        <!-- Fecha de Pago -->
                        <div class="col-12 col-sm-6">
                            <label for="edit_fecha_pago" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Fecha y Hora <span class="text-primary">*</span></label>
                            <input type="datetime-local" name="fecha_pago" id="edit_fecha_pago" class="form-control" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Estado -->
                        <div class="col-12 col-sm-6">
                            <label for="edit_estado" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Estado <span class="text-primary">*</span></label>
                            <select name="estado" id="edit_estado" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                <option value="pagado">Pagado</option>
                                <option value="parcial">Parcial</option>
                                <option value="pendiente">Pendiente</option>
                            </select>
                        </div>

                        <!-- Notas -->
                        <div class="col-12">
                            <label for="edit_notas" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Notas Adicionales</label>
                            <textarea name="notas" id="edit_notas" rows="2" class="form-control" style="border-radius: 8px; border-color: var(--border-color);"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top bg-light px-4 py-3" style="border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" data-ui-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: var(--primary); border-color: var(--primary); border-radius: 8px; font-weight: 500;">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==============================================
     MODAL: REGISTRAR EGRESO (GASTO)
     ============================================== -->
<div class="modal fade" id="createGastoModal" tabindex="-1" aria-labelledby="createGastoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bg-content)">
                <h5 class="modal-title fw-bold" id="createGastoModalLabel" style="font-family: 'Outfit', sans-serif; color: var(--text-main);">
                    Registrar Egreso (Gasto)
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('gastos.store') }}" method="POST" data-axios-submit data-axios-reset="true" data-axios-no-reload="true" data-axios-close-modal="true">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Concepto -->
                        <div class="col-12">
                            <label for="create_gasto_concepto" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Concepto <span class="text-primary">*</span></label>
                            <input type="text" name="concepto" id="create_gasto_concepto" class="form-control" required placeholder="Ej. Compra de anestésicos, Alquiler del local" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Categoría -->
                        <div class="col-12 col-sm-6">
                            <label for="create_gasto_categoria" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Categoría <span class="text-primary">*</span></label>
                            <select name="categoria" id="create_gasto_categoria" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Monto -->
                        <div class="col-12 col-sm-6">
                            <label for="create_gasto_monto" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Monto (S/.) <span class="text-primary">*</span></label>
                            <input type="number" step="0.01" min="0.01" name="monto" id="create_gasto_monto" class="form-control" required placeholder="0.00" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Método de Pago -->
                        <div class="col-12 col-sm-6">
                            <label for="create_gasto_metodo" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Método de Pago <span class="text-primary">*</span></label>
                            <select name="metodo_pago" id="create_gasto_metodo" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                <option value="efectivo" selected>Efectivo</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="yape">Yape</option>
                                <option value="plin">Plin</option>
                                <option value="bcp">BCP</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        <!-- Fecha Gasto -->
                        <div class="col-12 col-sm-6">
                            <label for="create_gasto_fecha" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Fecha <span class="text-primary">*</span></label>
                            <input type="date" name="fecha_gasto" id="create_gasto_fecha" class="form-control" required value="{{ date('Y-m-d') }}" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Comprobante -->
                        <div class="col-12">
                            <label for="create_gasto_comprobante" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Comprobante / Nro Operación</label>
                            <input type="text" name="comprobante" id="create_gasto_comprobante" class="form-control" placeholder="Ej. Factura F001-003, Boleta, Operación Yape" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Descripción -->
                        <div class="col-12">
                            <label for="create_gasto_desc" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Descripción Adicional</label>
                            <textarea name="descripcion" id="create_gasto_desc" rows="2" class="form-control" placeholder="Especificaciones del egreso..." style="border-radius: 8px; border-color: var(--border-color);"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top bg-light px-4 py-3" style="border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" data-ui-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 8px; font-weight: 500;">Registrar Egreso</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==============================================
     MODAL: EDITAR EGRESO (GASTO)
     ============================================== -->
<div class="modal fade" id="editGastoModal" tabindex="-1" aria-labelledby="editGastoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bg-content)">
                <h5 class="modal-title fw-bold" id="editGastoModalLabel" style="font-family: 'Outfit', sans-serif; color: var(--text-main);">
                    Modificar Registro de Egreso
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="editGastoForm" action="" method="POST" data-axios-submit data-axios-no-reload="true" data-axios-close-modal="true">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Concepto -->
                        <div class="col-12">
                            <label for="edit_gasto_concepto" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Concepto <span class="text-primary">*</span></label>
                            <input type="text" name="concepto" id="edit_gasto_concepto" class="form-control" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Categoría -->
                        <div class="col-12 col-sm-6">
                            <label for="edit_gasto_categoria" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Categoría <span class="text-primary">*</span></label>
                            <select name="categoria" id="edit_gasto_categoria" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Monto -->
                        <div class="col-12 col-sm-6">
                            <label for="edit_gasto_monto" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Monto (S/.) <span class="text-primary">*</span></label>
                            <input type="number" step="0.01" min="0.01" name="monto" id="edit_gasto_monto" class="form-control" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Método de Pago -->
                        <div class="col-12 col-sm-6">
                            <label for="edit_gasto_metodo" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Método de Pago <span class="text-primary">*</span></label>
                            <select name="metodo_pago" id="edit_gasto_metodo" class="form-select" required style="border-radius: 8px; height: 42px; border-color: var(--border-color); font-size: 0.875rem;">
                                <option value="efectivo">Efectivo</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="yape">Yape</option>
                                <option value="plin">Plin</option>
                                <option value="bcp">BCP</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        <!-- Fecha Gasto -->
                        <div class="col-12 col-sm-6">
                            <label for="edit_gasto_fecha" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Fecha <span class="text-primary">*</span></label>
                            <input type="date" name="fecha_gasto" id="edit_gasto_fecha" class="form-control" required style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Comprobante -->
                        <div class="col-12">
                            <label for="edit_gasto_comprobante" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Comprobante</label>
                            <input type="text" name="comprobante" id="edit_gasto_comprobante" class="form-control" style="border-radius: 8px; height: 42px; border-color: var(--border-color);">
                        </div>

                        <!-- Descripción -->
                        <div class="col-12">
                            <label for="edit_gasto_desc" class="form-label fw-semibold text-slate-700 mb-1" style="font-size: 0.85rem;">Descripción Adicional</label>
                            <textarea name="descripcion" id="edit_gasto_desc" rows="2" class="form-control" style="border-radius: 8px; border-color: var(--border-color);"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer border-top bg-light px-4 py-3" style="border-radius: 0 0 16px 16px;">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" data-ui-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: var(--primary); border-color: var(--primary); border-radius: 8px; font-weight: 500;">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==============================================
     MODAL: HISTORIAL DE PAGOS DE CLIENTE (NUEVO)
     ============================================== -->
<div class="modal fade" id="clienteHistoryModal" tabindex="-1" aria-labelledby="clienteHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom px-4 py-3" style="background-color: var(--bg-content)">
                <h5 class="modal-title fw-bold" id="clienteHistoryModalLabel" style="font-family: 'Outfit', sans-serif; color: var(--text-main);">
                    Historial de Pagos - <span id="history_cliente_nombre" class="text-primary"></span>
                </h5>
                <button type="button" class="btn-close" data-ui-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body p-4">
                <div class="table-responsive" id="history_pagos_container">
                    <table class="table table-hover align-middle text-nowrap mb-0" id="history_pagos_table">
                        <thead class="bg-light text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                            <tr>
                                <th class="py-2.5 ps-3">Fecha de Pago</th>
                                <th class="py-2.5">Método de Pago</th>
                                <th class="py-2.5">Estado</th>
                                <th class="py-2.5">Notas / Referencia</th>
                                <th class="py-2.5 text-end pe-3">Monto Cobrado</th>
                            </tr>
                        </thead>
                        <tbody id="history_pagos_tbody">
                            <!-- Populated dynamically via JS -->
                        </tbody>
                    </table>
                </div>
                <div id="history_no_pagos_msg" class="text-center p-5 bg-light rounded-3" style="display: none;">
                    <i data-lucide="info" class="text-muted mb-2" style="width: 32px; height: 32px;"></i>
                    <p class="text-muted mb-0">No se han registrado pagos para este paciente en el sistema.</p>
                </div>
            </div>
            
            <div class="modal-footer border-top bg-light px-4 py-3" style="border-radius: 0 0 16px 16px;">
                <button type="button" class="btn btn-secondary px-4 py-2" data-ui-dismiss="modal" style="border-radius: 8px; font-weight: 500;">Cerrar Historial</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, (char) => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[char]);
        }

        // Dynamic Appointment Dropdown Filtering based on Selected Patient in Cobro Create/Edit Modals
        function filterCitasDropdown(patientSelectId, appointmentSelectId) {
            const patientSelect = document.getElementById(patientSelectId);
            const appointmentSelect = document.getElementById(appointmentSelectId);
            if (!patientSelect || !appointmentSelect) return;

            patientSelect.addEventListener('change', function() {
                const selectedPatientId = this.value;
                const options = appointmentSelect.querySelectorAll('option');

                options.forEach(opt => {
                    const optPatientId = opt.getAttribute('data-paciente-id');
                    if (optPatientId === 'all' || optPatientId === selectedPatientId) {
                        opt.style.display = 'block';
                    } else {
                        opt.style.display = 'none';
                    }
                });

                appointmentSelect.value = '';
            });
        }

        filterCitasDropdown('create_paciente_id', 'create_cita_id');
        filterCitasDropdown('edit_paciente_id', 'edit_cita_id');

        // Populate Edit Pago (Cobro) Modal
        const editPagoBtns = document.querySelectorAll('.edit-pago-btn');
        editPagoBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const pacienteId = this.getAttribute('data-paciente-id');
                const citaId = this.getAttribute('data-cita-id');
                const monto = this.getAttribute('data-monto');
                const metodo = this.getAttribute('data-metodo-pago');
                const fecha = this.getAttribute('data-fecha-pago');
                const estado = this.getAttribute('data-estado');
                const notas = this.getAttribute('data-notas');

                const form = document.getElementById('editPagoForm');
                form.action = this.getAttribute('data-update-url');

                document.getElementById('edit_paciente_id').value = pacienteId;
                if (document.getElementById('edit_paciente_id').tomselect) {
                    document.getElementById('edit_paciente_id').tomselect.setValue(pacienteId, true);
                }
                
                const appointmentSelect = document.getElementById('edit_cita_id');
                const options = appointmentSelect.querySelectorAll('option');
                options.forEach(opt => {
                    const optPatientId = opt.getAttribute('data-paciente-id');
                    if (optPatientId === 'all' || optPatientId === pacienteId) {
                        opt.style.display = 'block';
                    } else {
                        opt.style.display = 'none';
                    }
                });

                appointmentSelect.value = citaId;
                document.getElementById('edit_monto').value = monto;
                document.getElementById('edit_metodo').value = metodo.toLowerCase();
                document.getElementById('edit_fecha_pago').value = fecha.substring(0, 16);
                document.getElementById('edit_estado').value = estado;
                document.getElementById('edit_notas').value = notas ?? '';
            });
        });

        // Populate Edit Gasto (Egreso) Modal
        const editGastoBtns = document.querySelectorAll('.edit-gasto-btn');
        editGastoBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const concepto = this.getAttribute('data-concepto');
                const descripcion = this.getAttribute('data-descripcion');
                const monto = this.getAttribute('data-monto');
                const categoria = this.getAttribute('data-categoria');
                const metodo = this.getAttribute('data-metodo');
                const fecha = this.getAttribute('data-fecha');
                const comprobante = this.getAttribute('data-comprobante');

                const form = document.getElementById('editGastoForm');
                form.action = this.getAttribute('data-update-url');

                document.getElementById('edit_gasto_concepto').value = concepto;
                document.getElementById('edit_gasto_desc').value = descripcion ?? '';
                document.getElementById('edit_gasto_monto').value = monto;
                document.getElementById('edit_gasto_categoria').value = categoria;
                if (document.getElementById('edit_gasto_categoria').tomselect) {
                    document.getElementById('edit_gasto_categoria').tomselect.setValue(categoria, true);
                }
                
                document.getElementById('edit_gasto_metodo').value = metodo.toLowerCase();
                if (document.getElementById('edit_gasto_metodo').tomselect) {
                    document.getElementById('edit_gasto_metodo').tomselect.setValue(metodo.toLowerCase(), true);
                }
                document.getElementById('edit_gasto_fecha').value = fecha;
                document.getElementById('edit_gasto_comprobante').value = comprobante ?? '';
            });
        });

        // Populate Client Payment History Modal
        const historyBtns = document.querySelectorAll('.show-cliente-history-btn');
        historyBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const nombre = this.getAttribute('data-nombre');
                const pagos = JSON.parse(this.getAttribute('data-pagos') || '[]');
                
                document.getElementById('history_cliente_nombre').textContent = nombre;
                
                const tbody = document.getElementById('history_pagos_tbody');
                const noPagosMsg = document.getElementById('history_no_pagos_msg');
                const tableContainer = document.getElementById('history_pagos_container');
                
                tbody.innerHTML = '';
                
                if (pagos.length === 0) {
                    tableContainer.style.display = 'none';
                    noPagosMsg.style.display = 'block';
                } else {
                    tableContainer.style.display = 'block';
                    noPagosMsg.style.display = 'none';
                    
                    pagos.forEach(p => {
                        const tr = document.createElement('tr');
                        tr.style.fontSize = '0.85rem';
                        
                        // Format date string to readable dd/mm/YYYY
                        let dateStr = p.fecha_pago;
                        try {
                            const date = new Date(p.fecha_pago);
                            const day = String(date.getDate()).padStart(2, '0');
                            const month = String(date.getMonth() + 1).padStart(2, '0');
                            const year = date.getFullYear();
                            dateStr = `${day}/${month}/${year}`;
                        } catch(e) {}
                        
                        const estadoSpan = document.createElement('span');
                        estadoSpan.className = 'badge text-uppercase fw-semibold';
                        estadoSpan.style.fontSize = '0.65rem';
                        estadoSpan.style.padding = '3px 8px';
                        estadoSpan.style.borderRadius = '6px';

                        if (p.estado === 'pagado') {
                            estadoSpan.style.backgroundColor = 'var(--primary-light)';
                            estadoSpan.style.color = 'var(--primary-hover)';
                            estadoSpan.textContent = 'PAGADO';
                        } else if (p.estado === 'parcial') {
                            estadoSpan.style.backgroundColor = '#f2faf6';
                            estadoSpan.style.color = '#92400e';
                            estadoSpan.textContent = 'PARCIAL';
                        } else {
                            estadoSpan.style.backgroundColor = '#f2faf6';
                            estadoSpan.style.color = '#0e301e';
                            estadoSpan.textContent = 'PENDIENTE';
                        }
                        
                        const tdDate = document.createElement('td');
                        tdDate.className = 'py-2 ps-3 fw-medium';
                        tdDate.textContent = dateStr;

                        const tdMetodo = document.createElement('td');
                        tdMetodo.className = 'py-2 text-capitalize text-muted';
                        tdMetodo.textContent = p.metodo_pago || '';

                        const tdEstado = document.createElement('td');
                        tdEstado.className = 'py-2';
                        tdEstado.appendChild(estadoSpan);

                        const tdNotes = document.createElement('td');
                        tdNotes.className = 'py-2 text-muted text-truncate';
                        tdNotes.style.maxWidth = '250px';
                        tdNotes.title = p.notes || p.notas || '-';
                        tdNotes.textContent = p.notes || p.notas || '-';

                        const montoNumber = Number.parseFloat(p.monto || 0);
                        const formatMonto = Number.isFinite(montoNumber) ? montoNumber.toFixed(2) : '0.00';

                        const tdMonto = document.createElement('td');
                        tdMonto.className = 'py-2 text-end fw-bold text-dark pe-3';
                        tdMonto.textContent = 'S/. ' + formatMonto;

                        tr.appendChild(tdDate);
                        tr.appendChild(tdMetodo);
                        tr.appendChild(tdEstado);
                        tr.appendChild(tdNotes);
                        tr.appendChild(tdMonto);

                        tbody.appendChild(tr);
                    });
                }

                // Re-initialize lucide icons inside modal if needed
                if (window.lucide) {
                    window.lucide.createIcons();
                }
            });
        });

        // Quick Payment Register Trigger
        const quickPagoBtns = document.querySelectorAll('.register-pago-quick-btn');
        quickPagoBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const pacienteId = this.getAttribute('data-paciente-id');
                const monto = this.getAttribute('data-monto');
                
                const selectPac = document.getElementById('create_paciente_id');
                if (selectPac) {
                    if (selectPac.tomselect) {
                        selectPac.tomselect.setValue(pacienteId);
                    } else {
                        selectPac.value = pacienteId;
                        selectPac.dispatchEvent(new Event('change'));
                    }
                }
                
                const inputMonto = document.getElementById('create_pago_monto');
                if (inputMonto) {
                    inputMonto.value = parseFloat(monto).toFixed(2);
                }

                const selectEstado = document.getElementById('create_pago_estado');
                if (selectEstado) {
                    selectEstado.value = 'pagado';
                }
            });
        });

        // Initialize TomSelect on dropdowns for better searching
        const selectSelectors = [
            '#create_paciente_id', '#create_gasto_categoria', '#create_gasto_metodo', '#create_pago_metodo',
            '#edit_paciente_id', '#edit_gasto_categoria', '#edit_gasto_metodo', '#edit_pago_metodo'
        ];
        
        selectSelectors.forEach(selector => {
            const el = document.querySelector(selector);
            if (el) {
                new TomSelect(el, {
                    create: false,
                    sortField: { field: "text", direction: "asc" },
                    controlInput: '<input autocomplete="off">'
                });
            }
        });

        // Sync Axios silently via AJAX for Finanzas
        document.body.addEventListener('miradent:form-success', async function(e) {
            try {
                const response = await fetch(window.location.href, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                });
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const currentContainer = document.querySelector('.finance-shell');
                const newContainer = doc.querySelector('.finance-shell');
                
                if (currentContainer && newContainer) {
                    // Solo actualizamos el interior para no perder los modales que están fuera o eventos adjuntos al shell (si los hay)
                    currentContainer.innerHTML = newContainer.innerHTML;
                    
                    // Re-bind all scripts specifically for Finanzas UI (modals, tomselect, etc)
                    bindFinanzasEvents();
                }
            } catch (err) {
                console.error('Failed to sync finanzas view:', err);
                if (typeof showMiradentAlert === 'function') {
                    showMiradentAlert('Fallo al refrescar la vista de finanzas', 'warning');
                }
            }
        });

        function bindFinanzasEvents() {
            // Rebind Modal populations
            document.querySelectorAll('.edit-pago-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const pacienteId = this.getAttribute('data-paciente-id');
                    const citaId = this.getAttribute('data-cita-id');
                    const monto = this.getAttribute('data-monto');
                    const metodo = this.getAttribute('data-metodo-pago');
                    const fecha = this.getAttribute('data-fecha-pago');
                    const estado = this.getAttribute('data-estado');
                    const notas = this.getAttribute('data-notas');
                    const url = this.getAttribute('data-update-url');

                    document.getElementById('editPagoForm').action = url;

                    document.getElementById('edit_paciente_id').value = pacienteId;
                    if (document.getElementById('edit_paciente_id').tomselect) {
                        document.getElementById('edit_paciente_id').tomselect.setValue(pacienteId, true);
                    }

                    const appointmentSelect = document.getElementById('edit_cita_id');
                    if (appointmentSelect) {
                        appointmentSelect.querySelectorAll('option').forEach(opt => {
                            const optPatientId = opt.getAttribute('data-paciente-id');
                            opt.style.display = (optPatientId === 'all' || optPatientId === pacienteId) ? 'block' : 'none';
                        });
                        appointmentSelect.value = citaId;
                    }

                    document.getElementById('edit_monto').value = monto;

                    document.getElementById('edit_metodo').value = metodo ? metodo.toLowerCase() : '';
                    if (document.getElementById('edit_metodo').tomselect) {
                        document.getElementById('edit_metodo').tomselect.setValue(metodo ? metodo.toLowerCase() : '', true);
                    }

                    document.getElementById('edit_fecha_pago').value = fecha ? fecha.substring(0, 16) : '';
                    document.getElementById('edit_estado').value = estado;
                    document.getElementById('edit_notas').value = notas ?? '';
                });
            });

            document.querySelectorAll('.edit-gasto-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const monto = this.getAttribute('data-monto');
                    const categoria = this.getAttribute('data-categoria');
                    const metodo = this.getAttribute('data-metodo');
                    const fecha = this.getAttribute('data-fecha');
                    const comprobante = this.getAttribute('data-comprobante');
                    const url = this.getAttribute('data-update-url');

                    document.getElementById('editGastoForm').action = url;
                    document.getElementById('edit_gasto_monto').value = monto;
                    document.getElementById('edit_gasto_categoria').value = categoria;
                    if (document.getElementById('edit_gasto_categoria').tomselect) {
                        document.getElementById('edit_gasto_categoria').tomselect.setValue(categoria, true);
                    }
                    
                    document.getElementById('edit_gasto_metodo').value = metodo.toLowerCase();
                    if (document.getElementById('edit_gasto_metodo').tomselect) {
                        document.getElementById('edit_gasto_metodo').tomselect.setValue(metodo.toLowerCase(), true);
                    }
                    document.getElementById('edit_gasto_fecha').value = fecha;
                    document.getElementById('edit_gasto_comprobante').value = comprobante ?? '';
                });
            });

            document.querySelectorAll('.show-cliente-history-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const nombre = this.getAttribute('data-nombre');
                    const pagos = JSON.parse(this.getAttribute('data-pagos') || '[]');
                    
                    document.getElementById('history_cliente_nombre').textContent = nombre;
                    
                    const tbody = document.getElementById('history_pagos_tbody');
                    const noPagosMsg = document.getElementById('history_no_pagos_msg');
                    const tableContainer = document.getElementById('history_pagos_container');
                    
                    tbody.innerHTML = '';
                    
                    if (pagos.length === 0) {
                        tableContainer.style.display = 'none';
                        noPagosMsg.style.display = 'block';
                    } else {
                        tableContainer.style.display = 'block';
                        noPagosMsg.style.display = 'none';
                        
                        pagos.forEach(p => {
                            const tr = document.createElement('tr');
                            tr.style.fontSize = '0.85rem';
                            
                            let dateStr = p.fecha_pago;
                            try {
                                const date = new Date(p.fecha_pago);
                                const day = String(date.getDate()).padStart(2, '0');
                                const month = String(date.getMonth() + 1).padStart(2, '0');
                                const year = date.getFullYear();
                                dateStr = `${day}/${month}/${year}`;
                            } catch(e) {}
                            
                            const estadoSpan = document.createElement('span');
                            estadoSpan.className = 'badge text-uppercase fw-semibold';
                            estadoSpan.style.fontSize = '0.65rem';
                            estadoSpan.style.padding = '3px 8px';
                            estadoSpan.style.borderRadius = '6px';

                            if (p.estado === 'pagado') {
                                estadoSpan.style.backgroundColor = 'var(--primary-light)';
                                estadoSpan.style.color = 'var(--primary-hover)';
                                estadoSpan.textContent = 'PAGADO';
                            } else if (p.estado === 'parcial') {
                                estadoSpan.style.backgroundColor = '#f2faf6';
                                estadoSpan.style.color = '#92400e';
                                estadoSpan.textContent = 'PARCIAL';
                            } else {
                                estadoSpan.style.backgroundColor = '#f2faf6';
                                estadoSpan.style.color = '#0e301e';
                                estadoSpan.textContent = 'PENDIENTE';
                            }
                            
                            const tdDate = document.createElement('td');
                            tdDate.className = 'py-2 ps-3 fw-medium';
                            tdDate.textContent = dateStr;

                            const tdMetodo = document.createElement('td');
                            tdMetodo.className = 'py-2 text-capitalize text-muted';
                            tdMetodo.textContent = p.metodo_pago || '';

                            const tdEstado = document.createElement('td');
                            tdEstado.className = 'py-2';
                            tdEstado.appendChild(estadoSpan);

                            const tdNotes = document.createElement('td');
                            tdNotes.className = 'py-2 text-muted text-truncate';
                            tdNotes.style.maxWidth = '250px';
                            tdNotes.title = p.notes || p.notas || '-';
                            tdNotes.textContent = p.notes || p.notas || '-';

                            const montoNumber = Number.parseFloat(p.monto || 0);
                            const formatMonto = Number.isFinite(montoNumber) ? montoNumber.toFixed(2) : '0.00';

                            const tdMonto = document.createElement('td');
                            tdMonto.className = 'py-2 text-end fw-bold text-dark pe-3';
                            tdMonto.textContent = 'S/. ' + formatMonto;

                            tr.appendChild(tdDate);
                            tr.appendChild(tdMetodo);
                            tr.appendChild(tdEstado);
                            tr.appendChild(tdNotes);
                            tr.appendChild(tdMonto);

                            tbody.appendChild(tr);
                        });
                    }

                    if (window.lucide) {
                        window.lucide.createIcons();
                    }
                });
            });

            document.querySelectorAll('.register-pago-quick-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const pacienteId = this.getAttribute('data-paciente-id');
                    const monto = this.getAttribute('data-monto');
                    
                    const selectPac = document.getElementById('create_paciente_id');
                    if (selectPac) {
                        if (selectPac.tomselect) {
                            selectPac.tomselect.setValue(pacienteId);
                        } else {
                            selectPac.value = pacienteId;
                            selectPac.dispatchEvent(new Event('change'));
                        }
                    }
                    
                    const inputMonto = document.getElementById('create_pago_monto');
                    if (inputMonto) {
                        inputMonto.value = parseFloat(monto).toFixed(2);
                    }

                    const selectEstado = document.getElementById('create_pago_estado');
                    if (selectEstado) {
                        selectEstado.value = 'pagado';
                    }
                });
            });

            if (typeof lucide !== 'undefined') lucide.createIcons();
        }

    });
</script>
@endsection
@endsection
