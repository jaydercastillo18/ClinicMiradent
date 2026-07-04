<?php $__env->startSection('title', 'Expediente Médico'); ?>

<?php
    $nombreCompleto = trim($paciente->nombre . ' ' . $paciente->apellido);
    $iniciales = strtoupper(substr($paciente->nombre, 0, 1) . substr($paciente->apellido, 0, 1));
    $edad = $paciente->fecha_nacimiento ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age : null;
    $alergias = trim((string) $paciente->alergias);
    $alergiasNormalizadas = strtolower($alergias);
    $tieneAlergias = $alergias !== '' && !in_array($alergiasNormalizadas, ['ninguna', 'ninguno', 'no', 'sin alergias'], true);
    $totalCitas = $citas->count();
    $citasCompletadas = $citas->where('estado', 'completada')->count();
    $ultimaCita = $citas->first();
    $proximaCita = $citas
        ->filter(fn ($cita) => $cita->fecha_hora && $cita->fecha_hora->isFuture())
        ->sortBy('fecha_hora')
        ->first();
    $totalPagos = $pagos->sum(fn ($pago) => (float) $pago->monto);
    $ultimoPago = $pagos->first();
    $estadoCitaLabels = [
        'pendiente' => 'Pendiente',
        'confirmada' => 'Confirmada',
        'completada' => 'Completada',
        'cancelada' => 'Cancelada',
        'en_espera' => 'En espera',
    ];
    $estadoPagoLabels = [
        'pendiente' => 'Pendiente',
        'parcial' => 'Parcial',
        'pagado' => 'Pagado',
        'reembolsado' => 'Reembolsado',
    ];
?>

<?php $__env->startSection('styles'); ?>
<style>
    .record-shell {
        --record-ink: #0f172a;
        --record-muted: #64748b;
        --record-soft: #f8fafc;
        --record-line: #dbe7ee;
        --record-primary: var(--primary, #00a884);
        --record-primary-dark: var(--primary-hover, #00876a);
        --record-primary-soft: #e8fbf6;
        max-width: 1280px;
        margin: 0 auto;
        color: var(--record-ink);
    }

    .record-hero {
        display: flex;
        align-items: stretch;
        justify-content: space-between;
        gap: 22px;
        padding: 22px;
        border: 1px solid #cceee6;
        border-radius: 8px;
        background:
            linear-gradient(135deg, rgba(0, 168, 132, 0.12), rgba(13, 151, 165, 0.06)),
            #ffffff;
        box-shadow: 0 12px 32px rgba(6, 61, 107, 0.08);
        margin-bottom: 16px;
    }

    .record-hero-main {
        display: flex;
        align-items: center;
        min-width: 0;
        gap: 16px;
    }

    .record-avatar {
        width: 72px;
        height: 72px;
        border-radius: 8px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        color: #005943;
        background: linear-gradient(135deg, #d7fbf2, #b8ecff);
        border: 1px solid rgba(0, 168, 132, 0.28);
        font: 800 1.45rem/1 'Outfit', sans-serif;
        box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.72);
    }

    .record-kicker {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        width: fit-content;
        padding: 5px 9px;
        border-radius: 999px;
        background: #ffffff;
        color: var(--record-primary-dark);
        border: 1px solid rgba(0, 168, 132, 0.2);
        font-size: 0.68rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .record-title {
        margin: 0;
        color: var(--record-ink);
        font: 800 1.85rem/1.05 'Outfit', sans-serif;
        letter-spacing: 0;
    }

    .record-subtitle {
        color: var(--record-muted);
        font-size: 0.9rem;
        margin: 6px 0 0;
    }

    .record-hero-actions {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .record-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 38px;
        padding: 9px 13px;
        border-radius: 8px;
        border: 1px solid #cfe1e8;
        background: #ffffff;
        color: #164057;
        font-weight: 800;
        font-size: 0.82rem;
        text-decoration: none;
        white-space: nowrap;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease, background 0.2s ease;
    }

    .record-btn:hover {
        transform: translateY(-1px);
        border-color: #a8cbd7;
        color: #0f2f42;
        box-shadow: 0 10px 22px rgba(6, 61, 107, 0.08);
    }

    .record-btn.primary {
        background: var(--record-primary);
        border-color: var(--record-primary);
        color: #ffffff;
        box-shadow: 0 10px 22px rgba(0, 168, 132, 0.22);
    }

    .record-btn.primary:hover {
        background: var(--record-primary-dark);
        color: #ffffff;
    }

    .clinical-alert {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 13px 16px;
        margin-bottom: 16px;
        border-radius: 8px;
        border: 1px solid #fecaca;
        background: linear-gradient(135deg, #fff1f2, #fff7f7);
        color: #991b1b;
    }

    .clinical-alert-icon {
        width: 34px;
        height: 34px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        border-radius: 8px;
        background: #fee2e2;
        color: #dc2626;
    }

    .clinical-alert strong {
        display: block;
        font-size: 0.76rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .clinical-alert span {
        display: block;
        margin-top: 2px;
        font-weight: 700;
        font-size: 0.92rem;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 18px;
    }

    .summary-card {
        min-height: 96px;
        padding: 16px;
        border-radius: 8px;
        border: 1px solid var(--record-line);
        background: #ffffff;
        box-shadow: 0 8px 22px rgba(6, 61, 107, 0.05);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .summary-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        color: var(--record-muted);
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .summary-icon {
        width: 30px;
        height: 30px;
        display: grid;
        place-items: center;
        border-radius: 8px;
        background: var(--record-primary-soft);
        color: var(--record-primary-dark);
        flex: 0 0 auto;
    }

    .summary-value {
        margin-top: 12px;
        color: var(--record-ink);
        font: 800 1.25rem/1.15 'Outfit', sans-serif;
    }

    .summary-note {
        color: var(--record-muted);
        font-size: 0.78rem;
        margin-top: 4px;
        line-height: 1.35;
    }

    .record-layout {
        display: grid;
        grid-template-columns: minmax(290px, 360px) minmax(0, 1fr);
        gap: 16px;
        align-items: start;
    }

    .record-stack {
        display: grid;
        gap: 14px;
    }

    .record-panel {
        border: 1px solid var(--record-line);
        border-radius: 8px;
        background: #ffffff;
        box-shadow: 0 10px 26px rgba(6, 61, 107, 0.05);
        overflow: hidden;
    }

    .record-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 16px;
        border-bottom: 1px solid #e7eef3;
        background: linear-gradient(180deg, #ffffff, #f8fbfc);
    }

    .record-panel-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0;
        color: var(--record-ink);
        font: 800 0.95rem/1.2 'Outfit', sans-serif;
    }

    .record-panel-body {
        padding: 16px;
    }

    .profile-list {
        display: grid;
        gap: 11px;
    }

    .profile-item {
        display: grid;
        grid-template-columns: 30px minmax(0, 1fr);
        gap: 10px;
        align-items: start;
    }

    .profile-icon {
        width: 30px;
        height: 30px;
        display: grid;
        place-items: center;
        border-radius: 8px;
        background: var(--record-primary-soft);
        color: var(--record-primary-dark);
    }

    .label {
        display: block;
        color: var(--record-muted);
        font-size: 0.66rem;
        font-weight: 800;
        letter-spacing: 0.07em;
        line-height: 1;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .value {
        display: block;
        color: var(--record-ink);
        font-size: 0.88rem;
        font-weight: 700;
        line-height: 1.35;
        overflow-wrap: anywhere;
    }

    .vitals-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        border: 1px solid #d7e9ef;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 14px;
        background: #ffffff;
    }

    .vital-item {
        padding: 11px 10px;
        background: #fbfdfe;
        border-right: 1px solid #d7e9ef;
    }

    .vital-item:last-child {
        border-right: 0;
    }

    .vital-value {
        color: var(--record-ink);
        font: 800 0.95rem/1.1 'Outfit', sans-serif;
    }

    .note-list {
        display: grid;
        gap: 10px;
    }

    .note-block {
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #e3edf2;
        background: #fbfdfe;
    }

    .note-block.warning {
        border-color: #fecaca;
        background: #fff7f7;
    }

    .note-text {
        color: #334155;
        font-size: 0.85rem;
        line-height: 1.45;
        margin: 0;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 8px;
    }

    .quick-action {
        min-height: 42px;
        padding: 9px 8px;
        border-radius: 8px;
        border: 1px solid #cfe1e8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        color: #164057;
        background: #ffffff;
        font-weight: 800;
        font-size: 0.78rem;
        text-decoration: none;
        white-space: nowrap;
    }

    .quick-action.primary {
        color: #ffffff;
        background: var(--record-primary);
        border-color: var(--record-primary);
    }

    .quick-action.success {
        color: #047857;
        border-color: #9ee7cd;
        background: #f0fdf8;
    }

    .content-card {
        padding: 16px;
    }

    .tabbar {
        display: flex;
        align-items: center;
        gap: 6px;
        width: fit-content;
        padding: 4px;
        border-radius: 8px;
        background: #eef6f7;
        border: 1px solid #d8eef2;
        margin-bottom: 12px;
    }

    .tabbar .nav-link {
        min-height: 36px;
        padding: 8px 13px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #537286;
        font-size: 0.82rem;
        font-weight: 800;
        border: 0;
        background: transparent;
    }

    .tabbar .nav-link.active {
        color: var(--record-primary-dark);
        background: #ffffff;
        box-shadow: 0 5px 14px rgba(6, 61, 107, 0.08);
    }

    .section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .section-heading h2 {
        margin: 0;
        color: var(--record-ink);
        font: 800 1rem/1.2 'Outfit', sans-serif;
    }

    .section-heading span {
        color: var(--record-muted);
        font-size: 0.78rem;
        font-weight: 700;
    }

    .timeline {
        position: relative;
        display: grid;
        gap: 13px;
        padding-left: 27px;
    }

    .timeline::before {
        content: "";
        position: absolute;
        left: 8px;
        top: 9px;
        bottom: 9px;
        width: 2px;
        background: linear-gradient(180deg, var(--record-primary), #dbe7ee);
    }

    .timeline-item {
        position: relative;
    }

    .timeline-dot {
        position: absolute;
        left: -24px;
        top: 18px;
        width: 14px;
        height: 14px;
        border: 3px solid var(--record-primary);
        border-radius: 50%;
        background: #ffffff;
        box-shadow: 0 0 0 4px #ffffff;
        z-index: 2;
    }

    .timeline-card {
        border: 1px solid var(--record-line);
        border-radius: 8px;
        background: #ffffff;
        padding: 14px 15px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .timeline-card:hover {
        border-color: #b6d8e3;
        box-shadow: 0 12px 24px rgba(6, 61, 107, 0.07);
        transform: translateY(-1px);
    }

    .timeline-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 10px;
    }

    .timeline-date {
        color: var(--record-ink);
        font: 800 0.92rem/1.25 'Outfit', sans-serif;
    }

    .timeline-service {
        display: flex;
        align-items: center;
        gap: 7px;
        color: var(--record-primary-dark);
        font-weight: 800;
        font-size: 0.86rem;
        margin-top: 4px;
    }

    .detail-grid {
        display: grid;
        gap: 8px;
        padding: 11px;
        border-radius: 8px;
        background: var(--record-soft);
        color: #475569;
        font-size: 0.82rem;
        line-height: 1.42;
    }

    .detail-grid strong {
        color: #1f3a4d;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 24px;
        padding: 5px 9px;
        border-radius: 999px;
        font-size: 0.68rem;
        font-weight: 900;
        line-height: 1;
        white-space: nowrap;
        text-transform: uppercase;
    }

    .status-completada,
    .status-pagado {
        background: #dcfce7;
        color: #166534;
    }

    .status-confirmada {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-pendiente,
    .status-parcial,
    .status-en_espera {
        background: #fef3c7;
        color: #92400e;
    }

    .status-cancelada,
    .status-reembolsado {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-default {
        background: #e2e8f0;
        color: #475569;
    }

    .timeline-dot.status-completada {
        border-color: #22c55e;
    }

    .timeline-dot.status-confirmada {
        border-color: #3b82f6;
    }

    .timeline-dot.status-pendiente,
    .timeline-dot.status-en_espera {
        border-color: #f59e0b;
    }

    .timeline-dot.status-cancelada {
        border-color: #ef4444;
        background: #ef4444;
    }

    .empty-state {
        display: grid;
        place-items: center;
        min-height: 210px;
        text-align: center;
        color: var(--record-muted);
        border: 1px dashed #bfd8e1;
        border-radius: 8px;
        background: #fbfdfe;
        padding: 28px;
    }

    .empty-state i,
    .empty-state svg {
        color: #9bb5c3;
        margin-bottom: 10px;
    }

    .payments-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
        white-space: nowrap;
    }

    .payments-table th {
        color: var(--record-muted);
        font-size: 0.7rem;
        font-weight: 900;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        padding: 0 12px 4px;
    }

    .payments-table td {
        padding: 13px 12px;
        background: #ffffff;
        border-top: 1px solid var(--record-line);
        border-bottom: 1px solid var(--record-line);
        color: #334155;
        font-size: 0.86rem;
        vertical-align: middle;
    }

    .payments-table td:first-child {
        border-left: 1px solid var(--record-line);
        border-radius: 8px 0 0 8px;
    }

    .payments-table td:last-child {
        border-right: 1px solid var(--record-line);
        border-radius: 0 8px 8px 0;
    }

    .payment-method {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #164057;
        font-weight: 800;
    }

    .money {
        color: var(--record-ink);
        font: 800 0.98rem/1 'Outfit', sans-serif;
        white-space: nowrap;
    }

    @media (max-width: 1100px) {
        .summary-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 960px) {
        .record-hero,
        .record-hero-main {
            align-items: flex-start;
        }

        .record-hero {
            flex-direction: column;
        }

        .record-hero-actions {
            justify-content: flex-start;
            width: 100%;
        }

        .record-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .record-hero {
            padding: 16px;
        }

        .record-avatar {
            width: 58px;
            height: 58px;
            font-size: 1.15rem;
        }

        .record-title {
            font-size: 1.45rem;
        }

        .summary-grid,
        .quick-actions,
        .vitals-grid {
            grid-template-columns: 1fr;
        }

        .vital-item {
            border-right: 0;
            border-bottom: 1px solid #d7e9ef;
        }

        .vital-item:last-child {
            border-bottom: 0;
        }

        .tabbar {
            width: 100%;
        }

        .tabbar .nav-item,
        .tabbar .nav-link {
            flex: 1 1 0;
        }

        .timeline-top {
            flex-direction: column;
            gap: 8px;
        }

        .payments-table,
        .payments-table thead,
        .payments-table tbody,
        .payments-table tr,
        .payments-table td {
            display: block;
            width: 100%;
        }

        .payments-table thead {
            display: none;
        }

        .payments-table tr {
            border: 1px solid var(--record-line);
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 10px;
            background: #ffffff;
        }

        .payments-table td {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            border: 0;
            border-radius: 0 !important;
            padding: 10px 12px;
        }

        .payments-table td::before {
            content: attr(data-label);
            color: var(--record-muted);
            font-size: 0.68rem;
            font-weight: 900;
            letter-spacing: 0.07em;
            text-transform: uppercase;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="record-shell">
    <section class="record-hero" aria-label="Cabecera del expediente">
        <div class="record-hero-main">
            <div class="record-avatar" aria-hidden="true"><?php echo e($iniciales); ?></div>
            <div>
                <div class="record-kicker">
                    <i data-lucide="folder-heart" style="width: 13px; height: 13px;"></i>
                    Ficha clínica
                </div>
                <h1 class="record-title">Expediente Médico</h1>
                <p class="record-subtitle">Historial integral de <strong><?php echo e($nombreCompleto); ?></strong>.</p>
            </div>
        </div>

        <div class="record-hero-actions">
            <a href="<?php echo e(route('pacientes.index')); ?>" class="record-btn">
                <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
                Volver
            </a>
            <a href="<?php echo e(route('pacientes.edit', $paciente->id)); ?>" class="record-btn primary">
                <i data-lucide="edit-3" style="width: 16px; height: 16px;"></i>
                Editar
            </a>
        </div>
    </section>

    <?php if($tieneAlergias): ?>
        <div class="clinical-alert" role="alert">
            <div class="clinical-alert-icon">
                <i data-lucide="shield-alert" style="width: 20px; height: 20px;"></i>
            </div>
            <div>
                <strong>Alerta médica: alergias</strong>
                <span><?php echo e($paciente->alergias); ?></span>
            </div>
        </div>
    <?php endif; ?>

    <section class="summary-grid" aria-label="Resumen del expediente">
        <article class="summary-card">
            <div class="summary-top">
                <span>Citas</span>
                <span class="summary-icon"><i data-lucide="calendar-check" style="width: 16px; height: 16px;"></i></span>
            </div>
            <div>
                <div class="summary-value"><?php echo e($totalCitas); ?></div>
                <div class="summary-note"><?php echo e($citasCompletadas); ?> completada<?php echo e($citasCompletadas === 1 ? '' : 's'); ?></div>
            </div>
        </article>

        <article class="summary-card">
            <div class="summary-top">
                <span>Última cita</span>
                <span class="summary-icon"><i data-lucide="clock" style="width: 16px; height: 16px;"></i></span>
            </div>
            <div>
                <div class="summary-value"><?php echo e($ultimaCita?->fecha_hora?->format('d M Y') ?? 'Sin citas'); ?></div>
                <div class="summary-note"><?php echo e($ultimaCita?->servicio?->nombre ?? 'Aún no registra atención'); ?></div>
            </div>
        </article>

        <article class="summary-card">
            <div class="summary-top">
                <span>Pagos</span>
                <span class="summary-icon"><i data-lucide="wallet" style="width: 16px; height: 16px;"></i></span>
            </div>
            <div>
                <div class="summary-value">S/ <?php echo e(number_format($totalPagos, 2)); ?></div>
                <div class="summary-note"><?php echo e($pagos->count()); ?> movimiento<?php echo e($pagos->count() === 1 ? '' : 's'); ?> registrado<?php echo e($pagos->count() === 1 ? '' : 's'); ?></div>
            </div>
        </article>

        <article class="summary-card">
            <div class="summary-top">
                <span>Próxima cita</span>
                <span class="summary-icon"><i data-lucide="calendar-days" style="width: 16px; height: 16px;"></i></span>
            </div>
            <div>
                <div class="summary-value"><?php echo e($proximaCita?->fecha_hora?->format('d M Y') ?? 'Sin programar'); ?></div>
                <div class="summary-note"><?php echo e($proximaCita?->fecha_hora?->format('h:i A') ?? 'Agenda libre para seguimiento'); ?></div>
            </div>
        </article>
    </section>

    <div class="record-layout">
        <aside class="record-stack" aria-label="Datos del paciente">
            <section class="record-panel">
                <div class="record-panel-header">
                    <h2 class="record-panel-title">
                        <i data-lucide="user-round" style="width: 17px; height: 17px; color: var(--primary);"></i>
                        Paciente
                    </h2>
                </div>

                <div class="record-panel-body">
                    <div class="vitals-grid">
                        <div class="vital-item">
                            <span class="label">Edad</span>
                            <span class="vital-value"><?php echo e($edad ?? '--'); ?></span>
                        </div>
                        <div class="vital-item">
                            <span class="label">Sangre</span>
                            <span class="vital-value"><?php echo e($paciente->tipo_sangre ?? 'N/R'); ?></span>
                        </div>
                        <div class="vital-item">
                            <span class="label">Género</span>
                            <span class="vital-value"><?php echo e($paciente->genero ?? '--'); ?></span>
                        </div>
                    </div>

                    <div class="profile-list">
                        <div class="profile-item">
                            <span class="profile-icon"><i data-lucide="badge-check" style="width: 15px; height: 15px;"></i></span>
                            <span>
                                <span class="label">Documento</span>
                                <span class="value">DNI: <?php echo e($paciente->dni ?? 'Sin registrar'); ?></span>
                            </span>
                        </div>
                        <div class="profile-item">
                            <span class="profile-icon"><i data-lucide="phone" style="width: 15px; height: 15px;"></i></span>
                            <span>
                                <span class="label">Teléfono</span>
                                <span class="value"><?php echo e($paciente->telefono ?? 'Sin registrar'); ?></span>
                            </span>
                        </div>
                        <div class="profile-item">
                            <span class="profile-icon"><i data-lucide="mail" style="width: 15px; height: 15px;"></i></span>
                            <span>
                                <span class="label">Correo</span>
                                <span class="value"><?php echo e($paciente->email ?? 'Sin registrar'); ?></span>
                            </span>
                        </div>
                        <div class="profile-item">
                            <span class="profile-icon"><i data-lucide="map-pin" style="width: 15px; height: 15px;"></i></span>
                            <span>
                                <span class="label">Dirección</span>
                                <span class="value"><?php echo e($paciente->direccion ?? 'Sin registrar'); ?></span>
                            </span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="record-panel">
                <div class="record-panel-header">
                    <h2 class="record-panel-title">
                        <i data-lucide="clipboard-list" style="width: 17px; height: 17px; color: var(--primary);"></i>
                        Datos clínicos
                    </h2>
                </div>

                <div class="record-panel-body">
                    <div class="note-list">
                        <div class="note-block">
                            <span class="label">Antecedentes médicos</span>
                            <p class="note-text"><?php echo e($paciente->antecedentes_medicos ?? 'Ninguno reportado.'); ?></p>
                        </div>
                        <div class="note-block">
                            <span class="label">Medicamentos habituales</span>
                            <p class="note-text"><?php echo e($paciente->medicamentos_habituales ?? 'Ninguno reportado.'); ?></p>
                        </div>
                        <div class="note-block <?php echo e($tieneAlergias ? 'warning' : ''); ?>">
                            <span class="label">Alergias</span>
                            <p class="note-text"><?php echo e($paciente->alergias ?: 'Ninguna registrada.'); ?></p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="record-panel">
                <div class="record-panel-header">
                    <h2 class="record-panel-title">
                        <i data-lucide="siren" style="width: 17px; height: 17px; color: var(--primary);"></i>
                        Emergencia
                    </h2>
                </div>

                <div class="record-panel-body">
                    <?php if($paciente->contacto_emergencia_nombre): ?>
                        <div class="profile-list">
                            <div class="profile-item">
                                <span class="profile-icon"><i data-lucide="user" style="width: 15px; height: 15px;"></i></span>
                                <span>
                                    <span class="label">Contacto</span>
                                    <span class="value"><?php echo e($paciente->contacto_emergencia_nombre); ?></span>
                                </span>
                            </div>
                            <div class="profile-item">
                                <span class="profile-icon"><i data-lucide="heart-handshake" style="width: 15px; height: 15px;"></i></span>
                                <span>
                                    <span class="label">Relación</span>
                                    <span class="value"><?php echo e($paciente->contacto_emergencia_parentesco ?? 'Familiar'); ?></span>
                                </span>
                            </div>
                            <div class="profile-item">
                                <span class="profile-icon"><i data-lucide="phone-call" style="width: 15px; height: 15px;"></i></span>
                                <span>
                                    <span class="label">Teléfono</span>
                                    <span class="value"><?php echo e($paciente->contacto_emergencia_telefono ?? '--'); ?></span>
                                </span>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="note-text">No registrado.</p>
                    <?php endif; ?>
                </div>
            </section>

            <nav class="quick-actions" aria-label="Acciones rápidas">
                <a href="<?php echo e(route('citas.index', ['paciente_id' => $paciente->id])); ?>" class="quick-action primary">
                    <i data-lucide="calendar-plus" style="width: 15px; height: 15px;"></i>
                    Cita
                </a>
                <a href="<?php echo e(route('pagos.index', ['paciente_id' => $paciente->id])); ?>" class="quick-action success">
                    <i data-lucide="dollar-sign" style="width: 15px; height: 15px;"></i>
                    Pago
                </a>
                <a href="<?php echo e(route('pacientes.ficha-pdf', $paciente->id)); ?>" target="_blank" class="quick-action">
                    <i data-lucide="printer" style="width: 15px; height: 15px;"></i>
                    PDF
                </a>
            </nav>
        </aside>

        <section aria-label="Historial del paciente">
            <ul class="nav tabbar" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-history-tab" data-ui-toggle="pill" data-ui-target="#pills-history" type="button" role="tab" aria-selected="true">
                        <i data-lucide="activity" style="width: 15px; height: 15px;"></i>
                        Evolución
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-payments-tab" data-ui-toggle="pill" data-ui-target="#pills-payments" type="button" role="tab" aria-selected="false">
                        <i data-lucide="receipt" style="width: 15px; height: 15px;"></i>
                        Pagos
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <section class="tab-pane fade show active" id="pills-history" role="tabpanel" aria-labelledby="pills-history-tab">
                    <div class="record-panel content-card">
                        <div class="section-heading">
                            <h2>Línea de tiempo clínico</h2>
                            <span><?php echo e($totalCitas); ?> registro<?php echo e($totalCitas === 1 ? '' : 's'); ?></span>
                        </div>

                        <?php if($citas->isEmpty()): ?>
                            <div class="empty-state">
                                <div>
                                    <i data-lucide="calendar-x" style="width: 34px; height: 34px;"></i>
                                    <p class="mb-0" style="font-weight: 700;">No hay citas registradas.</p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="timeline">
                                <?php $__currentLoopData = $citas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $estado = $cita->estado ?? 'default';
                                        $estadoClase = in_array($estado, ['completada', 'confirmada', 'pendiente', 'en_espera', 'cancelada'], true) ? $estado : 'default';
                                    ?>
                                    <article class="timeline-item">
                                        <span class="timeline-dot status-<?php echo e($estadoClase); ?>" aria-hidden="true"></span>
                                        <div class="timeline-card">
                                            <div class="timeline-top">
                                                <div>
                                                    <div class="timeline-date">
                                                        <?php echo e($cita->fecha_hora ? \Carbon\Carbon::parse($cita->fecha_hora)->format('d M Y') : 'Fecha pendiente'); ?>

                                                        <?php if($cita->fecha_hora): ?>
                                                            · <?php echo e(\Carbon\Carbon::parse($cita->fecha_hora)->format('h:i A')); ?>

                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="timeline-service">
                                                        <i data-lucide="stethoscope" style="width: 15px; height: 15px;"></i>
                                                        <?php echo e($cita->servicio?->nombre ?? 'Tratamiento sin servicio'); ?>

                                                    </div>
                                                </div>
                                                <span class="status-badge status-<?php echo e($estadoClase); ?>">
                                                    <?php echo e($estadoCitaLabels[$estado] ?? $estado); ?>

                                                </span>
                                            </div>

                                            <div class="detail-grid">
                                                <div><strong>Motivo:</strong> <?php echo e($cita->motivo ?: '--'); ?></div>
                                                <?php if($cita->diagnostico): ?>
                                                    <div><strong>Diagnóstico:</strong> <?php echo e($cita->diagnostico); ?></div>
                                                <?php endif; ?>
                                                <?php if($cita->notas_tratamiento): ?>
                                                    <div><strong>Notas:</strong> <?php echo e($cita->notas_tratamiento); ?></div>
                                                <?php endif; ?>
                                                <?php if($cita->doctora?->user?->name): ?>
                                                    <div><strong>Atendió:</strong> <?php echo e($cita->doctora->user->name); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </article>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <section class="tab-pane fade" id="pills-payments" role="tabpanel" aria-labelledby="pills-payments-tab">
                    <div class="record-panel content-card">
                        <div class="section-heading">
                            <h2>Registro de transacciones</h2>
                            <span><?php echo e($ultimoPago?->fecha_pago?->format('d/m/Y') ? 'Último pago: ' . $ultimoPago->fecha_pago->format('d/m/Y') : 'Sin pagos'); ?></span>
                        </div>

                        <?php if($pagos->isEmpty()): ?>
                            <div class="empty-state">
                                <div>
                                    <i data-lucide="wallet" style="width: 34px; height: 34px;"></i>
                                    <p class="mb-0" style="font-weight: 700;">No hay pagos registrados.</p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="payments-table">
                                    <thead>
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Método</th>
                                            <th>Tratamiento</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $pagos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pago): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $estadoPago = $pago->estado ?? 'default';
                                                $estadoPagoClase = in_array($estadoPago, ['pagado', 'parcial', 'pendiente', 'reembolsado'], true) ? $estadoPago : 'default';
                                            ?>
                                            <tr>
                                                <td data-label="Fecha"><?php echo e($pago->fecha_pago ? \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') : '--'); ?></td>
                                                <td data-label="Método">
                                                    <span class="payment-method">
                                                        <i data-lucide="credit-card" style="width: 14px; height: 14px;"></i>
                                                        <?php echo e($pago->metodo_pago ?? 'Sin método'); ?>

                                                    </span>
                                                </td>
                                                <td data-label="Tratamiento"><?php echo e($pago->cita?->servicio?->nombre ?? 'Pago general'); ?></td>
                                                <td data-label="Monto"><span class="money">S/ <?php echo e(number_format((float) $pago->monto, 2)); ?></span></td>
                                                <td data-label="Estado">
                                                    <span class="status-badge status-<?php echo e($estadoPagoClase); ?>">
                                                        <?php echo e($estadoPagoLabels[$estadoPago] ?? $estadoPago); ?>

                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </section>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.plantilla', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/historial.blade.php ENDPATH**/ ?>