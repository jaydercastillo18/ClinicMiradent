<?php $__env->startSection('title', 'Antes y Después | Miradent'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .compare-container {
        position: relative;
        width: 100%;
        aspect-ratio: 4/3;
        overflow: hidden;
        border-radius: 24px 24px 0 0;
        cursor: ew-resize;
        background: var(--jade-50);
    }
    
    .compare-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        pointer-events: none;
    }

    .compare-before-wrap {
        position: absolute;
        inset: 0;
        clip-path: inset(0 50% 0 0);
        z-index: 2;
    }

    .compare-handle {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        width: 4px;
        background: #ffffff;
        z-index: 10;
        transform: translateX(-50%);
        pointer-events: none;
        box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }

    .compare-handle-grip {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        background: #ffffff;
        border: 4px solid var(--jade-400);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--jade-600);
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .compare-badge {
        position: absolute;
        top: 16px;
        padding: 6px 16px;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
        color: #ffffff;
        font-size: 0.75rem;
        font-weight: 800;
        border-radius: 999px;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        z-index: 20;
        pointer-events: none;
    }

    .compare-badge.antes {
        left: 16px;
    }

    .compare-badge.despues {
        right: 16px;
    }

    .case-card {
        background: #ffffff;
        border: 1px solid rgba(0, 84, 66, 0.08);
        border-radius: 24px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 30px -10px rgba(0, 84, 66, 0.05);
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .case-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 168, 132, 0.1);
        border-color: var(--jade-200);
    }

    .btn-reservar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: var(--jade-600);
        color: #ffffff;
        padding: 18px 40px;
        border-radius: 999px;
        font-weight: 800;
        font-size: 1.1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 8px 20px rgba(0, 168, 132, 0.25);
    }
    
    .btn-reservar:hover {
        background: var(--jade-700);
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(0, 168, 132, 0.35);
    }

    /* Layout Classes para reemplazar Tailwind */
    .casos-page-header {
        padding-top: 140px;
        padding-bottom: 40px;
        text-align: center;
    }
    .casos-page-header h1 {
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--jade-950);
        margin: 20px 0 16px 0;
        font-family: 'Outfit', sans-serif;
    }
    .casos-page-header p {
        font-size: 1.1rem;
        color: var(--jade-800);
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.6;
    }
    .casos-grid-container {
        padding-bottom: 96px;
        max-width: 1152px;
        margin: 0 auto;
        padding-left: 20px;
        padding-right: 20px;
    }
    .casos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 40px;
    }
    .case-card-body {
        padding: 32px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex: 1;
    }
    .case-card-body h3 {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--jade-950);
        margin-bottom: 12px;
        font-family: 'Outfit', sans-serif;
    }
    .case-card-body p {
        font-size: 1rem;
        color: var(--jade-700);
        line-height: 1.6;
    }
    .casos-action {
        text-align: center;
        margin-top: 64px;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section class="casos-page-header">
    <div class="container-premium text-center">
        <span class="badge-jade">Resultados reales</span>
        <h1>Antes y Después</h1>
        <p>Pasa el cursor por encima de las imágenes para deslizar la línea y ver la transformación. Resultados auténticos de pacientes de Miradent.</p>
    </div>
</section>

<section class="casos-grid-container">
    <div class="container-premium">
        <?php if($casosExito->isNotEmpty()): ?>
        <div class="casos-grid">
            <?php $__currentLoopData = $casosExito; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="case-card fade-up" <?php echo 'style="animation-delay: ' . ($loop->index * 0.1) . 's;"'; ?>>
                <div class="compare-container" data-compare>
                    <!-- Imagen de fondo (DESPUÉS) -->
                    <img src="<?php echo e($caso->after_image); ?>" alt="Después: <?php echo e($caso->title); ?>" loading="lazy">

                    <!-- Imagen recortada superpuesta (ANTES) -->
                    <div class="compare-before-wrap">
                        <img src="<?php echo e($caso->before_image); ?>" alt="Antes: <?php echo e($caso->title); ?>" loading="lazy">
                    </div>
                    
                    <!-- Línea separadora -->
                    <div class="compare-handle">
                        <div class="compare-handle-grip">
                            <i data-lucide="move-horizontal" style="width:20px;height:20px;"></i>
                        </div>
                    </div>
                    
                    <div class="compare-badge antes">ANTES</div>
                    <div class="compare-badge despues">DESPUÉS</div>
                </div>

                <div class="case-card-body">
                    <h3><?php echo e($caso->title); ?></h3>
                    <p><?php echo e($caso->description_short); ?></p>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div style="text-align:center; padding: 80px 20px; background:#fff; border-radius:40px; border:1px solid var(--jade-100); max-width:800px; margin:0 auto; box-shadow:0 4px 20px rgba(0,0,0,0.03);">
            <div style="width:80px; height:80px; background:var(--jade-50); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 24px auto;">
                <i data-lucide="image" style="width:40px; height:40px; color:var(--jade-400);"></i>
            </div>
            <h3 style="font-size:2rem; font-weight:800; color:var(--jade-950); margin-bottom:16px; font-family:'Outfit', sans-serif;">Galería en construcción</h3>
            <p style="color:var(--jade-700); font-size:1.1rem; max-width:500px; margin:0 auto;">Estamos preparando nuevos casos de éxito para mostrarte. ¡Vuelve pronto!</p>
        </div>
        <?php endif; ?>

        <div class="casos-action fade-up" style="animation-delay: 0.4s;">
            <a href="<?php echo e(route('public.reservar-cita')); ?>" class="btn-reservar">
                <i data-lucide="calendar-check" style="width:24px;height:24px;"></i> Quiero resultados como estos
            </a>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('[data-compare]').forEach(function(container) {
            const beforeWrap = container.querySelector('.compare-before-wrap');
            const handle = container.querySelector('.compare-handle');
            if (!beforeWrap || !handle) return;

            // Follow mouse movement (hover effect)
            container.addEventListener('mousemove', e => {
                const rect = container.getBoundingClientRect();
                // Calcular porcentaje de izquierda a derecha (0 a 100)
                let p = ((e.clientX - rect.left) / rect.width) * 100;
                p = Math.max(0, Math.min(100, p)); // Limitar entre 0% y 100%
                
                handle.style.left = p + '%';
                beforeWrap.style.clipPath = `inset(0 ${100 - p}% 0 0)`;
            });

            // Fallback for touch screens
            container.addEventListener('touchmove', e => {
                const rect = container.getBoundingClientRect();
                const touch = e.touches[0];
                let p = ((touch.clientX - rect.left) / rect.width) * 100;
                p = Math.max(0, Math.min(100, p));
                
                handle.style.left = p + '%';
                beforeWrap.style.clipPath = `inset(0 ${100 - p}% 0 0)`;
            }, {passive: true});
            
            // Volver al centro cuando el mouse sale de la imagen
            container.addEventListener('mouseleave', () => {
                handle.style.transition = 'left 0.3s ease';
                beforeWrap.style.transition = 'clip-path 0.3s ease';
                handle.style.left = '50%';
                beforeWrap.style.clipPath = 'inset(0 50% 0 0)';
                
                setTimeout(() => {
                    handle.style.transition = '';
                    beforeWrap.style.transition = '';
                }, 300);
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\kalil\Desktop\miradent\resources\views/public_casos.blade.php ENDPATH**/ ?>