<?php $__env->startSection('title', 'Horarios de Atención | Miradent'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .schedule-card {
        background: #ffffff;
        border: 1px solid rgba(0, 84, 66, 0.08);
        border-radius: 20px;
        padding: 20px 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        margin-bottom: 14px;
    }
    .schedule-card:hover {
        transform: scale(1.02) translateY(-2px);
        box-shadow: 0 15px 30px rgba(0, 168, 132, 0.1);
        border-color: var(--jade-200);
        z-index: 10;
        position: relative;
    }
    .schedule-card.is-today {
        background: linear-gradient(135deg, #ffffff, var(--jade-50));
        border: 2px solid var(--jade-400);
        box-shadow: 0 12px 30px rgba(0, 168, 132, 0.15);
    }
    .is-today-badge {
        font-size: 0.75rem;
        background: var(--jade-600);
        color: white;
        padding: 4px 12px;
        border-radius: 999px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-left: 12px;
        box-shadow: 0 4px 10px rgba(0, 168, 132, 0.3);
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 14px 28px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 1.05rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        background: #ffffff;
        border: 1px solid var(--jade-100);
    }
    .status-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        box-shadow: 0 0 12px currentColor;
    }
    .status-dot.open {
        background: #22c55e;
        color: #22c55e;
        animation: pulse-green 2s infinite;
    }
    .status-dot.closed {
        background: #ef4444;
        color: #ef4444;
    }
    @keyframes pulse-green {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.5); }
        70% { box-shadow: 0 0 0 12px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
    .btn-reservar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: var(--jade-600);
        color: #ffffff;
        padding: 18px 40px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 1.15rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 10px 25px rgba(0, 168, 132, 0.3);
    }
    .btn-reservar:hover {
        background: var(--jade-700);
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(0, 168, 132, 0.4);
    }

    /* Layout Classes para reemplazar Tailwind */
    .horarios-page-header {
        padding-top: 140px;
        padding-bottom: 48px;
        text-align: center;
    }
    .horarios-page-header h1 {
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--jade-950);
        margin: 20px 0 16px 0;
        font-family: 'Outfit', sans-serif;
    }
    .horarios-page-header p {
        font-size: 1.1rem;
        color: var(--jade-800);
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.6;
    }
    .horarios-container {
        padding-bottom: 80px;
        max-width: 700px;
        margin: 0 auto;
        padding-left: 20px;
        padding-right: 20px;
    }
    .status-badge-container {
        display: flex;
        justify-content: center;
        margin-bottom: 48px;
    }
    .schedule-day {
        font-weight: 800;
        font-size: 1.25rem;
        color: var(--jade-900);
        font-family: 'Outfit', sans-serif;
        display: flex;
        align-items: center;
    }
    .schedule-time {
        font-weight: 700;
        font-size: 1.125rem;
        color: var(--jade-700);
        background: var(--jade-50);
        padding: 8px 20px;
        border-radius: 12px;
        border: 1px solid var(--jade-100);
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .horarios-action {
        text-align: center;
        margin-top: 56px;
    }
    .alert-closed {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px 32px;
        background: #fef2f2;
        border: 1px solid #fee2e2;
        border-radius: 24px;
        color: #b91c1c;
        max-width: 512px;
        margin: 0 auto;
        text-align: left;
    }
    .alert-closed-icon {
        width: 48px;
        height: 48px;
        background: #ffffff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .alert-closed-title {
        font-weight: 800;
        font-size: 1.125rem;
        color: #7f1d1d;
        margin-bottom: 4px;
    }
    .alert-closed-text {
        font-weight: 500;
        font-size: 0.875rem;
        color: #b91c1c;
        opacity: 0.8;
    }
    .empty-schedule {
        text-align: center;
        padding: 64px 20px;
        background: #ffffff;
        border-radius: 32px;
        border: 1px solid var(--jade-100);
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .empty-schedule-icon {
        width: 80px;
        height: 80px;
        background: var(--jade-50);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px auto;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="horarios-page-header">
    <div class="container-premium text-center">
        <span class="badge-jade">Agenda tu visita</span>
        <h1>Horarios de Atención</h1>
        <p>Conoce nuestra disponibilidad. La Dra. <?php echo e($doctora->name ?: 'Miradent'); ?> te espera con calidez y la mejor tecnología.</p>
    </div>
</section>

<section class="horarios-container">
    <div class="container-premium">
        <?php if($estadoClinica['has_schedule'] ?? false): ?>
        <div class="status-badge-container fade-up">
            <div class="status-badge hover:scale-105 transition-transform cursor-default">
                <span class="status-dot <?php echo e($estadoClinica['open'] ? 'open' : 'closed'); ?>"></span>
                <span style="color: var(--jade-950);"><?php echo e($doctora->status_label); ?></span>
                <span style="color: var(--jade-300); font-weight: normal;">|</span>
                <span style="color: var(--jade-600); font-weight: 600;"><?php echo e($doctora->status_text); ?></span>
            </div>
        </div>
        <?php endif; ?>

        <?php if(!empty($doctora->horario_items)): ?>
        <div>
            <?php $__currentLoopData = $doctora->horario_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="schedule-card fade-up <?php echo e($item['day'] === $hoy ? 'is-today' : ''); ?>" <?php echo 'style="animation-delay: ' . ($loop->index * 0.05) . 's;"'; ?>>
                <div class="schedule-day">
                    <?php echo e($item['day']); ?>

                    <?php if($item['day'] === $hoy): ?>
                        <span class="is-today-badge">Hoy</span>
                    <?php endif; ?>
                </div>
                <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 6px;">
                    <div class="schedule-time"><?php echo e($item['start']); ?> — <?php echo e($item['end']); ?></div>
                    <?php if($item['has_turno2'] ?? false): ?>
                        <div class="schedule-time" style="font-size: 1rem;"><?php echo e($item['start2']); ?> — <?php echo e($item['end2']); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div class="empty-schedule fade-up">
            <div class="empty-schedule-icon">
                <i data-lucide="calendar-off" style="width:40px;height:40px; color:var(--jade-400);"></i>
            </div>
            <h3 style="font-size:1.5rem; font-weight:800; color:var(--jade-950); margin-bottom:8px; font-family:'Outfit', sans-serif;">Horarios no configurados</h3>
            <p style="font-size:1.125rem; color:var(--jade-600);">Contáctanos directamente por WhatsApp para consultar nuestra disponibilidad actual.</p>
        </div>
        <?php endif; ?>

        <div class="horarios-action fade-up" style="animation-delay: 0.4s;">
            <?php if($estadoClinica['open'] ?? false): ?>
                <a href="<?php echo e(route('public.reservar-cita')); ?>" class="btn-reservar">
                    <i data-lucide="calendar-check" style="width:24px;height:24px;"></i> Reservar cita ahora
                </a>
            <?php else: ?>
                <div class="alert-closed">
                    <div class="alert-closed-icon">
                        <i data-lucide="lock" style="width:24px;height:24px; color:#ef4444;"></i>
                    </div>
                    <div>
                        <div class="alert-closed-title">Citas deshabilitadas</div>
                        <div class="alert-closed-text">En este momento la clínica se encuentra cerrada. Podrás reservar cuando volvamos a abrir.</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/public_horarios.blade.php ENDPATH**/ ?>